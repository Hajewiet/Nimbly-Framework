<?php

function merger_token($params) {

    /*
     * 1. Initialize
     */
    echo '<code>';

    $user = 'root';
    $pw = '';
    $host = 'localhost';
    $dbA = "dba";
    $dbB = "d7_devimpan";

    merger_log('', 'A:' . $dbA);
    merger_log('', 'B:' . $dbB);
    merger_log('start', 'A --(merge)--> B');

    $rules = array();

    /* $push_content = array (
      'context', 'date_format_type', 'date_formats',
      'field_config', 'field_config_instance', 'filter',
      'flag_content', 'flag_types', 'flags',
      'menu_custom', 'menu_links', 'node_type',
      'og_role', 'og_role_permission', 'rdf_mapping',
      'registry', 'registry_file', 'role', 'role_permission',
      'rules_config', 'rules_dependencies', 'rules_trigger',
      'system', 'views_display', 'views_view', 'wysiwyg'
      );*
     * 
     */
    $push_content = array(
            //    'views_display', 'views_view', 'role', 'role_permission'
    );

    $push_rows = array(
        'field_config' => array('field_name' => 'field_email_notification'),
        'field_config_instance' => array('field_name' => 'field_email_notification')
    );

    foreach ($push_content as $table) {
        $rules['content'][$table]['A']['push'] = true;
    }

    foreach ($push_rows as $table => $fields) {
        $rules['rows'][$table]['A']['push'] = $fields;
    }


    //open connections to both databases
    $dbc = mysqli_connect($host, $user, $pw);
    if (empty($dbc)) {
        return "could not connect to database";
    }

    /*
     * 2. Get table structure checksums
     */
    $set = array();
    foreach (array($dbA, $dbB) as $db) {
        $tables = $dbc->query("SHOW TABLES FROM " . $db);
        foreach ($tables as $record) {
            $table = current($record);
            //get structure checksum
            $checksum_struct_rec = $dbc->query("
                SELECT CRC32(GROUP_CONCAT(DISTINCT CONCAT_WS('--',c1.COLUMN_NAME,c1.COLUMN_TYPE,c1.IS_NULLABLE,c1.COLUMN_DEFAULT,c1.COLUMN_KEY,c1.EXTRA) SEPARATOR '==')) AS 'checksum'
                FROM information_schema.COLUMNS c1   
                    WHERE c1.TABLE_SCHEMA = '{$db}'    
                 AND c1.table_name = '{$table}'")->fetch_assoc();

            $set[$db][$table]['checksum_structure'] = $checksum_struct_rec['checksum'];
        }
    }

    //now we have a set with differences.. iterate and merge
    $action_count = 0;
    foreach ($set[$dbA] as $table => $meta) {
        $action_count++;
        if (!isset($set[$dbB][$table])) {
            //case 1: table exists in A and not in B. Copy the table structure
            merger_log($table, "A --(copy)---> B");
            $dbc->query("CREATE TABLE {$dbB}.{$table} LIKE {$dbA}.{$table}");
        } else if ($meta['checksum_structure'] != $set[$dbB][$table]['checksum_structure']) {
            //case 2: structure A differs from structure B. Alter table B
            merger_log($table, "A --(alter)--> B");
            $columns['tableA'] = $dbA . '.' . $table;
            $columns['tableB'] = $dbB . '.' . $table;
            $columns['A'] = $dbc->query("DESCRIBE {$dbA}.{$table}");
            $columns['B'] = $dbc->query("DESCRIBE {$dbB}.{$table}");
            _merger_alter($dbc, $columns);
        }
    }

    //second pass.. now that the structure is equalized, merge table content
    foreach ($set[$dbA] as $table => $meta) {
        if (empty($rules['content'][$table]['A'])
                || isset($rules['content'][$table]['A']['ignore'])) {
            continue;
        }
        if (empty($set[$dbB][$table])) {
            merger_log($table, "A --(content:copy)--> B");
            $dbc->query("INSERT INTO {$dbB}.{$table} SELECT * FROM {$dbA}.{$table}");
            continue;
        }

        //get content chacksum            
        $query = "CHECKSUM TABLE " . $dbA . "." . $table . ', ' . $dbB . '.' . $table;
        $query_result = $dbc->query($query);
        $checksum_recA = $query_result->fetch_assoc();
        $set[$dbA][$table]['checksum_content'] = $checksum_recA['Checksum'];
        $checksum_recB = $query_result->fetch_assoc();
        $set[$dbB][$table]['checksum_content'] = $checksum_recB['Checksum'];
        if ($checksum_recA['Checksum'] != $checksum_recB['Checksum']) {
            if (!empty($rules['content'][$table]['A']['push'])) {
                merger_log($table, "A --(content:push)--> B");
                $q1 = $dbc->query("DELETE FROM {$dbB}.{$table}");
                $q2 = $dbc->query("INSERT INTO {$dbB}.{$table} SELECT * FROM {$dbA}.{$table}");
                if ($q1 === false || $q2 === false) {
                    echo "fail: " . $dbc->error;
                }
            } else {
                merger_log($table, "A --(content:?)--> B");
            }
        }
    }

    //3rd pass.. push individual rows 
    //second pass.. now that the structure is equalized, merge table content
    foreach ($set[$dbA] as $table => $meta) {
        if (empty($rules['rows'][$table]['A'])) {
            continue;
        }
        if (empty($set[$dbB][$table])) {
            merger_log($table, "skipping pushing row (table does not exist in B) " . $table);
            continue;
        }
    }


    if ($action_count == 0) {
        merger_log('fail', 'A is empty');
    } else {
        merger_log('ready', 'A --(merge)--> B');
    }



    echo '</code>';

    $dbc->close();
}

function merger_log($table, $action = '?') {
    echo $action . ' ' . $table . '<br />';
}

function _merger_alter($dbc, $columns) {
    $fields = array();

    $alterTable = $columns['tableB'];

    foreach (array('A', 'B') as $set) {
        foreach ($columns[$set] as $record) {
            $field = $record['Field'];
            $fields[$set][$field] = array(
                'type' => $record['Type'],
                'null' => $record['Null'],
                'key' => $record['Key'],
                'default' => $record['Default'],
                'extra' => $record['Extra']
            );
            $fields[$set][$field]['checksum'] = md5(serialize($fields[$set][$field]));
        }
    }
    //find differences
    foreach ($fields['A'] as $fieldA => $metaA) {
        $fieldB = null;
        if (isset($fields['B'][$fieldA])) {
            $fieldB = $fieldA;
        } else {
            foreach ($fields['B'] as $fB => $metaB) {
                if ($metaB['checksum'] == $metaA['checksum']) {
                    if (empty($fields['A'][$fB])) {
                        $fieldB = $fB;
                        break;
                    }
                }
            }
        }

        if (empty($fieldB)) {
            //add field A as a new column in B and done
            merger_log('--' . $fieldA . '--(copy)--> ' . $fieldA, 'A --(alter)--> B   ');
            $alter_query = "ALTER TABLE {$alterTable} ADD `{$fieldA}` ";
        } else if ($fieldA != $fieldB) {
            //checksums match but the names don't match.. rename
            $metaB = $fields['B'][$fieldB];
            merger_log('--' . $fieldA . '--(rename)--> ' . $fieldB, 'A --(alter)--> B   ');
            $alter_query = "ALTER TABLE {$alterTable} CHANGE `{$fieldB}` `{$fieldA}` ";
        } else {
            $metaB = $fields['B'][$fieldB];
            if ($metaA['checksum'] == $metaB['checksum']) {
                //columns are equal
                continue;
            }
            //alter B so it matches A
            merger_log('--' . $fieldA . '--> ' . $fieldB, 'A --(alter)--> B   ');
            $alter_query = "ALTER TABLE {$alterTable} MODIFY `{$fieldA}` ";
        }
        $alter_query .= $metaA['type'] . ' ';
        if ($metaA['null'] == 'YES') {
            $alter_query .= ' NULL ';
        } else {
            $alter_query .= ' NOT NULL ';
        }
        if (isset($metaA['default'])) {
            $alter_query .= ' DEFAULT ' . "'" . $metaA['default'] . "'";
        }
        if (isset($metaA['extra'])) {
            if ($metaA['extra'] == 'auto_increment') {
                $alter_query .= ' AUTO_INCREMENT ';
            }
        }

        $qres = $dbc->query($alter_query);
        if ($qres === false) {
            echo "fail: ";
            echo $dbc->error;
        }

        if (isset($metaB['key']) && $metaA['key'] != $metaB['key']) {
            if ($metaA['key'] == 'MUL' && empty($metaB['key'])) {
                $dbc->query("ALTER TABLE {$alterTable} ADD INDEX(`$fieldA`)");
            }
        }
    }
}

?>
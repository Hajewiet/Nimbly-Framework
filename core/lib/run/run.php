<?php

define('sc_TAG_OPEN', '[');
define('sc_TAG_CLOSE', ']');
define('sc_ESCAPE_CHAR', '\\');
define('BUFFER_SIZE', 16384);
define('QUOT_CHAR', '"');
define('QUOTID', '%quot_');
define('ASSIGNMENT_CHAR', '=');

global $SYSTEM;
$SYSTEM['sc_stack'] = array();

/**
 * Executes a template from file, parsing it line by line replacing
 * any scs.
 * @param type $file filename of the template to run
 */
function run($file) {
    $fh = @fopen($file, "r");
    if ($fh === false) {
        return;
    }
    ob_start("run_output", BUFFER_SIZE);
    while (!feof($fh)) {
        run_template(fgets($fh));
    }
    ob_end_flush();
    fclose($fh);
}

/**
 * Callback function for ob_start, to finally output the buffer to the screen.
 * @param type $output the buffer
 * @return type string (the screen output)
 */
function run_output($buffer) {
    return $buffer;
}

/**
 * Run a uri and exit.
 * @param string $uri the path of the uri, e.g. css-demo/type
 */
function run_uri($uri) {
    $file = find_uri($uri);
    if ($file !== false) {
        /*
         * Found! Run the template and exit.
         */
        $GLOBALS['SYSTEM']['uri'] = $uri;
        $GLOBALS['SYSTEM']['uri_path'] = dirname($file);
        run($file);
        exit();
    }
    /*
     * Not found.. fallback to router 
     */
    load_library("router");
    if (router_run($uri)) {
        exit();
    }
    
    /*
     * Not routed either.. fallback to page not found error
     */
    run_uri("errors/404");
}

/**
 * Same as run, but runs a string/template
 * @param type $str the string which might contain scs. The string should not
 * be too large.
 */
function run_template($str) {
    if (empty($str)) {
        return;
    }

    $sc_start = strpos($str, sc_TAG_OPEN);

    /*
     * 1. If there are no scs in this string, it's a very easy case.
     * Just echo the string and done!
     */
    if ($sc_start === false) {
        echo $str;
        return;
    }
    $tail = substr($str, $sc_start + 1);

    if ($sc_start > 0) {
        $head = substr($str, 0, $sc_start); //the head part without scs

        /*
         * 2. Check if the sc is escaped, like this: \[sc]
         * In that case it is not a real sc ("false alarm")
         * and it does not require any special processing. 
         * Just echo sc and look for more scs in the remaining string.
         */


        if ($str{$sc_start - 1} == sc_ESCAPE_CHAR) {
            $head{$sc_start - 1} = sc_TAG_OPEN;
            echo $head;
            $sc_start = strpos($tail, sc_TAG_OPEN);
            if ($sc_start !== false) { //there are more scs...
                run_template($tail, $sc_start); //...so let's process them.
            } else {
                echo $tail; //otherwise,just output the tail; 
            }
            return;
        }
        echo $head;
    }


    $sub_levels = 0;
    do {
        $sc_end = strpos($tail, ']');

        /*
         * 3.  If the sc is not properly closed, e.g. "[sc" 
         * it's also not a real sc. Just output it and done. 
         */
        if ($sc_end === false) {
            echo sc_TAG_OPEN . $tail;
            return;
        }

        /*
         * 3a. Check for sub-scs and handle these first before continuing
         */

        $sub_sc_start = strpos($tail, '[');
        if ($sub_sc_start === false || $sub_sc_start > $sc_end) {
            break;
        }
        $sub_levels++;
        ob_start();
        run_template($tail);
        $tail = ob_get_contents();
        ob_end_clean();
    } while ($sub_sc_start !== false && $sub_levels < 10);


    /*
     * 4. At this point the sc syntax is valid.
     * Process this sc with the run_sc function and proceed with the next.
     */
    $sc_call = substr($tail, 0, $sc_end);
    run_single_sc($sc_call);

    /*
     * 5. Processing remaining string (tail) 
     */
    $tail = substr($tail, $sc_end + 1);
    if ($sc_start == 0) { //if a line only contains a sc, just return
        $trimmed_tail = rtrim($tail, "\n\r\0");
        if (empty($trimmed_tail)) {
            return;
        }
    } //otherwise, continue processing with a recursive call.
    run_template($tail);
}

/**
 * Helper function to place any quotes back in a string
 * @param type $str
 * @param type $quoted_parts
 */
function _recover_quoted_strings(&$str, &$quoted_parts = null) {
    if (!empty($quoted_parts)) {
        $quot_pos = strpos($str, QUOTID);
        if ($quot_pos !== false) {
            $quot_id = substr($str, $quot_pos);
            $quot = $quoted_parts[$quot_id];
            $str = str_replace($quot_id, $quot, $str);
        }
    }
}

/**
 * Run a sc
 * @param type $sc_call the sc id ("function") and possible parameters
 */
function run_single_sc($sc_call) {
    /*
     * 1. Normalize the sc call. Trim outer spaces, remove double spaces,
     * get parts between "quotes" (which can contain valid spaces).
     */

    global $SYSTEM;
    $call = trim($sc_call); //trim outer spaces
    if (strpos($call, QUOT_CHAR) > 0) { //handle quoted parts
        $quoted_parts = array();
        //preg_match_all('/' . ASSIGNMENT_CHAR . '[.]*"([^"\\\\]*[\\\\"]*[^"\\\\]*)"/s', $sc_call, $dq_matches);
        preg_match_all('/' . ASSIGNMENT_CHAR . '[.]*"([^"\\\\]*)"/s', $sc_call, $dq_matches);
        if (count($dq_matches) > 1) {
            $str_parts = $dq_matches[0];
            $str_vals = $dq_matches[1];
            for ($i = 0; $i < count($str_parts); $i++) {
                $quot_id = QUOTID . count($quoted_parts);
                $search = $str_parts[$i];
                $call = str_replace($search, ASSIGNMENT_CHAR . $quot_id, $call);
                $quoted_parts[$quot_id] = $str_vals[$i];
            }
        }
    }
    $call = preg_replace('!\s+!', ' ', $call); //remove double spaces

    /*
     * 2. Get the sc's function id and function parameters
     */
    $call_parts = explode(" ", $call);
    $function_id = $call_parts[0];
    $params = array();
    for ($i = 1; $i < count($call_parts); $i++) { //get parameters (if any)
        $param = $call_parts[$i];
        _recover_quoted_strings($param, $quoted_parts); //recover quoted values
        $assignment_pos = strpos($param, ASSIGNMENT_CHAR);
        if ($assignment_pos > 0) { //handle key-value pairs in syntax as: [sc key=value] 
            $param_id = substr($param, 0, $assignment_pos);
            $param_value = substr($param, $assignment_pos + 1);
            $params[$param_id] = $param_value;
        } else { //handle single parameters like "param" in: [sc param]
            $params[$param] = $param;
        }
    }

    /*
     * 3. If the sc function exists, run it and done.
     */
    $function_name = str_replace("-", "_", $function_id) . "_sc";
    if (function_exists($function_name)) {
        run_template($function_name($params));
        return;
    }

    /*
     * 4. Find a template implementing the sc, iterating
     * through the environments
     */
    if (count($params) == 0) {
        
        $path_tpl = find_template($function_id);
        if ($path_tpl !== false) {
            add_sc_level($function_id, $path_tpl);
            run($path_tpl);
            remove_sc_level();
            return;
        }
        
        if (isset($SYSTEM['variables'][$function_id])) {
            run_template($SYSTEM['variables'][$function_id]);
            return;
        }
    }

    /*
     * 5. Find a module implementing the sc, iterating
     * through the environments
     */
    $path_lib = load_library($function_id);
    if ($path_lib !== false && function_exists($function_name)) {
        add_sc_level($function_id, $path_lib);
        run_template($function_name($params));
        remove_sc_level();
        return;
    }

    /*
     * 6. If not found as template or as module, just echo the sc name
     */
    echo sc_TAG_OPEN . $function_id;
    foreach ($params as $key => $param) {
        if (is_numeric($key)) {
            echo " " . $param;
        } else {
            echo " " . $key . ASSIGNMENT_CHAR . $param;
        }
    }
    echo sc_TAG_CLOSE;
}

function add_sc_level($sc_name, $path) {
    global $SYSTEM;
    $levels = count($SYSTEM['sc_stack']);
    $SYSTEM['sc_stack'][$levels] = array($sc_name => $path);
}

function remove_sc_level() {
    global $SYSTEM;
    $levels = count($SYSTEM['sc_stack']) - 1;
    unset($SYSTEM['sc_stack'][$levels]);
}

/**
 * Helper function to get the value of a parameter.
 * @param type $params array of parameters
 * @param type $name name of parameter
 * @param type $default_value default value
 * @return type the param value or default value
 */
function get_param_value($params, $name, $default_value = null) {
    if (isset($params[$name])) {
        return $params[$name];
    }
    return $default_value;
}

/**
 * Helper function to get the value of a single parameter like param in [sc param]
 * @param type $params list of parameters
 * @param type $name name of parameter
 * @param type $value_exists value to return if it exists
 * @param type $default_value value to retun if it does not exist
 * @return type value_exists or default_value
 */
function get_single_param_value($params, $name, $value_exists, $default_value = null) {
    if (isset($params[$name])) {
        return $value_exists;
    }
    return $default_value;
}

function run_sc($params) {

    $tpl = get_param_value($params, "tpl", null);
    if (isset($tpl)) {
        $uri = dirname($tpl);
        $tpl_name = basename($tpl);
    } else {
        $uri = get_param_value($params, "uri", null);
        $tpl_name = "index.tpl";
    }
    if (!empty($uri) && $file = find_uri($uri, $tpl_name)) {
        global $SYSTEM;

        //remember original uri context
        $uri_original = $SYSTEM['uri'];
        $uri_path_original = $SYSTEM['uri_path'];

        //set new uri context
        $SYSTEM['uri'] = $uri;
        $SYSTEM['uri_path'] = dirname($file);

        //prevent infinite loop and run the template
        add_sc_level('run', $file);
        run($file);
        remove_sc_level('run', $file);

        //restore original uri context
        $SYSTEM['uri'] = $uri_original;
        $SYSTEM['uri_path'] = $uri_path_original;
        return;
    }
}

/**
 * Helper function to run a library sc
 * 
 */
function run_library($function_id, $params = null) {
    $function_name = str_replace('-', '_', $function_id) . "_sc";
    if (function_exists($function_name)) {
        run_template($function_name($params));
        return;
    }
    $path_lib = load_library($function_id);
    if ($path_lib !== false && function_exists($function_name)) {
        add_sc_level($function_id, $path_lib);
        run_template($function_name($params));
        remove_sc_level();
    }
}

/**
 * Same as run, but returns the string in stead of echo'ing it
 * @param type $file the file to run
 */
function run_buffered($file) {
    ob_start();
    run($file);
    $result = ob_get_contents();
    ob_end_clean();
    return $result;
}
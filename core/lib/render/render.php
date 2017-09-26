<?php

function render_sc($params) {
    load_libraries(["data", "set", "get", "md5", "session"]);
    $resource = get_param_value($params, "resource", ".blocks");
    $uuid = get_param_value($params, "uuid", md5_uuid(current($params)));
    $img_insert = get_param_value($params, "insert", false) !== false;
    $field = get_param_value($params, "field", count($params) > 1? next($params) : md5($uuid . 'block1'));
    $tpl = get_param_value($params, "tpl", count($params) > 2? next($params) : "plain_text");

    if (!data_exists($resource, $uuid)) {
        render_create_resource($resource, $uuid);
    }
    $content = data_read($resource, $uuid, $field);

    if (!$content) {
        $content = render_create_field($resource, $uuid, $field, $tpl);
    }
    if (session_user()) {
        if ($img_insert) {
            echo sprintf("<span data-edit-resource='%s' data-edit-uuid='%s' class='editor img-insert'>", $resource, $uuid);
            echo sprintf('<a href="#" class="editor add-img-icon" data-modal=\'{"url":"img-select", "uid":"(new)"}\'>+</a>');
        } else {
            echo sprintf("<span data-edit-resource='%s' data-edit-uuid='%s'>", $resource, $uuid);
        }
        render_block($field, $content, $tpl);
        echo "</span>";
    } else {
        render_block($field, $content, $tpl);
    }
}

function render_block($field, $content, $tpl) {
    if ($tpl === 'img') {
        render_img($field, $content);
        return;
    }
    set_variable('block-name', $field);
    set_variable('block-content', $content);
    $block_tpl = render_create_template($tpl);
    if (!session_user()) {
        run_template($block_tpl['tpl']);
        return;
    }
    $btns = "";
    if (!empty($block_tpl["buttons"])) {
        $btns = sprintf('data-edit-buttons="%s"', $block_tpl['buttons']);
    }
    echo sprintf('<%s data-edit-field="%s" data-edit-tpl="%s" %s>',
        $block_tpl['elem'] ?? 'div', $field, $block_tpl["name"], $btns);
    run_template($block_tpl['tpl']);
    echo sprintf('</%s>', $block_tpl['elem'] ?? 'div');
}

function render_img($field, $content) {
    if (!session_user()) {
        echo sprintf('<img src="%s/small">', $content);
        return;
    }
    echo sprintf('<img data-edit-img="%s" data-edit-tpl="img" src="%s/small" />',
        $field, $content);
}

function render_create_template($tpl_name) {
    $uuid = md5_uuid($tpl_name);
    if (data_exists(".block-templates", $uuid)) {
        return data_read(".block-templates", $uuid);
    }
    switch ($tpl_name) {
        case 'text':
            $btns = "bold,italic";
            break;
        case 'content':
            $btns = "bold,italic,anchor,quote,orderedlist,unorderedlist";
            break;
        default:
            $btns = "";
    }
    if (empty($btns)) {
        $tpl = sprintf("<span class='%1\$s' data-edit='[block-name]' data-tpl='%1\$s'>[block-content]</span>", $tpl_name);
    } else {
        $tpl = sprintf("<div class='%1\$s' data-edit='[block-name]' data-tpl='%1\$s' data-edit-buttons='%2$'>[block-content]</div>", $tpl_name, $btns);
    }

    data_create(".block-templates", $uuid, array(
        "name" => $tpl_name,
        "tpl" => "[block-content]",
        "buttons" => $btns
    ));
    return data_read(".block-templates", $uuid);
}

function render_create_resource($resource, $uuid) {
    if (data_exists($resource, $uuid)) {
        return;
    }
    data_create($resource, $uuid, array());
}

function render_create_field($resource, $uuid, $field, $tpl_name) {
    $data = data_read($resource, $uuid);
    if (!is_array($data)) {
        return;
    }
    $data[$field] = $tpl_name === 'img'? 'img/placeholder.png' : '[ipsum words=10]';
    data_create($resource, $uuid, $data);
    return $data[$field];
}

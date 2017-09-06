<?php

function render_sc($params) {
    load_libraries(["data", "set", "get", "md5", "session"]);
    $uuid = md5_uuid(get_param_value($params, "uuid", current($params)));
    $img_insert = get_param_value($params, "insert", false) !== false;
    if (!data_exists(".blocks", $uuid)) {
        // auto create a new render block for convenience
        render_create_defaults($uuid, get_param_value($params, "tpl", count($params) > 1? next($params) : "plain_text"));
   }
    $blocks = data_read(".blocks", $uuid);
    if (session_user()) {
        if ($img_insert) {
            echo sprintf("<span data-block='%s' class='editor img-insert'>", $uuid);
            echo sprintf('<a href="#" class="editor add-img-icon" data-modal=\'{"url":"img-select", "uid":"(new)"}\'>+</a>');
        } else {
            echo sprintf("<span data-block='%s'>", $uuid);
        }
        render_blocks($blocks);
        echo "</span>";
    } else {
        render_blocks($blocks);
    }
}

function render_blocks($blocks) {
    if (empty($blocks)) {
        return;
    }
    foreach ($blocks as $k => $block) {
        if (empty($block['tpl'])) {
            continue;
        }
        if ($block['tpl'] === 'img') {
            render_img($k, $block);
            continue;
        }
        set_variable('block-name', $k);
        if (empty($block['content'])) {
            set_variable('block-content', '');
        } else {
            set_variable('block-content', $block['content']);
        }
        $block_tpl = data_read(".block-templates", md5($block["tpl"]));
        if (!session_user()) {
            run_template($block_tpl['tpl']);
            return;
        }
        $btns = "";
        if (!empty($block_tpl["buttons"])) {
            $btns = sprintf('data-edit-buttons="%s"', $block_tpl['buttons']);
        }
        echo sprintf('<%s data-edit="%s" data-tpl="%s" %s>',
            $block_tpl['elem'] ?? 'div', $k, $block_tpl["name"], $btns);
        run_template($block_tpl['tpl']);
        echo sprintf('</%s>', $block_tpl['elem'] ?? 'div');
    }
}

function render_img($key, $block) {
    if (!session_user()) {
        echo sprintf('<img src="%s">', $block['content']);
        return;
    }
    echo sprintf('<img data-edit-img="%s" data-tpl="img" src="%s" />',
        $key, $block['content']);
}

function render_create_defaults($uuid, $tpl) {
    render_create_block_template($tpl);
    render_create_block($uuid, $tpl);
}

function render_create_block_template($tpl_name) {
    $uuid = md5_uuid($tpl_name);
    if (data_exists(".block-templates", $uuid)) {
        return;
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
    if (!empty($btns)) {
        $tpl = sprintf("<span class='%1\$s' data-edit='[block-name]' data-tpl='%1\$s'>[block-content]</span>", $tpl_name);
    } else {
        $tpl = sprintf("<div class='%1\$s' data-edit='[block-name]' data-tpl='%1\$s' data-edit-buttons='%2$'>[block-content]</div>", $tpl_name, $btns);
    }

    data_create(".block-templates", $uuid, array(
        "name" => $tpl_name,
        "tpl" => "[block-content]",
        "buttons" => $btns
    ));
}

function render_create_block($uuid, $tpl_name) {
    if (data_exists(".blocks", $uuid)) {
        return;
    }
    data_create(".blocks", $uuid,
        array(
            md5($uuid . 'block1') => array(
                "tpl" => $tpl_name,
                "content" => "[ipsum words=20]"
            )
        )
    );
}

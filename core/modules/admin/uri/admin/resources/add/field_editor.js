var field_editor = {};
field_editor.rows = 1;

field_editor.add_empty = function() {
    const me = field_editor;
    me.rows++;
    $('#field_entry').append(function() {
        var r = me.field_row.clone();
        r.removeClass("close");
        r.find("input.field_name").val('');
        r.find("input.button-delete").attr('data-close', "#row-" + me.rows);
        r.prop("id", "row-" + me.rows);
        return r;
    });
}

field_editor.init = function () {
    const me = field_editor;
    me.field_row = $("#field_entry div.row");
    $('#button-add-field').click(me.add_empty);
}

$script.ready('jquery', function() {
    field_editor.init();
});

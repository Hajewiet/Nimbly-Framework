var field_editor = {};
field_editor.fields = 1;

field_editor.add_empty = function() {
    const me = field_editor;
    me.fields++;
    $('#field_entry').append(function() {
        var r = me.field_row.clone();
        r.removeClass("nb-close");
        r.find("input.field_name").val('');
        r.find("input.nb-button-delete").attr('data-close', "#nb-field-" + me.fields);
        r.prop("id", "nb-field-" + me.fields);
        return r;
    });
}

field_editor.init = function () {
    const me = field_editor;
    me.field_row = $("#field_entry div.nb-field");
    $('#button-add-field').click(me.add_empty);
}

$script.ready('jquery', function() {
    field_editor.init();
});

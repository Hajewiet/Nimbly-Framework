<label>[field-name name="[item.name]"]:
    [if item.type=text tpl=text-field]
    [if item.type=date tpl=date-field]
    [if item.type=select tpl=select-field]
    [if item.type=password tpl=password-field]
</label>

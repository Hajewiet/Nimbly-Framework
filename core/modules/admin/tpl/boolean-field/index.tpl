<label class="label-inline">
    [set test-checked="[get record.[item.key]]"]
    <input type="checkbox" name="[item.key]" [if not test-checked=(empty) echo=checked] data-field-boolean="[item.key]">[field-name [get item.name]]
</label>

<label [if item.hidden=(not-empty) echo="class='nb-close'"]>[field-name name="[item.name]"]
    <select name="[item.key]">
        <option value="(empty)"></option>
        [data [item.resource]]
        [repeat data.[item.resource] tpl=option var=option]
    </select>
</label>

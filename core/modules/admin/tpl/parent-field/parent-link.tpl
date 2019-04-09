<label>[field-name name="[item.name]"]<br />
	<input type="hidden" name="[item.key]" value="[get record.[item.key]]" required />
	[module data]
	<a href="[base-url]/admin/[item.resource]/[get record.[item.key]]">[uuid2name [item.resource] [get record.[item.key]]]</a><br /><br />
</label>
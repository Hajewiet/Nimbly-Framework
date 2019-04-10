<label>[field-name name="[item.name]"]
    <input type="text" 
    	name="[item.key]" 
    	placeholder="" 
    	value="[get record.[item.key]]" 
    	[if item.pk=(not-empty) echo="data-live-pk='[get item.pk]'"]
    	[if item.auto_id=(not-empty) echo="data-live-id='[get item.auto_id]'"]
    	required />
</label>

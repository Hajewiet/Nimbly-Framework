<label>[field-name name="[item.name]"]
</label>
[set tmp.img=[get record.[item.key]] overwrite]
[if tmp.img=(empty) echo="<img data-edit-img='[item.key]' src='[base-url]/img/placeholder.png'>"]
[if not tmp.img=(empty) echo="<img data-edit-img='[item.key]' src='[base-url]/img/[tmp.img]/small'>"]


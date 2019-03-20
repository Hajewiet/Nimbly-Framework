[set gtmp.img=[get record.[item.key][x.key]] overwrite]
<tr class='nb-close'>
	[if not gtmp.img=(empty) echo="<td class='img-thumb'><img src='[base-url]/img/[gtmp.img]/tiny' data-empty=false data-edit-img='[item.key][x.key]' /></td><td>[nop lookup .files_meta uuid=[gtmp.img] name]</td>"]
	[if gtmp.img=(empty) echo="<td class='img-thumb'><img data-edit-img='[item.key][x.key]' data-empty=true src='[base-url]/img/placeholder.png'></td><td></td>"]
</tr>
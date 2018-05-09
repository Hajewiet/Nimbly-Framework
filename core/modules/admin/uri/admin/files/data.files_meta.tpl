<tr data-uuid="[item.uuid]">
      <td>
      	[if item.type="image/jpeg" tpl=img]
      </td>
      <td>[get item.name default="n/a"]</td>
      <td>[get item.type default="n/a"]</td>
      <td>
  	    [feature-cond features="delete_files,(any)_files" tpl="delete"]
        [feature-cond features="edit_files,(any)_files" tpl="edit"]
      </td>
</tr>

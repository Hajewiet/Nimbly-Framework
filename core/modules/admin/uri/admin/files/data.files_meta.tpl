<tr data-uuid="[item.uuid]">
  <td>
    [if item.type="image/jpeg" tpl=img]
    [if item.type="image/gif" tpl=img]
    [if item.type="image/png" tpl=img]
    [if item.type="application/pdf" tpl=pdf]
  </td>
  <td>[get item.name default="n/a"]</td>
  <td>[get item.type default="n/a"]</td>
  <td class="action-cell">
    [feature-cond features="manage-content,delete_files,(any)_files" tpl="delete"]
    [feature-cond features="manage-content,edit_files,(any)_files" tpl="edit"]
  </td>
</tr>

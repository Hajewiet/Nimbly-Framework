<tr data-uuid="[record.key]">
    [set uuid=[record.key] overwrite]
    [repeat data.fields tpl=data.record var=field]
    <td class="action-cell">
            [feature-cond features="manage-[data.resource],delete_[data.resource],(any)_[data.resource]" tpl="delete"]
            [feature-cond features="manage-[data.resource],edit_[data.resource],(any)_[data.resource]" tpl="edit"]
    </td>
</tr>

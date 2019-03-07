<tr data-uuid="[record.key]">
    [set uuid=[record.key] overwrite]
    [repeat data.fields tpl=data.record var=field]
    <td class="action-cell">
            [feature-cond features="delete_[data.resource],(any)_[data.resource]" tpl="delete"][feature-cond features="edit_[data.resource],(any)_[data.resource]" tpl="edit"]
    </td>
</tr>

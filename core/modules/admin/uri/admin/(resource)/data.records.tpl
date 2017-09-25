<tr data-uuid="[record.key]">
    [set uuid=[record.key] overwrite]
    [repeat data.fields tpl=data.record var=field]
    <td>
         <a
                data-confirm="[resource-name [data.resource]] [render-field-name] will be deleted! Are you sure?"
                data-delete="[data.resource]/[uuid]"
                data-done='{
                    "hide": "\[data-uuid=[uuid]]",
                    "msg": "[resource-name [data.resource]] [render-field-name] deleted successfully"
                }'>
                delete
            </a>
            <a href="[base-url]/admin/[data.resource]/[uuid]">edit</a>
    </td>
</tr>

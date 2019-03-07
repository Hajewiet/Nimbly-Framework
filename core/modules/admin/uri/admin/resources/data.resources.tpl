<tr data-uuid="[item.key]">
      <td><a href="[base-url]/admin/[item.name]">[item.name]</a></td>
      <td>[get item.count echo]</td>
      <td class="action-cell">
            <a class="nb-button icon-button delete"
                data-confirm="All [item.count] [item.name] will be deleted! Are you sure?"
                data-delete="[item.name]"
                data-done='{
                    "hide": "\[data-uuid=[item.key]]",
                    "msg": "Resource `[item.name]` deleted successfully"
                }'></a>
      </td>
</tr>

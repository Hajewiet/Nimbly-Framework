<tr data-uuid="[item.key]">
      <td>[item.route]</td>
      <td>[item.order]</td>
      <td>
            <a
                data-delete=".routes/[item.key]"
                data-done='{
                    "hide": "\[data-uuid=[item.key]]",
                    "msg": "Route `[item.route]` deleted successfully"
                }'>
                delete
            </a>
            <a href="[base-url]/admin/routes/[item.key]">edit</a>
      </td>
</tr>


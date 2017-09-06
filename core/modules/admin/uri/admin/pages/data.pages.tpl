<tr data-uuid="[md5 [item.url]]">
      <td><a href="[base-url]/[item.url]">[item.url][if item.url=(empty) echo="/ (home)"]</a></td>
      <td>[item.env]</td>
      <td>[item.module]</td>
      <td>
            [if item.env=ext item.module=root tpl=action.delete]
            [if item.env=ext item.module=root tpl=action.edit]
      </td>
</tr>

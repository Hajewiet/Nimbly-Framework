<h1>Resources</h1>
<a href="[base-url]/admin/resources/add" class="nb-button">Add Resource</a>
[get-resources]
<table class="nb-table">
  <thead>
    <tr>
      <th>Resource</th>
      <th>Instances</th>
      <th>&nbsp;</th>
    </tr>
  </thead>
  <tbody>
    <tr data-uuid="pages">
      <td colspan='3'><a href="[base-url]/admin/pages">pages</a></td>
    </tr>
    <tr data-uuid=".routes">
      <td colspan='3'><a href="[base-url]/admin/.routes">routes</a></td>
    </tr>
    <tr data-uuid="files">
      <td colspan='3'><a href="[base-url]/admin/files">files</a></td>
    </tr>


  [repeat data.resources]
  </tbody>
</table>

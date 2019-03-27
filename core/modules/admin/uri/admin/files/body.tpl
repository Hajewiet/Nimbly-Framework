<h1>Files</h1>
[feature-cond features="add_files,(any)_files,manage-content" tpl=add_button]
[data .files_meta sort=name|string|asc]
<table class="nb-table">
  <thead>
    <tr>
      <th>Thumb</th>
      <th>Name</th>
      <th>Type</th>
      <th>&nbsp;</th>
    </tr>
  </thead>
  <tbody>
  [repeat data.files_meta]
  </tbody>
</table>
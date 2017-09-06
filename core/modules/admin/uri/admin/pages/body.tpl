<section class="container">
    <a href="[base-url]/admin/pages/add" class="button">Add Page</a>
    [get-pages]
    <table>
      <thead>
        <tr>
          <th>URL</th>
          <th>Layer</th>
          <th>Module</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      [repeat data.pages]
      </tbody>
    </table>
</section>

<section class="nb-container">
    <h1>Pages</h1>
    <a href="[base-url]/admin/pages/add" class="nb-button">Add Page</a>
    [get-pages]
    <table class="nb-table">
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

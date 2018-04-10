<section class="nb-container">
    <h1>Routes</h1>
    <a href="[base-url]/admin/routes/add" class="nb-button">Add Route</a>
    [data .routes]
    <table class="nb-table">
      <thead>
        <tr>
          <th>Route</th>
          <th>Order</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      [repeat data.routes]
      </tbody>
    </table>
</section>

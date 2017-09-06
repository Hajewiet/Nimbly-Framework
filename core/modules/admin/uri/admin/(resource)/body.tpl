<section class="container">
    [feature_cond add_[data.resource] tpl=add_button]
    <table>
          <thead>
            <tr>
              [repeat data.fields var=field]
              [if data.fields=(empty) echo="<th>Name</th>"]
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          [repeat data.records var=record]
          </tbody>
    </table>
    [if data.records=(empty) echo="<p>No [data.resource] exist yet</p>"]
</section>

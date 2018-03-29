<section class="nb-container">
    [feature-cond features="add_[data.resource],(any)_[data.resource]" tpl=add_button]
    <table class="nb-table">
          <thead>
            <tr>
              [repeat data.fields var=field]
              [if data.fields=(empty) echo="<th>Name</th>"]
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          [repeat data.records var=record limit=250]
          </tbody>
    </table>
    [if repeat.limit=yes echo="<p>etc.</p>"]
    [if data.records=(empty) echo="<p>No [data.resource] exist yet</p>"]
</section>

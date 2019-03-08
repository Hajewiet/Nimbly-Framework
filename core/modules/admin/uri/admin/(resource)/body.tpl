<h1>[field-name [data.resource]]</h1>
[feature-cond features="manage-[data.resource],add_[data.resource],(any)_[data.resource]" tpl=add_button]
<table class="nb-table">
      <thead>
        <tr>
          [repeat data.fields var=field]
          [if data.fields=(empty) echo="<th>Name</th>"]
          <th>&nbsp;</th>
        </tr>
      </thead>
      <tbody>
      [repeat data.records var=record limit=250]
      </tbody>
</table>
[if repeat.limit=yes echo="<p>etc.</p>"]
[if data.records=(empty) echo="<p>No [data.resource] items yet.</p>"]

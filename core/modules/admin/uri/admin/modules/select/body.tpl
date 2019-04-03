<h1>Select contrib modules</h1>
<div id="scriptio" class="nb-close">
[setup-contrib-modules]
</div>
<p>
	Selected modules will be pulled from the module repository and installed in the contrib layer. 
	Unselected modules will be deleted. <br />
	<a href="#" data-toggle='#scriptio'>Show/hide script output</a>
</p>
<form action="[url]" method="post" accept-charset="utf-8" class="nb-form">
  [form-key select_modules]
  <label class="label-inline">
    Select modules:<br />
    [repeat data.modules tpl=module-check]
  </label>
  <button type="submit" class="nb-button">Save</button>
</form>


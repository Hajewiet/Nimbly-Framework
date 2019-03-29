<h1>Select contrib modules</h1>
[setup-contrib-modules]
<br />
<form action="[url]" method="post" accept-charset="utf-8" class="nb-form">
  [form-key select_modules]
  <label class="label-inline">
    Select modules to install:<br />
    <input type="checkbox" name="modules[]" value="pull" [if pull-check=(not-empty) echo="checked"]> Pull <br />
    <input type="checkbox" name="modules[]" value="blog" [if blog-check=(not-empty) echo="checked"]> Blog <br />
  </label>
  <button type="submit" class="nb-button">Install modules</button>
</form>
[debug variables]
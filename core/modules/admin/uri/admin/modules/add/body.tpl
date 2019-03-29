<h1>Pull contrib modules</h1>
[setup-contrib-modules]
<br />
<form action="[url]" method="post" accept-charset="utf-8" class="nb-form">
  [form-key select_modules]
  <label class="label-inline">
    Select modules to install:<br />
    [repeat data.modules tpl=module-check]
  </label>
  <button type="submit" class="nb-button">Install modules</button>
</form>
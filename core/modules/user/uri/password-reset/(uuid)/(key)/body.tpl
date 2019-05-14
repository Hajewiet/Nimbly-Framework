<h2>[page-title]</h2>
<p>Hi there [username]!<br />
Please type in your new password in the form below to complete the password reset.</p>
<form name="create-password" id="create-password" action="[url]" method="post" accept-charset="utf-8" class="nb-form" autocomplete="off">
    [form-key create-password]
    <label>Password
        <input type="password" maxlength="64" name="password" id="password" required />
    </label>
    <input type="submit" value="Create new password" class="nb-button"  />
    [form-error]
</form>
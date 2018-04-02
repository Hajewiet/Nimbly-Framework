<div class="container medium">
    <h1>Set password</h1>
    <form name="set-password" action="[url]?user=[get user]&key=[get key]" method="post" accept-charset="utf-8">

        [form-key set-password]

        <input type="hidden" name="key" value="[get key]" />
        <input type="hidden" name="go" value="[get go]" />

        <label>Email:
            <input type="email" name="user" value="[get user]" disabled />
        </label>

        <label>Create password:
            <input type="password" maxlength="64" name="password1" id="password1"
                   placeholder="Type a new password" value="" required  />
        </label>

        <label>Retype password:
            <input type="password" maxlength="64" name="password2" id="password2"
                   placeholder="Repeat password" required />
        </label>

        <input type="submit" value="Create password" class="button expanded"  />

            [form-error]
    </form>
</div>

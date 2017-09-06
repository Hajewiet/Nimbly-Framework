<div class="container medium">
        <form name="login" action="[url]" method="post" accept-charset="utf-8">
                [form-key login]
                <label>Email
                    <input type="text" maxlength="64" name="email" id="email"
                           placeholder="your email" value="[sticky email]" required />
                </label>

                <label>Password
                    <input type="password" maxlength="64" name="password" id="password"
                           placeholder="your password" required />
                </label>

                <input type="submit" value="Log In" class="button"  />

                [form-error]
        </form>
</div>


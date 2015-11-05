<div class='large-3 large-centered columns'>

    <h1>Login</h1>

    <form name="login" action="[url]" method="post" accept-charset="utf-8">

        [form-key login]
        [form-error]

        <label for="username">Name</label>  
        <input type="text" maxlength="64" name="username" id="username"  
               placeholder="your user name" value="[sticky username]" required />

        <label for="password">Password</label>  
        <input type="password" maxlength="64" name="password" id="password"
               placeholder="your password" required /> 
        <label>
            <input type="submit" value="Login" class="button"  /> 
        </label>
    </form>


</div>

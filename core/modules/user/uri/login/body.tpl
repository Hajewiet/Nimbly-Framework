<div class='large-3 large-centered columns'>

    <div class="login panel radius">
        <h1 class="panel-title">Login</h1>
        <form name="login" action="[url]" method="post" accept-charset="utf-8">

            [form-key login]
            [form-error]

            <label for="username">Name</label> 
            <div class="row collapse">
                <div class="small-2  columns">
                    <span class="prefix"><i class="fi-torso-female"></i></span>
                </div>
                <div class="small-10  columns">
                    <input type="text" maxlength="64" name="username" id="username"  
                           placeholder="your user name" value="[sticky username]" required />
                </div>
            </div>

            <label for="password">Password</label>  
            <div class="row collapse">
                <div class="small-2 columns ">
                    <span class="prefix"><i class="fi-lock"></i></span>
                </div>
                <div class="small-10 columns ">
                    <input type="password" maxlength="64" name="password" id="password"
                           placeholder="your password" required /> 
                </div>
            </div>

            <input type="submit" value="Login" class="button radius"  /> 
        </form>
    </div>
</div>

<div class="row">
    <div class="medium-6 medium-centered large-4 large-centered columns">
        <h1 class="panel-title">Login</h1>
        <form name="login" action="[url]" method="post" accept-charset="utf-8">
            <div class="row column log-in-form">

                [form-key login]
               

                <label>Name
                    <input type="text" maxlength="64" name="username" id="username"  
                           placeholder="your user name" value="[sticky username]" required />
                </label> 

                <label>Password
                    <input type="password" maxlength="64" name="password" id="password"
                           placeholder="your password" required /> 
                </label>  

                <input type="submit" value="Log In" class="button expanded"  /> 
                
                 [form-error]
            </div>
        </form>
    </div>
</div>
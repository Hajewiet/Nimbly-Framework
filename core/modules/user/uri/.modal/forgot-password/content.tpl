<h3 class="modal-caption">Forgot password?</h3>
<a data-close="#modal" class="icon-close">×</a>
<div class="signup-wrapper">
    <form name="forgot-password" action="[url]" method="post" accept-charset="utf-8">
        [form-key forgot-password]
        <label>
            Email<br>
            <input type="email" maxlength="64" name="email" id="email" placeholder="your email..." value="[sticky email]" required />
        </label>
        <a href='#' class="nb-button"class="button" data-submit="form[name=forgot-password]">
             Request new password
        </a> 
        [form-error]
    </form>
</div>
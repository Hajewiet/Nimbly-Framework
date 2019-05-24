<h3 class="modal-caption">Forgot password?</h3>
<a data-close="#modal" class="icon-close">×</a>
<div class="signup-wrapper">
    <form name="forgot-password" action="[url]" method="post" accept-charset="utf-8">
        [form-key forgot-password]
        <label>
            Email<br>
            <input type="email" maxlength="64" name="email" id="email" placeholder="your email..." value="[sticky email]" required />
        </label>
        <a href='#' 
            class="button"
            data-submit="form[name=forgot-password]"
            data-trigger="modal_password_reset"
        >
             Request new password
        </a> 
        [form-error]
    </form>
    <div id="password-reset-success-message" class="nb-close">
        <h2>Check your email!</h2>
        <p>Instructions to reset your password have been sent to your email address.</p>
    </div>
</div>

<script>
    $(document).on('modal_password_reset', function(e, data) {
        $('#modal form[name=forgot-password]').addClass('nb-close');
        $('#password-reset-success-message').removeClass('nb-close');
    });
</script>
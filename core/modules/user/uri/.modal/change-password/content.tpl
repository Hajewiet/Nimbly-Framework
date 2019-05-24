<h3 class="modal-caption">Create new password</h3>
<a data-close="#modal" class="icon-close">×</a>
<div class="form-wrapper">
    <form name="change-password" action="[url]" method="post" accept-charset="utf-8">
        [form-key change-password]
        <label>
            Your current password<br>
            <input type="password" maxlength="64" name="password" required />
        </label>
        <label>
            Type your new password. It has to be at least 6 characters long.<br>
            <input type="password" maxlength="64" name="newpw1" minlength=5 pattern=".{5,}"  required />
        </label>
        <label>
            Type again your new password<br>
            <input type="password" maxlength="64" name="newpw2" minlength=5 pattern=".{5,}"  required />
        </label>
        <a href='#' 
            class="button"
            data-submit="form[name=change-password]"
            data-trigger="modal_change_password"
        >
             Change password
        </a> 
        [form-error]
    </form>
</div>

<script>
    $(document).on('modal_change_password', function(e, data) {
        system_message('Password changed successfuly');
        modal.close();
    });
</script>
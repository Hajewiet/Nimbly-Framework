<h3 class="modal-caption">Change your email address</h3>
<a data-close="#modal" class="icon-close">×</a>
<div class="form-wrapper">
    <form name="change-email" action="[url]" method="post" accept-charset="utf-8">
        [form-key change-email]
        <label>
            Your current password<br>
            <input type="password" name="password" required />
        </label>
        <label>
            New email address<br>
            <input type="email" name="newemail" required />
        </label>
        <a href='#' 
            class="button"
            data-submit="form[name=change-email]"
            data-trigger="modal_change_email"
        >
             Change email
        </a> 
        [form-error]
    </form>
</div>
<div id="email-change-message" class="nb-close">
    <h2>Check your email!</h2>
    <p>You'll receive instructions on how to confirm your new email address.</p>
</div>

<script>
    $(document).on('modal_change_email', function(e, data) {
        $('#modal .form-wrapper').addClass('nb-close');
        $('#modal #email-change-message').removeClass('nb-close');
    });
</script>
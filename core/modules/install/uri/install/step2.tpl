<label>[text Enter your email]
    <input type="email" name="email" value="[sticky email]" required />
</label>

<label>[text Create a password]
    <input type="password" id="password" name="password" required >
</label>

<label>[text Enter Apache alias for base rewrite]
    <input type="text" maxlength="64" name="rewritebase" value="[sticky rewritebase default=[guess-alias]]"  />
</label>
<p class="help-text" id="rewritebasehelp">[text help_rewritebase]</p>

<label>[text Pepper code]
    <input type="text" maxlength="64" name="pepper" value="[sticky pepper default=[salt]]" required  />
    <span class="form-error close">
        [text pepper_required]
    </span>
</label>
<p class="help-text" id="rewritebasehelp">[text help_pepper]</p>

<div class="button-group">
    <input type="submit" name="submit" value="Next" class="primary button"  />
</div>

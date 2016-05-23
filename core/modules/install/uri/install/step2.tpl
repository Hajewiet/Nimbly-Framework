<label>[text Choose your username]
    <input type="text" maxlength="64" name="username" value="[sticky username]" required pattern="alpha_numeric" />
    <span class="form-error">
        [text username_required]
    </span>
</label> 

<label>[text Create a password]
    <input type="password" id="password" name="password" required pattern="alpha_numeric" >
    <span class="form-error">
        [text password_required]
    </span>
</label>

<label>[text Re-enter password]
    <input type="password" aria-describedby="pass2help" required pattern="alpha_numeric" data-equalto="password">
    <span class="form-error">
        [text passwords_no_match]
    </span>
</label>

<label>[text Enter Apache alias for base rewrite]
    <input type="text" maxlength="64" name="rewritebase" value="[sticky rewritebase default=[guess-alias]]" aria-describedby="rewritebasehelp" />
</label> 
<p class="help-text" id="rewritebasehelp">[text help_rewritebase]</p>

<label>[text Pepper code]
    <input type="text" maxlength="64" name="pepper" value="[sticky pepper default=[salt]]" required aria-describedby="pepperhelp" />
    <span class="form-error">
        [text pepper_required]
    </span>
</label> 
<p class="help-text" id="rewritebasehelp">[text help_pepper]</p>

<div class="button-group">
    <input type="submit" name="submit" value="Previous" class="secondary button"  /> 
    <input type="submit" name="submit" value="Next" class="primary button"  /> 
</div>
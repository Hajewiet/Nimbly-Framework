<div id="top-bar-fixed">
        <a class="button icon-button" data-toggle="#off-left-panel"><span class="icon-nav"></span></a>
        <h1 class="top-center">
            [if bar-title=(not-empty) tpl=bar-title]
            [if bar-title=(empty) tpl=page-title]
        </h1>
        [role-cond user tpl=user-button]
        [feature-cond edit tpl=edit-button]
</div>

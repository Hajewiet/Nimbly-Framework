<ul class="nb-menu">
    <li><a href="[base-url]/">Site home</a></li>
</ul>
<ul class="nb-menu">
    [get-user-resources]
	[repeat data.user-resources]
</ul>
[feature-cond admin tpl=admin-menu]
[feature-cond edit tpl=edit-menu]
<ul class="nb-menu">
    <li><a href="[base-url]/logout">Logout</a></li>
</ul>


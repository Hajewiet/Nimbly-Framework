<ul class="nb-menu">
    <li><a href="[base-url]/admin/resources">Resources</a></li>
    [get-user-resources]
	[repeat data.user-resources]
</ul>
<ul class="nb-menu">
	[set admin-menu-extend=]
    [admin-menu-extend]
	<li><a href="[base-url]/admin/debug">Debug</a></li>
</ul>
<ul class="nb-menu light nb-close" id="edit-menu">
    <li data-edit-on><a href="#">Edit Mode</a></li>
    <li data-edit-off><a href="#">View Mode</a></li>
    <li data-edit-save><a href="#">Save Content</a></li>
</ul>
<ul class="nb-menu">
    <li><a href="[base-url]/logout">Logout</a></li>
</ul>


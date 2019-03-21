<h1>System Maintenance</h1>

<p>
Disk space available: [disk-space-free]Gb</br>
Disk space total: [disk-space-total]Gb

<ul>
	<li>
		<a href='[base-url]/admin/resources'>Resources</a>
		<p>Overview of all resources.</p>
	</li>
	<li>
		<a href='[base-url]/admin/.block-templates'>Block Templates</a>
		<p>Manage the editor buttons for different block templates.</p>
	</li>
	<li>
		<form id='ccache' action="[url]" method="post" accept-charset="utf-8">
			[form-key ccache]
			<a href='#' data-submit-std="#ccache" data-confirm="Press OK to continue and clear cache.">Clear cache</a>
		<form>
		<p>Clears server-side javascript and css cache.</p>
	</li>

	 <li>
	 	<a href='[base-url]/admin/debug'>Debug</a>
	 	<p>Show Nimbly system info, including current set variables, session and <a href='[base-url]/admin/debug/php'>PHP Info</a>.</p>
	 </li>

	<li>
		<a href='[base-url]/admin/shortcodes'>Shortcodes</a>
		<p>Overview of shortcodes with description of what they do.</p>
	</li>
	<li>
		<a href='[base-url]/admin/reinstall'>Reinstall Nimbly Core</a>
		<p>Reinstall to update .htaccess; resets admin and editor role.</p>
	</li>
	[admin-menu-extend]
</ul>

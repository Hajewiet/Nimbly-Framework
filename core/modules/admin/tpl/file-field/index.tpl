<label>[field-name name="[item.name]"]</label>
<a href='#' class="nb-button" data-upload='{"preview": ".nb-single-file-preview.nb-upload-[item.key]", "autoselect": "true"}'>
	Upload
</a>
<div class="nb-single-file-preview nb-upload-[item.key]"></div>
<div class="nb-close" data-edit-field="[item.key]" data-edit-tpl="plain_text" id='nb-file-uuid-[item.key]'></div>
<div id='nb-file-name-[item.key]'>[lookup .files_meta [get record.[item.key]] name]</div>

<script>
	$script.ready('jquery', function() {
		$('body').on('autoselect', function (e, opts) {
			$('#nb-file-uuid-[item.key]').text(opts.uuid);
			$('#nb-file-name-[item.key]').text(opts.name);
		});
	});
</script>
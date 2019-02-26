
<a href='#' class="nb-button" data-upload='{"preview": "#nb-single-file-preview", "autoselect": "true"}'>Upload</a>
<div id="nb-single-file-preview"></div>

<template id="nb-row">
	<tr data-uuid="(uuid)">
		<td>
			<img src="[base-url]/img/(uuid)/100x50f">
		</td>
		<td>(name)</td>
		<td>(type)</td>
		<td>
			<a
				data-confirm="File `(name)` will be deleted! Are you sure?"
				data-delete=".files/(uuid)"
				data-done='{
				"hide": "\[data-uuid=(uuid)]",
				"msg": "File `(name)` deleted successfully"
				}'>
				delete
			</a>

			<a href="[base-url]/admin/files/(uuid)">edit</a>

		</td>
	</tr>
</template>

<script>
	$script.ready('jquery', function() {
		[include [cur-path]/handle_upload.js]
	});
</script>


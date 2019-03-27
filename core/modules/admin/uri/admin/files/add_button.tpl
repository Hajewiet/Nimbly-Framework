<a href='#' class="nb-button" data-upload='{"trigger": "file_upload"}'>Upload</a>

<template id="tpl-upload-row">
	<tr data-uuid="((uuid))" class="file-upload-row">
		<td class="file-upload-row-img">
			<img src="[empty-img]" height=50>
		</td>
		<td class="file-upload-row-name">
			<div style="position:relative; height: 20px;" class="progress-wrapper nb-close">
				<div class="progress-bar-bg">
					<div class="progress-bar" style="width:0%");></div>
				</div>
				<div class="progress-bar-text"></div>
			</div>
			((name))
		</td>
		<td class="file-upload-row-type">((type))</td>
		<td class="file-upload-row-buttons">
			<a class="nb-button nb-close icon-button delete"
				data-confirm="File `((name))` will be deleted! Are you sure?"
				data-delete=".files/((uuid))"
				data-done='{
				"hide": "\[data-uuid=((uuid))]",
				"msg": "File `((name))` deleted successfully"
				}'></a>

			<a class="nb-button nb-close icon-button edit" href="[base-url]/admin/files/((uuid))"></a>

		</td>
	</tr>
</template>

<script>
	$script.ready('edit', function() {
		[include [uri-path]/handle_upload.js]
	});
</script>


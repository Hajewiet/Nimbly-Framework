<label>[field-name name="[item.name]"]</label>

<table class="nb-table" id="gallery_[record.uuid]">
	<thead></thead>
	<tbody class="nb-sortable"></tbody>
	<tfoot>
		<tr>
			<td colspan=4 id="[item.name]_upload">
				<div style="position:relative; height: 20px; margin-bottom: 20px;" class="progress-wrapper nb-close">
					<div class="progress-bar-bg">
						<div class="progress-bar" style="width:0%");></div>
					</div>
					<div class="progress-bar-text"></div>
				</div>
				<button class="nb-button" data-upload='{"trigger": "[item.name]_upload"}'>Upload photo</button>
				<button class="nb-button" id="[item.name]_select" data-modal='{"url": "img-select", "uid": "[item.name]_select"}'>Select photo</button>
			</td>
		</tr>
	</tfoot>
</table>

<template id="tpl_gallery_[record.uuid]_row">
	<tr class="gallery-image-row">
		<td>((img_nr))</td>
		<td>
			<img src='[empty-img]' 
				data-empty=false 
				data-edit-img='((field_name))' 
				data-img-uuid=((img_uuid))
				data-img-mode='fit' style="height:100px; width: 150px;" />
		</td>
		<td>
			((img_name))
		</td>
		<td>
			<a href='#' class='nb-button icon-button nb-icon-up' data-move-up></a>
			<a href='#' class='nb-button icon-button nb-icon-down' data-move-down></a>
		</td>
	</tr>
</template>

<script>

$script.ready('app', function() {

if (typeof window.gallery_js_loaded === 'undefined') {
	[include [get-path]/gallery_field.js];
	$script('https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js', 'jqueryui');
}

window.gallery_js_loaded = true;
$script.ready(\['jqueryui', 'edit'], function() {
	gallery_field.init([get-gallery-json uuid=[record.uuid] name=[item.name] max=[item.max]]);	
});

});	

</script>
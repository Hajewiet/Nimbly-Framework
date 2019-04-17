<h3 class="modal-caption">Select image</h3>
<a class="nb-button" data-upload='{"trigger": "modal_img_select"}'>Upload</a>
<table class="nb-table" data-select>
    [data .files_meta filter=type:image/jpeg||image/png||image/gif]
    [repeat data.files_meta tpl=select-image]
</table>
<template id='tpl-modal-img-select-row'>
	<tr data-uuid="((uuid))" data-name="((name))" class="file-upload-row">
	    <td class="img-thumb"><img src="[base-url]/img/((uuid))/tiny" /></td>
	    <td class="img-name">
	    	<div style="position:relative; height: 20px;" class="progress-wrapper nb-close">
				<div class="progress-bar-bg">
					<div class="progress-bar" style="width:0%");></div>
				</div>
				<div class="progress-bar-text"></div>
			</div>
	    	((name))
	    </td>
	</tr>
</template>

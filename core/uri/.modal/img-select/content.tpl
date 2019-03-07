<h3 class="modal-caption">Select image</h3>
<a data-close="#modal" class="icon-close">×</a>
<a class="nb-button" data-upload='{"preview": true, "trigger": "autoselect"}'>Upload</a>
<div class="nb-img-grid" data-select>
    [data .files_meta filter=type:image/jpeg||image/png||image/gif]
    [repeat data.files_meta tpl=select-image]
</div>

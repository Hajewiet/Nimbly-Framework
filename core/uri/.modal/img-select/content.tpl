 <h3 class="modal-caption">Select image</h3>
 <a data-close="#modal" class="icon-close">×</a>
<a class="button" data-upload='{"preview": "#modal .img-grid", "autoselect": "true"}'>Upload</a>
<div class="img-grid" data-select>
    [data .files_meta]
    [repeat data.files_meta tpl=select-image]
</div>

<h3 class="modal-caption">Select image</h3>
<a data-close="#modal" class="icon-close">×</a>
<a class="nb-button" data-upload='{"preview": "#modal .nb-img-grid", "autoselect": "true"}'>Upload</a>
<div class="nb-img-grid" data-select>
    [data .files_meta]
    [repeat data.files_meta tpl=select-image]
</div>

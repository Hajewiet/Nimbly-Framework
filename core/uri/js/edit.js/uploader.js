var uploader = {};

uploader.count = 0;

uploader.init_uploader = function(elem, uid) {
    var settings = elem.data('upload');
    console.log('uploader.init_uploader', elem, uid, settings);
    opts = {
        'uid': uid,
        'field': settings.field,
        'elem': elem,
        'file_reader': new FileReader(),
        'preview': !!settings.preview
    }
    opts.file_reader.onload = function(e) {
        uploader.handle_load(e, opts);
        elem.prop('disabled', true);
    }
    elem.attr('id', uid);
    elem.after('<input type="file" name="file" id="' + uid + '-file" class="nb-close">');
    $('#' + uid + '-file').change(function(e) {
        uploader.handle_change(e, opts);
    });
}

uploader.remove_preview = function(opts) {
    $('#' + opts.uid + '-preview').remove();
}

uploader.add_preview = function(opts) {
    uploader.remove_preview(opts);
    if (!opts.preview) {
        return;
    }
    var uid = opts.uid;
    opts.elem.after('<div id="' + uid + '-preview" class="uploader img-wrapper"></div>');
    $('#' + opts.uid + '-preview')
        .append('<div class="nb-close" data-field="' + opts.field + '"></div>')
        .append($('<img>',{id: opts.uid + '-img', src:opts.img_preview }))
        .append('<div class="progress-bar-bg nb-close" id="' + uid + '-bg"><div class="progress-bar" id="' + uid + '-bar"></div></div>')
        .append('<div class="progress-bar-text nb-close" id="' + uid + '-msg">Uploading</div>')
        .append('<a id="' + uid + '-clear" data-uid="' + uid + '" href="javascript:void(0)" data-onclick="uploader_clear_img" class="clear-img-icon nb-button icon-button delete"></a>');
}

function uploader_clear_img(e) {
    uploader.clear_img(e);
}

uploader.clear_img = function(e) {
    var uid = $(e.target).data('uid');
    uploader.remove_preview({"uid": uid});
    $('#' + uid).prop('disabled', false);
}

uploader.handle_change = function(e, opts) {
    console.log('uploader.handle_change', e, opts);
    var files = e.target.files || e.dataTransfer.files;
    if (!files || files.length !== 1) {
        return;
    }
    var file = files[0];
    opts.file_reader.readAsDataURL(file);
    uploader.set_progress(opts.uid, 0, 'Uploading');
    uploader.upload_file(opts, file);
}

uploader.handle_load = function(e, opts) {
    console.log('handle_load', e, opts);
    opts.img_preview = e.target.result;
    elem = $(opts.elem);
    if (elem.is('img')) {
        elem.attr('src', e.target.result);
    } else if (opts.preview) {
        uploader.add_preview(opts);
    }
}

uploader.set_progress = function(uid, progress, msg) {
    $('#' + uid + '-bg').removeClass('nb-close');
    $('#' + uid + '-bar').removeClass('nb-close').css('width', progress + '%');
    $('#' + uid + '-msg').removeClass('nb-close').text(msg);
}

uploader.unique_id = function() {
    uploader.count++;
    return "uploader-" + uploader.count;
}

uploader.upload_file = function(opts, file) {
    var formData = new FormData();
    formData.append('file', file);
    $.ajax({
        url: base_url + '/api/v1/.files',
        type: 'POST',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        xhr: function() {
            var myXhr = $.ajaxSettings.xhr();
            if (myXhr.upload) {
                myXhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        uploader.set_progress(opts.uid, parseInt(100 * e.loaded / e.total), 'Uploading');
                    }
                }, false);
            }
            return myXhr;
        }
    }).done(function(json) {
            uploader.set_progress(opts.uid, 100, 'Uploaded');
            $('#preview_' + opts.uid).attr('data-uuid', json.files.uuid);
            if (opts.autoselect) {
                $('#preview_' + opts.uid).trigger('autoselect', json.files);
            }
    }).fail(function() {
        uploader.set_progress(opts.uid, 0, 'Failed');
    });
}

$('body').on('click', '[data-upload]', function(e) {
    e.preventDefault();
    $this = $(this);
    if ($this.prop('disabled')) {
        return;
    }
    var uid = uploader.unique_id();
    uploader.init_uploader($this, uid);
    $('#' + uid + '-file').click();
});

var uploader = {};

uploader.count = 0;

uploader.init_uploader = function(elem, uid) {
    var init_done = $(this).data('uid');
    opts = elem.data('upload');
    elem.attr('id', 'preview-' + uid);
    if (!opts) {
        uploader.wrap_progress_bar(elem, uid);
        opts = {"preview":"#preview-" + uid }
    }
    opts['uid'] = uid;
    elem.after('<input type="file" name="file" id="' + uid + '" class="nb-close">');
    opts.file_reader = new FileReader();
    opts.file_reader.onload = function(e) {
        uploader.handle_load(e, opts);
        elem.prop('disabled', true);
    }
    $('#' + uid).change(function(e) {
        uploader.handle_change(e, opts);
    });
}

uploader.wrap_progress_bar = function(elem, uid) {
    var p = elem.parent();
    if (p.is('div .uploader.img-wrapper')) {
        p.find('div.progress-bar-bg,div.progress-bar-text,div.progress-bar').remove();
        elem.unwrap();
    }
    elem.wrap('<div class="uploader img-wrapper"></div>');
    elem.after('<div class="progress-bar-bg nb-close" id="' + uid + '-bg"><div class="progress-bar" id="' + uid + '-bar"></div></div>');
    elem.after('<div class="progress-bar-text nb-close" id="' + uid + '-msg">Uploading</div>');
}

uploader.handle_change = function(e, opts) {
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
    elem = $(opts.preview);
    if (elem.is('img')) {
        elem.attr('src', e.target.result);
    } else {
        elem.prepend($('<img>',{id: 'preview_' + opts.uid, src:e.target.result }));
        uploader.wrap_progress_bar($('#preview_' + opts.uid), opts.uid);
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
    var r = $('#' + uid).click();
});

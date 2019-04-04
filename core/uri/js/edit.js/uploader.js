var uploader = {};

uploader.count = 0;

uploader.init_uploader = function(elem, uid) {
  if (elem.data('uid') === uid) {
    return;
  }
  var settings = elem.data('upload');
  opts = {
    uid: uid,
    field: settings.field,
    elem: elem,
    file_reader: new FileReader(),
    preview: !!settings.preview,
    trigger: settings.trigger,
  };
  opts.file_reader.onload = function(e) {
    uploader.handle_load(e, opts);
    elem.prop('disabled', true);
  };
  elem.attr('id', uid);
  elem.data('uid', uid);
  elem.after( // todo: also work with input type=file and support drag/drop
    '<input type="file" name="file" id="' + uid + '-file" class="nb-close">'
  );
  if (opts.field) {
    elem.after(
      '<div id="' +
        uid +
        '-field" class="nb-close" data-edit-field="' +
        opts.field +
        '"></div>'
    );
  }
  $('#' + uid + '-file').change(function(e) {
    uploader.handle_change(e, opts);
  });
};

uploader.remove_preview = function(opts) {
  $('#' + opts.uid + '-preview').remove();
};

uploader.clear_field = function(opts) {
  $('#' + opts.uid + '-field').text('');
}

uploader.add_preview = function(opts) {
  uploader.remove_preview(opts);
  if (!opts.preview) {
    return;
  }
  var uid = opts.uid;
  opts.elem.after(
    '<div id="' + uid + '-preview" class="uploader img-wrapper"></div>'
  );
  $('#' + opts.uid + '-preview')
    .append($('<img>', { id: opts.uid + '-img', src: opts.img_preview }))
    .append(
      '<div class="progress-bar-bg nb-close" id="' +
        uid +
        '-bg"><div class="progress-bar" id="' +
        uid +
        '-bar"></div></div>'
    )
    .append(
      '<div class="progress-bar-text nb-close" id="' +
        uid +
        '-msg">Uploading</div>'
    )
    .append(
      '<a id="' +
        uid +
        '-clear" data-uid="' +
        uid +
        '" href="javascript:void(0)" data-onclick="uploader_clear_img" class="clear-img-icon nb-button icon-button delete"></a>'
    );
};

uploader.trigger = function(opts, event, data=false) {
  if (opts.trigger) {
    $(document).trigger(opts.trigger, {'event': event, 'data': data});
  }

}

function uploader_clear_img(e) {
  uploader.clear_img(e);
}

uploader.clear_img = function(e) {
  var uid = $(e.target).data('uid');
  uploader.remove_preview({ uid: uid });
  uploader.clear_field({ uid: uid});
  $('#' + uid).prop('disabled', false);
};

uploader.handle_change = function(e, opts) {
  var files = e.target.files || e.dataTransfer.files;
  if (!files || files.length !== 1) {
    return;
  }
  var file = files[0];
  opts.file_reader.readAsDataURL(file);
  uploader.set_progress(opts, 0, 'Uploading');
  uploader.upload_file(opts, file);
};

uploader.handle_load = function(e, opts) {
  opts.img_preview = e.target.result;
  elem = $(opts.elem);
  if (elem.is('img')) {
    elem.attr('src', e.target.result);
  } else if (opts.preview) {
    uploader.add_preview(opts);
  }
  uploader.trigger(opts, 'preview', opts.img_preview);
};

uploader.set_progress = function(opts, progress, msg) {
  var uid = opts.uid;
  $('#' + uid + '-bg').removeClass('nb-close');
  $('#' + uid + '-bar')
    .removeClass('nb-close')
    .css('width', progress + '%');
  $('#' + uid + '-msg')
    .removeClass('nb-close')
    .text(msg);
  uploader.trigger(opts, 'progress', { 'pct': progress, 'msg': msg });
};

uploader.unique_id = function($uploader) {
  if ($uploader.data('uid')) {
    return $uploader.data('uid');
  }
  uploader.count++;
  return 'uploader-' + uploader.count;
};

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
        myXhr.upload.addEventListener(
          'progress',
          function(e) {
            if (e.lengthComputable) {
              uploader.set_progress(
                opts,
                parseInt((100 * e.loaded) / e.total),
                'Uploading'
              );
            }
          },
          false
        );
      }
      return myXhr;
    },
  }).done(function(json) {
      uploader.set_progress(opts, 100, 'Done');
      if (opts.field) {
        $('#' + opts.uid + '-field').text(json.files.uuid);
      }
      uploader.trigger(opts, 'done', json.files);
    })
    .fail(function() {
      uploader.set_progress(opts, 0, 'Failed');
      uploader.trigger(opts, 'fail');
    });
};

$('body').on('click', '[data-upload]', function(e) {
  e.preventDefault();
  $this = $(this);
  if ($this.prop('disabled')) {
    return;
  }
  var uid = uploader.unique_id($this);
  uploader.init_uploader($this, uid);
  $('#' + uid + '-file').click();
});

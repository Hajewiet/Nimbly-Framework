var row_uploader = {};

row_uploader.init = function() {
	if (row_uploader.init_done) {
		return;
	}
	$table = $('table tbody');
	var ctx = {
		"uuid": "new",
		"name": "",
		"type": ""
	}
	var html = nb_populate_template('tpl-upload-row', ctx);
	$table.prepend(html);
	row_uploader.init_done = true;
};

row_uploader.reset = function() {
	$('.file-upload-row').removeClass('file-upload-row');
	$('a.nb-button[data-upload]').prop('disabled', false);
	row_uploader.init_done = false;
}

row_uploader.handle_upload_event = function(data) {
	row_uploader.init();
	$urow = $('tr.file-upload-row:first');
	if (data.event === 'preview') {
		$urow.find('img').attr('src', data.data);
	} else if (data.event === 'progress') {
		$urow.find('div.progress-wrapper').removeClass('nb-close');
		$urow.find('div.progress-bar').css('width', data.data.pct + '%');
		$urow.find('div.progress-bar-text').text(data.data.msg);
	} else if (data.event === 'done') {
		var html = nb_populate_template('tpl-upload-row', data.data);
		$urow = $urow.replaceWith(html);
		$img = $('.file-upload-row .file-upload-row-img img');
		$img.attr('src', base_url + '/img/' + data.data.uuid + '/100x50f');
		$('.file-upload-row .file-upload-row-buttons .nb-close').removeClass('nb-close');
		row_uploader.reset();
	} else if (data.event === 'fail') {
		row_uploader.reset();
	} else {
		console.log('unknown event', data);
	}
};

$(document).on('file_upload', function(e, data) {
	row_uploader.handle_upload_event(data);
});
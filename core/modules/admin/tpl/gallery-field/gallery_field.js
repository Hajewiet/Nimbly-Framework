var gallery_field = {};

gallery_field.init = function(opts) {
	opts.tpl_id = 'tpl_gallery_' + opts.uuid + '_row';
	opts.ix = [];
	var $table = $('#gallery_' + opts.uuid + ' tbody' + '.nb-sortable');
	$table.data('opts', opts);
	for (x in opts.images) {
		var row_ctx = gallery_field.data_context(opts, x);
		var row_html = nb_populate_template(opts.tpl_id, row_ctx);
		$table.append(row_html);
		opts.ix[x] = parseInt(x);
	}
	$table.sortable();
	$table.on('sortstop', { 'opts' : opts }, gallery_field.on_sortstop);
	$(document).on('clear-img', function(e, opts) {
		gallery_field.remove_img($table, opts.uuid);
	});
	$table.on('click', 'a[data-move-up]', gallery_field.move_up);
	$table.on('click', 'a[data-move-down]', gallery_field.move_down);
	gallery_field.refresh($table);
}

gallery_field.data_context = function(opts, x) {
	var img_nr = parseInt(x) + 1;
	return {'img_nr': img_nr, 'img_uuid': opts.images[x], 'field_name': opts.name + img_nr, 'img_name': opts.image_names[x]}
}

gallery_field.on_sortstop = function(e, ui) {
	$table = $(e.target);
	gallery_field.reorder($table, e.data.opts);
}

gallery_field.reorder = function($table) {
	$table.find('tr').each(function(ix) {
		var $row = $(this);
		var num = gallery_field.row_num($row);
		if (num !== (ix+1)) {
			var y = num-1;
			if (ix < y) {
				gallery_field.swap_data($table, ix, y);
			}
		}
	});
	gallery_field.refresh($table);
}

gallery_field.row_num = function($row) {
	return parseInt($row.find('td:first').text());
}

gallery_field.swap_data = function($table, x, y) {
	var opts = $table.data('opts');
	var t1 = opts.images[x];
	var t2 = opts.image_names[x];
	var t3 = opts.ix[x];
	opts.images[x] = opts.images[y];
	opts.image_names[x] = opts.image_names[y];
	opts.ix[x] = opts.ix[y];
	opts.images[y] = t1;
	opts.image_names[y] = t2;
	opts.ix[y] = t3;
	$table.data('opts', opts);
}

gallery_field.update_row = function($table, $row, ix) {
	console.log('gallery_field.update_row', $row, ix);
	var opts = $table.data('opts');
	var row_ctx = gallery_field.data_context(opts, ix)
	$row.replaceWith(nb_populate_template(opts.tpl_id, row_ctx));
	opts.ix[ix] = ix;
}

gallery_field.remove_img = function($table, uuid) {
	$row = $table.find('tr:has(img[data-img-uuid=' + uuid + '])');
	if (!$row.length) {
		return;
	}
	var num = gallery_field.row_num($row);
	var opts = $table.data('opts');
	opts.images.splice(num - 1, 1);
	opts.image_names.splice(num - 1, 1);
	opts.ix.splice(num - 1, 1);
	$table.data('opts', opts);
	$row.remove();
	gallery_field.refresh($table);
}

gallery_field.update_rows = function($table) {
	var opts = $table.data('opts');
	$table.find('tr').each(function(ix) {
		var $row = $(this);
		var num = gallery_field.row_num($row);
		console.log(num, ix, opts.ix[ix]);
		if (num !== (ix+1) || opts.ix[ix] != ix) {
			gallery_field.update_row($table, $row, ix);
		}
	});
}

gallery_field.refresh = function($table) {
	gallery_field.update_rows($table);
	if (editor.enabled) {
		editor.disable();
		editor.enable();
	}
	nb_load_images();
}

gallery_field.move_up = function(e) {
	$row = $(e.target).closest('tr');
	$table = $row.closest('tbody');
	var num = gallery_field.row_num($row);
	if (num < 2) {
		return;
	}
	gallery_field.swap_data($table, num-1, num-2);
	e.preventDefault();
	gallery_field.refresh($table);
}

gallery_field.move_down = function(e) {
	$row = $(e.target).closest('tr');
	$table = $row.closest('tbody');
	var opts = $table.data('opts');
	var num = gallery_field.row_num($row);
	if (num >= opts.ix.length) {
		return;
	}
	gallery_field.swap_data($table, num-1, num);
	e.preventDefault();
	gallery_field.refresh($table);
}
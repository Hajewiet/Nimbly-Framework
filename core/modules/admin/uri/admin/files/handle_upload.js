
$('body').on('autoselect', function (e, opts) {

	console.log('on autoselect', e, opts);

	var row_tpl = $('#nb-row').html();
	for (var key in opts) {
    	if (!opts.hasOwnProperty(key)) {
    		continue;
    	}
    	var val = opts[key];
    	console.log(key, val);
    	var tok = new RegExp('[(]' + key + '[)]', 'g');
    	console.log(tok);
        row_tpl = row_tpl.replace(tok, val);
	}
	console.log(row_tpl);
	$(row_tpl).prependTo("table > tbody");
	$("#nb-single-file-preview").html('');

});

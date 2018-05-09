
$('body').on('autoselect', function (e, opts) {

	console.log('on autoselect', e, opts);

	var row_tpl = $('#nb-row').html();
	for (var key in opts) {
    	if (!opts.hasOwnProperty(key)) {
    		continue;
    	}
    	var val = opts[key];
    	var tok = new RegExp('[(]' + key + '[)]', 'g');
        row_tpl = row_tpl.replace(tok, val);
	}
	$(row_tpl).prependTo("table > tbody");
	if (opts.type === 'application/pdf') {
		$("tbody tr:first").find('img').replaceWith('(PDF)');	
	}
	$("#nb-single-file-preview").html('');
});

var FormWidgets = {};
FormWidgets.version = "1";
FormWidgets.items = [];

FormWidgets.init = function() {
    $("[data-post]").each(function(ix) {
        var item = $(this);
        item.removeClass("nojs");
        FormWidgets.items.push(item);
        FormWidgets.initForm(item);
        item.addClass("js-initialized");
    });    
};

FormWidgets.initForm = function(form) {
    form.find("input[type=submit]").each(function(ix) {
        var btn = $(this);
        btn.click(function(event){
            event.preventDefault();
            var src = form.data("post");
            if ('url' in src) {
                var settings = {};
                if ('type' in src) {
                    settings.type = src.type;
                } else {
                    settings.type = 'json';
                }
                settings.url = src.url;
                settings.data = form.serialize();
                settings.success = function(d) {
                    DataWidgets.invalidate(src.key);
                }
                settings.error = function(err) {
                    console.log("error", err);
               }
               FormWidgets.postData(settings);
            }
        });
    });    
};

FormWidgets.postData = function(settings) {
    $.ajax({ 
        url: settings.url,
        success: function(d) { settings.success(d); },
        error: function(xhr, opt, err){ settings.error(err); },
        data: settings.data,
        dataType: settings.type,
        type: 'POST'
    });
}

FormWidgets.init();

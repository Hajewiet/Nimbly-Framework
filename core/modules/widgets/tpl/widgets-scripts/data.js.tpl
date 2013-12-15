var DataWidgets = {};
DataWidgets.version = "1";
DataWidgets.items = [];
DataWidgets.templates = [];
DataWidgets.triggers = [];
DataWidgets.filters = [];
DataWidgets.sources = [];

DataWidgets.init = function() {
    $("[data-tpl]").each(function (ix) {
        var item = $(this);
        var tpl = item.data("tpl");
        for (ix in tpl) {
            DataWidgets.templates[ix] = tpl[ix];
        }
    });
    
    $("[data-filter]").each(function(ix) {
        var item = $(this);
        DataWidgets.filters.push(item);
        item.removeClass("nojs");
        item.addClass("js-initialized");
        var filter = item.data("filter");
        if (typeof(filter) != 'undefined') {
           item.click(function(event) {
                var enabled = false;
                if ('group' in filter && filter.group != 0) {
                    enabled = DataWidgets.toggleFilter(filter);
                } else {
                    enabled = DataWidgets.enableFilter(filter, true);
                }
                if (enabled) {
                    item.removeClass("js-filter-off");
                    item.addClass("js-filter-on");
                } else {
                    item.removeClass("js-filter-on");
                    item.addClass("js-filter-off");
                }
                event.preventDefault();
            });
        }
    });
    
    $("[data-trigger]").each(function(ix) {
       var item = $(this);
       DataWidgets.triggers.push(item);
       item.removeClass("nojs");
       item.addClass("js-initialized");
       var trigger = item.data("trigger");
       item.click(function(event) {
            if (typeof(trigger) != 'undefined' && 'key' in trigger) {
                DataWidgets.invalidate(trigger.key);
            }    
            event.preventDefault();
       });
    });
    
    $("[data-get]").each(function(ix) {
        var item = $(this);
        DataWidgets.items.push(item);
        item.removeClass("nojs");
        item.addClass("js-initialized");
        var src = item.data("get");
        var tpl = "template not found";
        if ('tpl' in src) {
            var tpl_name = src.tpl;
            if (tpl_name in DataWidgets.templates) {
                tpl = DataWidgets.templates[tpl_name];
            }
        }
        item.data("tpl", tpl);
        
        if ('key' in src) {
            item.data("key", src.key);
            if ('url' in src) {
                DataWidgets.sources.push(src);
            }
        }
        if ('order' in src) {
            item.data("order", src.order);
        } else {
            item.data("order", "asc");
        }
        
        var render_list = [];
        while (tpl.length > 0) {
            var token_start = tpl.indexOf('[');
            var token_end = tpl.indexOf(']', token_start);
            if (token_start < 0 || token_end < 0) {
                render_list.push({'html' : tpl });
                break;
            }
            render_list.push({'html' : tpl.substr(0, token_start)});
            var fake_token = token_start > 0 && tpl.charAt(token_start-1) == '\\';
            if (fake_token) {
                render_list.push({'html' : '['});
                tpl = tpl.substr(token_start+1);
                continue;
            }
            var token = tpl.substr(token_start+1, token_end-token_start-1);
            render_list.push({'data' : token});
            tpl = tpl.substr(token_end+1);
        }
        item.data("render-list", render_list);
    });    
}

DataWidgets.getData = function(src) {
    if ('url' in src && 'key' in src) {
        var settings = {};
        if ('type' in src) {
            settings.type = src.type;
        } else {
            settings.type = 'json';
        }
        settings.url = src.url;
        settings.data = DataWidgets.getFilters(src.key);
        settings.success = function(d) {
            var checksum = 0;
            if ('checksum' in d) {
                checksum = d.checksum;
            }
            DataWidgets.renderAll(src.key, d.rows, checksum);
        }
        settings.error = function(err) {
            console.log("error", err);
        }
        $.ajax({ 
            url: settings.url,
            success: function(d) { settings.success(d); },
            error: function(xhr, opt, err){ settings.error(err); },
            data: settings.data,
            dataType: settings.type,
            type: 'POST'
        });
    }
}

DataWidgets.renderAll = function(key, data, checksum) {
    for (var i in DataWidgets.items) { 
        var widget = DataWidgets.items[i];
        if (checksum != 0 && widget.data("checksum") == checksum) {
            continue;
        }
        if (widget.data("key") == key) {
            widget.html("");
            DataWidgets.render(widget, data);
            if (checksum != 0) {
                widget.data("checksum", checksum);
            }
        }
    }
}

DataWidgets.render = function(widget, rows) {
    var render_list = widget.data("render-list");
    var sort_order = widget.data("order");
    for (var i in rows) {
        var row_html = "";
        var row = rows[i];
        row.uuid = i;
        for (var j in render_list) {
            var ri = render_list[j];
            if ('html' in ri) {
                row_html += ri.html;
            } else if ('data' in ri) {
                var key = "";
                var data = "";
                if (ri.data in row) {
                    data = row[ri.data];
                } else if (ri.data.indexOf("row-") == 0) {
                    key = ri.data.substr(4);
                    if (key in row) {
                        data = row[key];
                    } else { //look for subkey
                        var keys = key.split("-");
                        var subobj = row;
                        for (k in keys) {
                            key = keys[k];
                            if (key in subobj) {
                                data = subobj[key];
                                subobj = data;
                            }
                        }
                    }
                }
                row_html += data;
            }
        }
        //find existing row
        var existing = widget.find('[data-uuid='+i+']');
        if (existing.length) {
            existing.replaceWith(row_html);
        } else if (sort_order == 'asc') {
            widget.append(row_html);        
        } else if (sort_order == 'desc') {
            widget.prepend(row_html);        
        }
    }
}

DataWidgets.toggleFilter = function(filter) {
    var key = "all";
    if ('key' in filter) {
        key = filter.key;
    }
    var removed = false;
    if (key in DataWidgets.filters) {
        for (var i in DataWidgets.filters[key]) {
            var f = DataWidgets.filters[key][i];
            if (f == filter) {
                DataWidgets.filters[key].splice(i, 1);
                removed = true;
            }
        }
    }
    
    if (typeof(DataWidgets.filters[key]) == 'undefined') {
        DataWidgets.filters[key] = [];
    } 
    if (removed == false) { //add the filter
        DataWidgets.filters[key].push(filter);
    }
    return removed ==false;    
}

DataWidgets.enableFilter = function(filter, exclusive) {
    var key = "all";
    if ('key' in filter) {
        key = filter.key;
    }
    if (exclusive) {
       DataWidgets.disableAllFilters(key);       
    }
    if (typeof(DataWidgets.filters[key]) == 'undefined') {
        DataWidgets.filters[key] = [];
    } 
    DataWidgets.filters[key].push(filter);
    return true;
}

DataWidgets.disableAllFilters = function(key) {
    for (var i in DataWidgets.filters) {
        var item = DataWidgets.filters[i];
        if ($.isArray(item) == false) {
            var f  = item.data("filter");
            if ('key' in f && f.key == key) {
                item.removeClass("js-filter-on");
                item.addClass("js-filter-off");
            }
        }
    }
    DataWidgets.filters[key] = [];
}


DataWidgets.getFilters = function(key) {
    var result = {};
    if (typeof(DataWidgets.filters[key]) != 'undefined') {
        for (var i in DataWidgets.filters[key]) {
            var f = DataWidgets.filters[key][i];
            for (var j in f) {
                if (j != 'key') {
                    result[j] = f[j];
                }
            }
        }
    }    
    return result;    
}

DataWidgets.invalidate = function(key) {
    DataWidgets.getAll(key);
}

DataWidgets.getAll = function(key) {
    for (var i in DataWidgets.sources) {
        var src = DataWidgets.sources[i];
        if (typeof(key) == 'undefined' || src.key == key) {
            DataWidgets.getData(src);
        }
    }
}

DataWidgets.init();

DataWidgets.getAll();




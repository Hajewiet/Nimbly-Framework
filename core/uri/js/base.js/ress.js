/*
 * Implementing RESS / server side device information
 */

var resizer = {};
resizer.device_width = '';
resizer.device_portrait = '';

resizer.get_viewport_width = function () {
    return Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
}

resizer.get_viewport_height = function () {
    return Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
}

resizer.update_device = function (w,p) {
    var e = document.documentElement;
    if (resizer.device_width !== w) {
        remove_class(e, 'large-screen');
        remove_class(e, 'medium-screen');
        remove_class(e, 'small-screen');
        add_class(e, w + '-screen');
        set_cookie("nb_device_width", w);
        resizer.device_width = w;
    }
    if (resizer.device_portrait !== p) {
        var o = p? 'portrait' : 'landscape';
        remove_class(e, 'portrait');
        remove_class(e, 'landscape');
        add_class(e, o);
        set_cookie("nb_device_portrait", p);
        resizer.device_portrait = p;
    }
}

resizer.classify = function(w) {
    if (w >= 1024) {
        return "large";
    } else if (w >= 640) {
        return "medium"
    } else {
        return "small";
    }
}

resizer.on_window_resize = function () {
    var w = resizer.get_viewport_width();
    var h = resizer.get_viewport_height();
    resizer.update_device(resizer.classify(w), h>w);
};

add_browser_event(window, "resize", resizer.on_window_resize);

resizer.on_window_resize();

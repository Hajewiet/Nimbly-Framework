
/*
 * Browser resize event, for implementing RESS
 */

var resizer = {};

resizer.resizes_done = 0;

resizer.once = false;

var add_browser_event = function (object, type, callback) {
    if (object === null || typeof (object) === 'undefined') {
        return;
    }
    if (object.addEventListener) {
        object.addEventListener(type, callback, false);
    } else if (object.attachEvent) {
        object.attachEvent("on" + type, callback);
    } else {
        object["on" + type] = callback;
    }
};

function set_cookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function get_cookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) === 0) {
            return c.substring(name.length, c.length);
        }
        ;
    }
    return "";
}

resizer.get_viewport_width = function () {
    return Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
}

resizer.update_device = function (w) {
    if (resizer.resizes_done++ > 0 && resizer.once) {
        return;
    }
    var old_size = get_cookie("viewport_width");
    if (old_size === w) {
        return;
    }
    set_cookie("viewport_width", w);
    if (get_cookie("viewport_width") !== "" + w) {
        window.location = window.location + '?viewport_width=' + w;
    } else {
        window.location.reload();
    }
}

resizer.on_window_resize = function (event) {
    var w = resizer.get_viewport_width();
    if (w >= 1024) {
        resizer.update_device("large");
    } else if (w >= 640) {
        resizer.update_device("medium");
    } else {
        resizer.update_device("small");
    }
};

add_browser_event(window, "resize", resizer.on_window_resize);

resizer.on_window_resize();
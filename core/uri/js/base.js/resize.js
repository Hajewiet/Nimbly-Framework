
/*
 * Browser resize event, for implementing RESS
 */

var add_browser_event = function (o, tp, cb) {
    if (o === null || typeof (o) === 'undefined') {
        return;
    }
    if (o.addEventListener) {
        o.addEventListener(tp, cb, false);
    } else if (o.attachEvent) {
        o.attachEvent("on" + tp, cb);
    } else {
        o["on" + tp] = cb;
    }
};

function set_cookie(cn, cv, xd) {
    var d = new Date();
    d.setTime(d.getTime() + (xd * 24 * 60 * 60 * 1000));
    var x = "expires=" + d.toUTCString();
    document.cookie = cn + "=" + cv + "; " + x;
}

function get_cookie(cn) {
    var n = cn + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(n) === 0) {
            return c.substring(n.length, c.length);
        }
        ;
    }
    return "";
}

function has_class(e, c) {
    return e.className.match(new RegExp('(\\s|^)' + c + '(\\s|$)'));
}

function remove_class(e, c) {
    if (has_class(e, c)) {
        var rx = new RegExp('(\\s|^)' + c + '(\\s|$)');
        e.className = e.className.replace(rx, ' ');
    }
}

function add_class(e, c) {
    if (e.className === '') {
        e.className = c;
    } else {
        e.className += ' ' + c;
    }
}

var resizer = {};

resizer.resizes_done = 0;

resizer.once = false;

resizer.class_set = '';

resizer.get_viewport_width = function () {
    return Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
}

resizer.set_class = function (c) {
    if (resizer.class_set === c) {
        return;
    }
    var e = document.documentElement;
    remove_class(e, 'large-screen');
    remove_class(e, 'medium-screen');
    remove_class(e, 'small-screen');
    add_class(e, c);
    resizer.class_set = c;
}

resizer.update_device = function (w) {

    resizer.set_class(w + '-screen');

    if (resizer.resizes_done++ > 0 && resizer.once) {
        return;
    }

    if (get_cookie("vpw") === w) {
        return;
    }

    set_cookie("vpw", w);
    //set_cookie("pixel_ratio", window.devicePixelRatio);

    if (get_cookie("vpw") !== "" + w) {
        if (window.location.search.indexOf("vpw=") < 0) {
            window.location.href = window.location.href + '?vpw=' + w;
        }
    } else {
        window.location.reload();
    }
}

resizer.on_window_resize = function () {
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

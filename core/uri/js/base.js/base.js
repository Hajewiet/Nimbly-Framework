var full_base_url = window.location.protocol + "//" + window.location.host  + base_url;

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

function set_cookie(cn, cv, xd=50000) {
    var d = new Date();
    d.setTime(d.getTime() + (xd * 24 * 60 * 60 * 1000));
    var x = "expires=" + d.toUTCString();
    document.cookie = cn + "=" + cv + "; " + x + ";path=/";
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
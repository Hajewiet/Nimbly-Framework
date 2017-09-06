/*
 * Toggle script for opening / closing elements
 * Usage: <div data-toggle> </div> or
 * <a data-toggle="#target-element"> </a>
 */

$('body').on('click', '[data-toggle]', function () {
    var tgt = $(this).data('toggle');
    if (tgt === "") {
        return;
    } else if ($(tgt).hasClass("open")) {
        $(tgt).removeClass("open").addClass("close");
    } else {
        $(tgt).removeClass("close").addClass("open");
    }
});

$('body').on('click', '[data-open-modal]', function () {
    var tgt = $(this).data('open-modal');
    if (tgt === "") {
        return;
    }
    $('.open').removeClass("open").addClass("close");
    $(tgt).addClass("open").removeClass("close");
});

$('body').on('click', '[data-open]', function () {
    var tgt = $(this).data('open');
    if (tgt === "") {
        return;
    }
    $(tgt).removeClass("close").addClass("open");
});

$('body').on('click', '[data-close]', function () {
    var tgt = $(this).data('close');
    if (tgt === "") {
        tgt = this;
    }
    $(tgt).removeClass("open").addClass("close");
});

$('body').on('click', '[data-active]', function () {
    var tgt = $(this).data('active');
    if (tgt === "") {
        return;
    }
    $(".active").removeClass("active");
    $(tgt).addClass("active");
});

/*  Add click event to elements with a data-link */
$('[data-link]').click(function () {
    window.location.href = $(this).data('link');
});

/*  Add click event to a elements with a data-submit */
$('a[data-submit],button[data-submit]').on("click", (function (e) {
    e.preventDefault();
    var me = $(this);
    if (me.data('confirm') !== undefined) {
        if (confirm(me.data('confirm')) !== true) {
            return;
        }
    }
    var frm = me.data('submit');
    var redirect_url = me.attr('href');
    var trigger_event = me.data("trigger");
    if (trigger_validate($(frm))) {
        return;
    }
    me.addClass("in-progress");
    $.ajax({
        type: 'post',
        url: $(frm).attr('action'),
        data: $(frm).serialize(),
        success: function (data) {
            if (typeof (redirect_url) !== "undefined") {
                window.location.href = redirect_url;
            } else {
                me.removeClass("in-progress").addClass("success");
                if (trigger_event !== "undefined") {
                    $(document).trigger(trigger_event, data);
                }
            }
        }
    });
}));

function trigger_validate(frm) {
    if (!frm[0].checkValidity()) {
        $('<input type="submit">').hide().appendTo(frm).click().remove();
        return false;
    }
    return true;
}

$('a[data-submit-std],button[data-submit-std]').on("click", (function (e) {
    e.preventDefault();
    var me = $(this);
    if (me.data('confirm') !== undefined) {
        if (confirm(me.data('confirm')) !== true) {
            return;
        }
    }
    var frm = me.data('submit-std');
    me.addClass("in-progress");
    $(frm).submit();
    me.removeClass("in-progress").addClass("success");

}));

$('body').on('submit', 'form[data-no-submit]', function (e) {
    e.preventDefault();
});

$('body').on('input', '[data-live]', function (e) {
    e.preventDefault();
    var me = $(this);
    var trigger = me.data('live');
    if ('val' in trigger) {
        var elem = $(trigger['val']);
        var data = elem.val();
        $(document).trigger(trigger['key'], {'val': data});
    }
});

$('body').on('click', '[data-delete]', function (e) {
    e.preventDefault();
    var me = $(this);
    if (me.data('confirm') !== undefined) {
        if (confirm(me.data('confirm')) !== true) {
            return;
        }
    }
    var url = me.data('delete');
    api({ method: 'delete', url: url, done: me.data('done'), payload: null });
});

$('body').on('click', '[data-post]', function (e) {
    e.preventDefault();
    var me = $(this);
    var url = me.data('post');
    var payload = me.data('payload');
    var frm = me.closest('form');
    if (frm && !trigger_validate(frm)) {
        return;
    }
    if (!payload && frm) {
        payload = JSON.stringify(frm.serializeObject());
    }
    if (!payload) {
        api_then({"msg": true}, "Post data empty");
        return;
    }
    api({ method: 'post', url: url, done: me.data('done'), payload: payload });
});

$('body').on('click', '[data-put]', function (e) {
    e.preventDefault();
    var me = $(this);
    var url = me.data('put');
    var payload = me.data('payload');
    var frm = me.closest('form');
    if (frm && !trigger_validate(frm)) {
        return;
    }
    if (!payload && frm) {
        payload = JSON.stringify(frm.serializeObject());
    }
    if (!payload) {
        api_then({"msg": true}, "Put data empty");
        return;
    }
    api({ method: 'put', url: url, done: me.data('done'), payload: payload });
});

$('body').on('click', '[data-push]', function () {
    var tgt = $(this).data('push');
    if (tgt === "") {
        return;
    } else if ($(tgt).hasClass("open")) {
        $(tgt).removeClass("open").addClass("close");
        $('#page-wrapper').removeClass('push-right');
    } else {
        $(tgt).removeClass("close").addClass("open");
        $('#page-wrapper').addClass('push-right');
    }
});

function api(options) {
    console.log('api', options);
    $.ajax({
        url: base_url + '/api/v1/' + options.url,
        type: options.method,
        data: options.payload,
        dataType : "json"
    }).done(function(json) {
        if (json.success) {
            api_then(options.done, json.message);
        } else {
            api_then(options.fail, json.message);
        }
    }).fail(function( xhr, status, errorThrown ) {
        opts = options.fail || {};
        opts.msg = opts.msg || xhr.responseJSON.message || errorThrown;
        opts.msg = api_pretty_message(opts.msg);
        api_then(opts, errorThrown);
    }).always(function( xhr, status ) {
        api_then(options.always);
    });
};

function api_pretty_message(txt) {
    // todo: i18n
    if (txt === "RESOURCE_EXISTS" || txt === "Conflict") {
        return "Could not create: a resource with the same key exists";
    } else if (txt === "METHOD_NOT_ALLOWED") {
        return "Method not supported.";
    }
    return txt;
}

function api_then(options, msg) {
    if (!options) {
        return;
    }
    if (options._redirect) {
        window.location.href=base_url + '/' + options._redirect;
        return;
    }
    if (options.hide) {
        $(options.hide).removeClass("open").addClass("close");
    }
    if (options.redirect) {
        // remember any messages for the next page
        if (options.msg) {
            api({
                "url": ".system-messages",
                "method": "post",
                "payload": '{ "message": ' + '"' + options.msg + '"}',
                "done": {"_redirect": options.redirect},
                "fail": {"_redirect": options.redirect}});
        } else {
            window.location.href=base_url + '/' + options.redirect;
        }
        return;
    }
    if (options.msg) {
        system_message(options.msg);
    }
    if (options.notification) {
        system_notification(options.notification);
    }
}

// wrap tables in a div for horizontal scrolling
$('table').wrap('<div class="table scroll-h"></div>');

function system_message(msg) {
    $("#system-messages p").text(msg);
    $("#system-messages").removeClass("close").addClass("open");
}


// a notification is more subtle than a system message
var notification_timer = null;
function system_notification(msg) {
    if (notification_timer) {
        clearInterval(notification_timer);
    }
    $("#system-notifications p").text(msg);
    $("#system-notifications").removeClass("close").addClass("open");
    notification_timer = setTimeout(function(){
        $("#system-notifications").removeClass("open").addClass("close");
    }, 1500);
}


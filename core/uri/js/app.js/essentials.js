/*
 * Toggle script for opening / closing elements
 * Usage: <div data-toggle> </div> or
 * <a data-toggle="#target-element"> </a>
 */

$('body').on('click', '[data-toggle]', function () {
    var tgt = $(this).data('toggle');
    if (tgt === "") {
        return;
    } else if ($(tgt).hasClass("nb-open")) {
        $(tgt).removeClass("nb-open").addClass("nb-close");
    } else {
        $(tgt).removeClass("nb-close").addClass("nb-open");
    }
});

$('body').on('click', '[data-open-modal]', function () {
    var tgt = $(this).data('open-modal');
    if (tgt === "") {
        return;
    }
    $('.open').removeClass("nb-open").addClass("nb-close");
    $(tgt).addClass("nb-open").removeClass("nb-close");
});

$('body').on('click', '[data-open]', function () {
    var tgt = $(this).data('open');
    if (tgt === "") {
        return;
    }
    $(tgt).removeClass("nb-close").addClass("nb-open");
});

$('body').on('click', '[data-close]', function () {
    var tgt = $(this).data('close');
    if (tgt === "") {
        tgt = this;
    }
    $(tgt).removeClass("nb-open").addClass("nb-close");
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
    if (frm && frm.length && !trigger_validate(frm)) {
        return;
    }
    if (payload) {
        payload = JSON.stringify(payload);
    } else if (frm && frm.length) {
        var data = frm.serializeObject();
        api_include_fields(frm, data);
        payload = JSON.stringify(data);
    }

    if (!payload) {
        api_then({"msg": "Post data empty"});
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
    if (frm && frm.length && !trigger_validate(frm)) {
        return;
    }
    if (payload) {
        payload = JSON.stringify(payload);
    } else if (frm && frm.length) {
        var data = frm.serializeObject();
        api_include_fields(frm, data);
        payload = JSON.stringify(data);
    }
    if (!payload) {
        api_then({"msg": "Put data empty"});
        return;
    }
    api({ method: 'put', url: url, done: me.data('done'), payload: payload });
});

$('body').on('click', '[data-push]', function () {
    var tgt = $(this).data('push');
    if (tgt === "") {
        return;
    } else if ($(tgt).hasClass("nb-open")) {
        $(tgt).removeClass("nb-open").addClass("nb-close");
        $('#page-wrapper').removeClass('push-right');
    } else {
        $(tgt).removeClass("nb-close").addClass("nb-open");
        $('#page-wrapper').addClass('push-right');
    }
});

$('body').on('input', 'input[data-live-pk]', function (e) {
    var f = $(this).data('live-pk');
    var pk_field = $(this).closest('form').find('input[name=' + f + ']');
    if (pk_field.length !== 1) {
        return;
    }
    var val = $(this).val();
    var clean_val = val.toLowerCase().trim().replace(/[^0-9a-zA-Z-]/g, '-');
    pk_field.val(clean_val);
});

$('body').on('keydown', 'input[data-input-pk]', function (e) {
    if(/[^0-9a-zA-Z-]/.test(e.key)) {
       return false;
    }
});

function api(options) {
    $.ajax({
        url: base_url + '/api/v1/' + options.url,
        type: options.method,
        data: options.payload,
        dataType : "json"
    }).done(function(json) {
        if (json.success) {
            api_then(options.done);
        } else {
            api_then(options.fail);
        }
    }).fail(function( xhr, status, errorThrown ) {
        opts = options.fail || {};
        opts.msg = opts.msg || xhr.responseJSON.message || errorThrown;
        opts.msg = api_pretty_message(opts.msg);
        api_then(opts);
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

function api_then(options) {
    if (!options) {
        return;
    }
    if (options._redirect) {
        window.location.href=base_url + '/' + options._redirect;
        return;
    }
    if (options.hide) {
        $(options.hide).removeClass("nb-open").addClass("nb-close");
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

function api_include_fields(frm, data) {
     frm.find('[data-edit-field],[data-edit-img],[data-field-boolean]').each(function(ix) {
        var me = $(this);
        var field = me.data('edit-field');
        if (field) {
            data[field] = me.html();
            return;
        }
        field = me.data('edit-img');
        if (field) {
            data[field] = me.data('img-uuid');
            return;
        }
        field = me.data('field-boolean');
        if (field) {
            data[field] = me.is(':checked');
            return;
        }
    });
}

// wrap tables in a div for horizontal scrolling
$('table').each(function() {
    var skip = $(this).data('no-scroll') || $(this).parents('.scroll-h').length > 0
    if (!skip) {
        $(this).wrap('<div class="table scroll-h"></div>');
    }
});

function system_message(msg) {
    $("#system-messages p").text(msg);
    $("#system-messages").removeClass("nb-close").addClass("nb-open");
}

// a notification is more subtle than a system message
var notification_timer = null;
function system_notification(msg) {
    if (notification_timer) {
        clearInterval(notification_timer);
    }
    $("#system-notifications p").text(msg);
    $("#system-notifications").removeClass("nb-close").addClass("nb-open");
    notification_timer = setTimeout(function(){
        $("#system-notifications").removeClass("nb-open").addClass("nb-close");
    }, 1500);
}

/*
 * Lazy image loading
 */

var nb_in_viewport = function (e, offset=0) {
    var brect = e.getBoundingClientRect();
    var h = window.innerHeight || document.documentElement.clientHeight;
    var w = window.innerWidth || document.documentElement.clientWidth;

    if (brect.top > h + offset) {
        return false;
    }
    if (brect.top + brect.height < -offset) {
        return false;
    }
    if (brect.left > w + offset) {
        return false;
    }
    if (brect.left + brect.width < -offset) {
        return false
    }
    return true;
};


function nb_load_images() {
    $("img[data-img-uuid]").each(function() {
        nb_load_image(this);
    });
    $('[data-bgimg-uuid]').each(function() {
        nb_load_image(this, true);
    });
}

function nb_image_size(e) {
    var prf = (window.devicePixelRatio || 1) / 10;
    var max_w = Math.ceil(e.outerWidth() * prf) * 10;
    var max_h = Math.ceil(e.outerHeight() * prf) * 10;
    return Math.max(max_w, max_h);
}

function nb_image_box(e, mf=1.0) {
    var prf = (window.devicePixelRatio || 1) / 10;
    var max_w = Math.ceil(e.outerWidth() * prf * mf) * 10;
    var max_h = Math.ceil(e.outerHeight() * prf * mf) * 10;
    return max_w + 'x' + max_h + 'f';
}

function nb_load_image(e, bg=false) {
    var uuid = $(e).data('img-uuid') || $(e).data('bgimg-uuid');
    if (!uuid) {
        return;
    }
    if (!$(e).is(':visible')) {
        return;
    }
    if (!nb_in_viewport(e, 200)) {
        return false;
    }
    var container = bg? $(e) : $(e).closest('div');
    var max = nb_image_size(container);
    var img_src = full_base_url + '/img/' + uuid + '/' + max + 'w';
    var ratio = $(e).data('img-ratio') || 0;
    if (ratio) {
        img_src += '?ratio=' + ratio;
    }
    if (!bg && e.src != img_src) {
        e.src = img_src;
    } else if (bg) {
        var bg_url = 'url("' + img_src + '")';
        if ($(e).css('background-image') !== bg_url) {
            $(e).css('background-image', bg_url);
        }
    }
}

function nb_debounced_viewport_changed() {
    nb_load_images();
}

$(window).scroll($.debounce(250, nb_debounced_viewport_changed));
$(window).resize($.debounce(250, nb_debounced_viewport_changed));
nb_load_images();
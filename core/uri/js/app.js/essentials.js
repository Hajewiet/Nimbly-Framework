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

$('body').on('click', 'a[href="#"]', function (e) {
    e.preventDefault();
});

/*  Add click event to elements with a data-link */
$('[data-link]').click(function () {
    window.location.href = $(this).data('link');
});

/*  Add click event to elements with a data-mailto */
$('[data-mailto]').click(function () {
    $lnk = $(this).clone();
    $lnk.find('span span,i,b,strong,small').remove();
    window.location.href = 'mailto:' + $lnk.text();
    return false;
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

$('body').on('input', 'input[data-live-id]', function (e) {
    var f = $(this).data('live-id');
    var id_field = $(this).closest('form').find('input[name=' + f + ']');
    if (id_field.length !== 1) {
        return;
    }
    var val = $(this).val();
    var clean_val = val.toLowerCase().trim().replace(/[^0-9a-zA-Z-]/g, '-');
    id_field.val(clean_val);
});

$('body').on('keydown', 'input[data-input-pk],input[data-input-id]', function (e) {
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

function nb_populate_template(tpl_id, context) {
    var result = $('#' + tpl_id).html();
    for (v in context) {
        const re = new RegExp('\\(\\(' + v + '\\)\\)', 'g')
        result = result.replace(re, context[v]);
    }
    return result;
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
    var interval = 1000;
    $('[data-img-preload]').each(function() {
        var t = this;
        setTimeout(function(){
            nb_preload_image(t);
        }, interval);
        interval += 500;
    })
}

function nb_image_width(e, mf=1.0) {
    var prf = (window.devicePixelRatio || 1) / 10;
    return Math.ceil(e.outerWidth() * prf * mf) * 10;
}

function nb_image_box(e, mf=1.0, suffix='f') {
    var prf = (window.devicePixelRatio || 1) / 10;
    var max_w = Math.ceil(e.outerWidth() * prf * mf) * 10;
    var max_h = Math.ceil(e.outerHeight() * prf * mf) * 10;
    return max_w + 'x' + max_h + suffix;
}

function nb_load_image(e, bg=false, cb=null) {
    $e = $(e);
    if (!$(e).is(':visible')) {
        return false;
    }
    if (!nb_in_viewport(e, 200)) {
        return false;
    }
    var h = $e.css('height');
    var container = bg || h > 10? $e : $e.closest('div,figure,li,section,p');
    var ratio = $e.data('img-ratio') || 0;
    var mode = $e.data('img-mode') || false;
    var img_src = nb_img_src($e, container, mode, ratio);
    if (!img_src) {
        return false;
    }
    if (!bg && e.src != img_src) {
        e.onload = cb || nb_image_loaded;
        e.src = img_src;
    } else if (bg) {
        var bg_url = 'url("' + img_src + '")';
        if ($e.css('background-image') !== bg_url) {
            e.onload = cb || nb_image_loaded;
            $e.css('background-image', bg_url);
        }
    }
}

function nb_image_loaded() {
    $(this).addClass('nb-img-loaded');
}

/*
 * Replace image with another
 */
function nb_swap_image($img, uuid, bgimg=false) {
    var old_uuid = $img.data('img-uuid');
    if (old_uuid === uuid) {
        return;
    }
    var w = $img.width();
    var h = $img.height();

    // 1. get or create container
    var $parent = $img.parent('div,figure');
    if ($parent.length === 0) {
        $img.wrap('<figure></figure>');
        $parent = $img.parent('figure');
    }

    // 2. add background and throbber to container
    $parent.css("position", "relative");
    $img.after('<div class="nb-throbber nb-close"></div>');
    $img.after('<div class="nb-bg"></div>');
    var $throbber = $parent.find("div.nb-throbber");
    var $bg = $parent.find("div.nb-bg");
    var y = h / 2 - 32 + $img.position().top;
    var x = w / 2 - 16 + $img.position().left;
    $bg.css({"position": "absolute", 
        "width": w, "height": h, "background-color": "black", 
        "top": $img.position().top, "left": $img.position().left,
        "opacity": 0 });
    $throbber.css({"position": "absolute", "top": y, "left": x});
    setTimeout(function(){
        $throbber.removeClass('nb-close');
    }, 1000);


    // 3. smoothly load new image
    $img.data('img-uuid', uuid); 
    $bg.fadeTo(100, '0.2', function() {
        nb_load_image($img[0], bgimg, function() {
            $bg.fadeTo(100, '0.0', function() {
                $parent.find('.nb-bg, .nb-throbber').remove();
            });
            $(this).addClass('nb-img-loaded');
        });
    });
    
}

function nb_img_src($e, container, mode, ratio=0) {
    var uuid = $e.data('img-uuid') || $e.data('bgimg-uuid');
    if (!uuid) { //emtpy image
        return "data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==";
    }
    var img_src = full_base_url + '/img/' + uuid + '/';
    if (mode === false) {
        img_src +=  nb_image_width(container) + 'w';
    } else if (mode === 'crop') {
        img_src += nb_image_box(container, 1.0, 'c');
    } else if (mode === 'fit') {
        img_src += nb_image_box(container);
    } else if (mode === 'third') {
        img_src +=  nb_image_width(container, 0.33) + 'w';
    }
    if (ratio) {
        img_src += '?ratio=' + ratio;
    } 
    return img_src;
}

/* like swap, but does not actually swap */
function nb_preload_image(e) {
    var $e = $(e);
    var s = $e.data('img-preload');
    if (!s) {
        return false;
    }
    var $img = $(s);
    var $container = $img.closest('div,figure');
    var mode = $img.data('img-mode') || false;
    var ratio = $img.data('img-ratio') || 0;
    var img_src = nb_img_src($e, $container, mode, ratio);
    if (img_src) {
        console.log('preloading', img_src);
        $('<img/>')[0].src = img_src;
    }
}



function nb_debounced_viewport_changed() {
    nb_load_images();
}

$(window).scroll($.debounce(20, nb_debounced_viewport_changed));
$(window).resize($.debounce(20, nb_debounced_viewport_changed));
nb_load_images();
var editor = {};

editor.enabled = false;
editor.inputs = 0;
editor.last_inputs = 0;
editor.editors = [];
editor.timer = null;
editor.active = null;
editor.autoenabled = false;
editor.modal_uuid = null;

editor.enable = function() {
    if (editor.enabled === true) {
        return;
    }
    editor.enabled = true;
    $("[data-edit-field]").attr("contenteditable", true);
    $('#edit-menu [data-edit-on').addClass("nb-close");
    $('#edit-menu [data-edit-off').removeClass("nb-close");
    $('#edit-menu [data-edit-save').removeClass("nb-close");
    $('#edit-button[data-edit-toggle] .nb-button').addClass("active");
    if (editor.editors.length === 0) {
        $('[data-edit-field]').each(function(ix) {
            btns = $(this).data("edit-buttons");
            if (!btns) {
                return;
            }
            btns = btns.split(',');
            var e = new MediumEditor($(this), {
                toolbar: {
                    buttons: btns,
                },
                placeholder: false
            });
            editor.editors.push(e);
        });
    }
    $('[data-edit-img]').each(function(ix) {
        editor.enable_img($(this), ix);
    });
    editor.timer = setInterval(editor.save, 10000);
}

editor.disable = function() {
    if (editor.disabled === false) {
        return;
    }
    editor.enabled = false;
    for (var e in editor.editors ) {
        delete e;
        e = null;
    }
    $('[data-edit-img]').each(function(ix) {
        editor.disable_img($(this), ix);
    });
    editor.editors = [];
    editor.active = null;
    $('.editor-active').removeClass('editor-active');
    $("[data-edit-field]").attr("contenteditable", false);
    $('#edit-menu [data-edit-on]').removeClass("nb-close");
    $('#edit-menu [data-edit-off]').addClass("nb-close");
    $('#edit-menu [data-edit-save]').addClass("nb-close");
    $('#edit-button[data-edit-toggle] .nb-button').removeClass("active");
    if (editor.timer) {
        clearInterval(editor.timer);
    }
    editor.save();
}

editor.toggle = function() {
    if (editor.enabled) {
        editor.disable();
    } else {
        editor.enable();
    }
}

editor.save = function() {
    if (editor.inputs === editor.last_inputs) {
        return;
    }
    editor.last_inputs = editor.inputs;
    $('[data-edit-uuid]').each(function(ix) {
        var resource = $(this).data("edit-resource");
        if (!resource) {
            return true;
        }
        var uuid = $(this).data("edit-uuid");
        if (!uuid) {
            return true;
        }
        var changes = false;
        var payload = {};
        $(this).find("[data-edit-field],[data-edit-img]").each(function(ix) {
            var changed = $(this).data('edit-changed');
            if (!changed) {
                return;
            }
            changes = true;
            $(this).data('edit-changed', false);
            var is_img = false;
            var field = $(this).data('edit-field');
            var tpl = $(this).data('edit-tpl');
            if (!field && ($(this).data('edit-img'))) {
                is_img = true;
                field = $(this).data('edit-img');
            } else if (!field) {
                field = "block-" + ix;
            }
            if (is_img) {
                payload[field] = $(this).data('img-uuid');
            } else {

                // clean up
                $("[data-remove]", this).remove();
                $("[style='']", this).removeAttr('style');

                
                if (tpl === 'plain_text') {
                    payload[field] = $(this).text();
                    $(this).html(payload[field]);
                } else {
                    payload[field] = $(this).html();
                }

                
            }
        });
        if (changes) {
            api({ method: 'put', url: resource + '/' + uuid, payload: JSON.stringify(payload), done: {notification: "Saved"} });
        }
     });
}

if ($('[data-edit-field]').length || $('[data-edit-img]').length) {

    // load medium editor style sheet
    $("head").append("<link>");
    var css = $("head").children(":last");
    css.attr({
        rel:  "stylesheet",
        type: "text/css",
        href: "https://cdnjs.cloudflare.com/ajax/libs/medium-editor/5.23.0/css/medium-editor.min.css"
    });

    // load medium editor script
    $script('https://cdnjs.cloudflare.com/ajax/libs/medium-editor/5.23.0/js/medium-editor.min.js', 'medium');

    // initialize html editing
    $script.ready('medium', function() {

        $('body').on('dblclick', '[data-edit-field],[data-edit-img]', function(e) {
            editor.enable();
        });

        $('body').on('click', '#edit-button[data-edit-toggle]', function (e) {
            editor.toggle();
        });

         $('body').on('click', '#edit-menu [data-edit-on]', function (e) {
            e.preventDefault();
            editor.enable();
        });

        $('body').on('click', '#edit-menu [data-edit-off]', function (e) {
            e.preventDefault();
            editor.disable();
        });

        $('body').on('click', '#edit-menu [data-edit-save]', function (e) {
            e.preventDefault();
            editor.save();
        });


        $('body').on('DOMNodeInserted', '[data-edit-field]', editor.clean_node);
        $('body').on('keyup', '.editor.img-insert [data-edit-field]', function(e) {
            if (editor.enabled) {
                editor.move_img_icon(e.target);
            }
        });
        $('body').on('click', '.editor.img-insert [data-edit-field]', function(e) {
            if (editor.enabled) {
                editor.move_img_icon($(this));
            }
        });

        if ($('form[data-edit-autoenable]').length > 0) {
            editor.autoenabled = true;
            editor.enable();
        } else {
            $('#edit-button').removeClass("nb-close");
            $('#edit-menu').removeClass("nb-close");
            $('#edit-menu [data-edit-off').addClass("nb-close");
            $('#edit-menu [data-edit-save').addClass("nb-close");
        }

    });

    $('body').on('input', '[data-edit-field]', function(e) {
        if (editor.enabled) {
            editor.inputs++;
            $(this).data('edit-changed', true);
        }
    });

    $('body').on('keydown', '[data-edit-field][data-edit-tpl=plain_text]', function(e) {
        if (!editor.enabled) {
            return;
        }
        if (e.keyCode === 13) { // prevents enter
            return false;
        } else if ((e.keyCode === 66 || e.keyCode === 73)
            && (e.ctrlKey || e.metaKey)) { // prevents ctrl+b and ctrl+i
            return false;
        }
    });

    $(window).on('unload', function() {
        editor.save();
    });
}

editor.move_img_icon = function(ee) {
    var parent_y = $(ee).position().top;
    var y = editor.get_caret_y();
    var img_icon = $(ee).parent().find('a.editor.add-img-icon').first();
    img_icon.css('top', (y - parent_y - 6) + 'px');
}

editor.get_caret_y = function() {
    if (editor.enabled === false) {
        return 0;
    }
    var y = 0;
    sel = window.getSelection();
    if (sel.getRangeAt && sel.rangeCount) {
        range = sel.getRangeAt(0);
        var e = document.createElement('I');
        e.appendChild(document.createTextNode("\u200b"));
        range.insertNode(e);
        y = $(e).position().top;
        e.parentNode.removeChild(e);
    }
    return y;
}

// workaround chrome span / inline style bug
editor.clean_node = function(e) {
    if (editor.enabled === false) {
        return;
    }
    if (e.target.tagName === "SPAN") {
        e.target.outerHTML = e.target.innerHTML;
        return;
    }
    e.target.style = null;
}

editor.enable_img = function(elem, ix) {
    if (elem.parent().is('div.editor.img-wrapper')) {
        elem.unwrap();
    }
    elem.wrap('<div class="editor img-wrapper"></div>');
    var resource_uuid = elem.closest("[data-edit-uuid]").data("edit-uuid");
    var img_uuid = elem.data('edit-img');
    elem.parent().append('<a href="#" class="edit-img-icon" data-modal=\'{"url": "img-select", "uid": "' + img_uuid + '", "resource_uuid": "' + resource_uuid + '"}\'>...</a>');
}

editor.disable_img = function(elem, ix) {
    elem.parent().find('a.edit-img-icon').remove();
    if (elem.parent().is('div.editor.img-wrapper')) {
        elem.unwrap();
    }
}

editor.uuid = function() {
    function id4() {
        return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
    }
    return id4() + id4() + id4() + id4();
}

editor.insert_html = function(html) {
    if (window.getSelection) {
        var sel = window.getSelection();
        if (sel.getRangeAt && sel.rangeCount) {
            var range = sel.getRangeAt(0);
            range.deleteContents();
            var el = document.createElement("div");
            el.innerHTML = html;
            var frag = document.createDocumentFragment();
            var node;
            var lastNode = false;
            while ((node = el.firstChild)) {
                lastNode = frag.appendChild(node);
            }
            range.insertNode(frag);

            // Preserve the selection
            if (lastNode) {
                range = range.cloneRange();
                range.setStartAfter(lastNode);
                range.collapse(true);
                sel.removeAllRanges();
                sel.addRange(range);
            }
        }
    } else if (document.selection && document.selection.type != "Control") {
        document.selection.createRange().pasteHTML(html);
    }
}

editor.replace_html = function(elem_id, html) {
    if (!elem_id) {
        return;
    }
    $('#' + elem_id).replaceWith(html);
}

editor.handle_click = function(elem, event) {
    var wrapper = $(elem).closest('div.editor,span.editor');
    if (wrapper && wrapper.is(editor.active)) {
        return;
    }
    $('.editor-active').removeClass('editor-active');
    editor.active = wrapper;
    wrapper.addClass('editor-active');
}

// handle result from image select modal dialog
$(document).on('data-select', function(e, o) {
    if (editor.enabled === false) {
        return;
    }

    // todo: replace hardcoded image size with dynamic using device pixel ratio

    // create new image at caret position
    if (o.modal_uid === '(new)') {
        // var d = editor.active.find('div:first');
        // console.log(d, d.width());
        var img_html = '<img src="' + base_url + '/img/' + o.uuid + '/medium" data-img-uuid=' + o.uuid + '>';
        editor.replace_html(editor.modal_uuid, img_html);
        editor.modal_uuid = false;
        editor.active.find('[data-edit-field]:first').data('edit-changed', true);
        editor.inputs++;
        return;
    }

    // update existing image
    var img = $('[data-edit-uuid=' + o.resource_uuid + '] img[data-edit-img=' + o.modal_uid + ']');
    if (img) {
        img.attr('src', base_url + '/img/' + o.uuid + '/medium');
        img.data('edit-changed', true);
        img.data('img-uuid', o.uuid);
        editor.inputs++;
    }
});

// handle opening modal dialog
$(document).on('modal.open', function(e, o) {
    if (editor.enabled === false || o.url !== 'img-select' || o.uid !== '(new)') {
        return;
    }
    editor.save();
    editor.modal_uuid = editor.uuid(); 
    editor.insert_html('<a id="' + editor.modal_uuid + '" data-remove="true"></a>');
});

// handle click outside or click on editor
$(document).mousedown(function(event) {
    if (editor.enabled === false) {
        return;
    }

    if(event.target === $('html')[0] && event.clientX >= document.documentElement.offsetWidth) {
        return; // mouse down on a scroll bar
    }

    if ($('#modal').length >0 && !$('#modal').hasClass('nb-close')) {
        return;
    }

    if ($(event.target).closest('[data-edit-field],[data-edit-img],.editor,#edit-menu,#edit-button,#top-bar-fixed,#modal,button.medium-editor-action,.medium-editor-toolbar').length) {
        editor.handle_click($(event.target), event);
        return;
    }

    if (editor.autoenabled) {
        return;
    }

    editor.disable();
})


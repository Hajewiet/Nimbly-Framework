var editor = {};

editor.enabled = false;
editor.inputs = 0;
editor.last_inputs = 0;
editor.editors = [];
editor.timer = null;
editor.active = null;

editor.enable = function() {
    if (editor.enabled === true) {
        return;
    }
    editor.enabled = true;
    $("[data-edit]").attr("contenteditable", true);
    $('#edit-menu [data-edit-on').addClass("close");
    $('#edit-menu [data-edit-off').removeClass("close");
    $('#edit-menu [data-edit-save').removeClass("close");
    $('#edit-button[data-edit-toggle] .button').addClass("active");
    if (editor.editors.length === 0) {
        $('[data-edit').each(function(ix) {
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
    $("[data-edit").attr("contenteditable", false);
    $('#edit-menu [data-edit-on').removeClass("close");
    $('#edit-menu [data-edit-off').addClass("close");
    $('#edit-menu [data-edit-save').addClass("close");
    $('#edit-button[data-edit-toggle] .button').removeClass("active");
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
    $('[data-block]').each(function(ix) {
          var payload = {};
          var buuid = $(this).data("block");
          $(this).find("[data-edit],[data-edit-img]").each(function(ix) {
               var is_img = false;
               var bname = $(this).data('edit');
               var tname = $(this).data('tpl');
               if (!bname && ($(this).data('edit-img'))) {
                    is_img = true;
                    bname = $(this).data('edit-img');
               } else if (!bname) {
                    bname = "block-" + ix;
               }
               payload[bname] = { "tpl": tname, "content": is_img ? $(this).attr('src') : $(this).html() };
          });
          api({ method: 'put', url: '.blocks/' + buuid, payload: JSON.stringify(payload), done: {notification: "Saved"} });
     });
}

if ($('[data-edit]').length || $('[data-edit-img]').length) {

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

        $('body').on('dblclick', '[data-edit],[data-edit-img]', function(e) {
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


        $('body').on('DOMNodeInserted', '[data-edit]', editor.clean_node);
        $('body').on('keyup', '.editor.img-insert [data-edit]', function(e) {
            if (editor.enabled) {
                editor.move_img_icon(e.target);
            }
        });
        $('body').on('click', '.editor.img-insert [data-edit]', function(e) {
            if (editor.enabled) {
                editor.move_img_icon($(this));
            }
        });

        $('#edit-button').removeClass("close");
        $('#edit-menu').removeClass("close");
        $('#edit-menu [data-edit-off').addClass("close");
        $('#edit-menu [data-edit-save').addClass("close");

    });

    $('body').on('input', '[data-edit]', function(e) {
        editor.inputs++;
    });

    $(window).on('unload', function() {
        editor.save();
    });
}

editor.handle_keypress = function(e) {

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
    var img_uuid = elem.data('edit-img');
    elem.parent().append('<a href="#" class="edit-img-icon" data-modal=\'{"url": "img-select", "uid": "' + img_uuid + '"}\'>...</a>');
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
    var sel, range;
    if (window.getSelection) {
        sel = window.getSelection();
        if (sel.getRangeAt && sel.rangeCount) {
            range = sel.getRangeAt(0);
            range.deleteContents();
            var el = document.createElement("div");
            el.innerHTML = html;
            var frag = document.createDocumentFragment(), node, lastNode;
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

editor.handle_click = function(elem, event) {
    var wrapper = $(elem).closest('span[data-block]');
    if (wrapper.data('block') !== editor.active) {
        $('span[data-block].editor-active').removeClass('editor-active');
        editor.active = wrapper.data('block');
        wrapper.addClass('editor-active');
    }
}

// handle result from image select modal dialog
$(document).on('data-select', function(e, o) {
    if (editor.enabled === false) {
        return;
    }

    // create new image at caret position
    if (o.modal_uid === '(new)') {
        var img_html = '<img src="' + base_url + '/img/' + o.uuid + '/small">';
        editor.insert_html(img_html);
        editor.inputs++;
        return;
    }

    // update existing image
    var img = $('img[data-edit-img=' + o.modal_uid + ']');
    if (img) {
        img.attr('src', base_url + '/img/' + o.uuid + '/small');
        editor.inputs++;
    }
});

// handle click outside or click on editor
$(document).mousedown(function(event) {
    if (editor.enabled === false) {
        return;
    }

    if(event.target === $('html')[0] && event.clientX >= document.documentElement.offsetWidth) {
        return; // mouse down on a scroll bar
    }

    if ($('#modal').length >0 && !$('#modal').hasClass('close')) {
        return;
    }

    if ($(event.target).closest('[data-edit],[data-edit-img],.editor,#edit-menu,#edit-button,#top-bar-fixed,#modal,button.medium-editor-action').length) {
        editor.handle_click($(event.target), event);
        return;
    }

    editor.disable();
})


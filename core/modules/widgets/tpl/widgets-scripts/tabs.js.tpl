function widgets_tabs_invalidate() {
    $("ul.tabs li").each(function(ix, elem) {
        var tab = $(elem);
        var id = tab.find("a").attr("href");
        var tab_content = $(id + ".tab-content");
        if (tab.hasClass("active")) {
            tab_content.addClass("active");
            tab.closest("ul.tabs").data("active-tab", tab);
        } else {
            tab_content.removeClass("active");
        } 
    });
}

$("ul.tabs li").click(function(event){
    var active_tab = $(this).closest("ul.tabs").data("active-tab");
    if (active_tab != undefined) {
        active_tab.removeClass("active");
    }
    $(this).addClass("active");
    widgets_tabs_invalidate();
    event.preventDefault();
});

widgets_tabs_invalidate();

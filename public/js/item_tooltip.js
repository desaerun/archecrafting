function bindTooltip(item_icon) {
    var item_id = $(item_icon).attr("data-item-id");
    item_icon.on("mouseenter", function () {
        var tooltip_div = $("<div>Loading Tooltip...</div>");
        tooltip_div.addClass("item_tooltip");
        $("body").append(tooltip_div);

        item_icon.on("mousemove", function (v) {
            tooltip_div.css({'top': v.pageY + 12, 'left': v.pageX + 10});
        });
        item_icon.on("mouseleave", function () {
            item_icon.off("mousemove");
            tooltip_div.remove();
        });
        $.get("item_tooltip.php", {"item_id": item_id}, function (response) {
            tooltip_div.html(response);
        });
    });
}

$(document).ready(function () {
    initialTooltipBind();
    replaceInlineIcons();
});

function initialTooltipBind() {
    $(".has_item_tooltip").each(function () {
        bindTooltip($(this));
    });
}

function itemIcon(target, item_id) {
    var data = "";
    $.get("item_icon.php", {"item_id": item_id}, function (response) {
        $(target).html(response);
        bindTooltip(target);
    });
    return true;
}

function replaceInlineIcons(match = ".item_icon.inline_replace") {
    $(match).each(function () {
        var item_id = $(this).attr("data-item-id");
        itemIcon($(this), item_id);
        $(this).removeClass("item_icon_inline_replace");
    });
}

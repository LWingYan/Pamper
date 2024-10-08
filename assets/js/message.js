$.extend({
    message: function(j) {
        var e = {
            message: " 操作成功",
            time: "2000",
            type: "success",
            showClose: false,
            autoClose: true,
            onClose: function() {}
        };
        if (typeof j === "string") {
            e.message = j
        }
        if (typeof j === "object") {
            e = $.extend({}, e, j)
        }
        var c = e.showClose ? '<a class="c-message--close">×</a>' : "";
        var i = '<div class="c-message messageFadeInDown"><div class="c-message--main"><i class=" c-message--icon c-message--' + e.type + '"></i>' + c + '<div class="c-message--tip">' + e.message + "</div></div></div>";
        var h = this;
        var f = $("body");
        var g = $(i);
        var d;
        var a, b;
        a = function() {
            g.addClass("messageFadeOutUp");
            g.one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend", function() {
                b()
            })
        }
        ;
        b = function() {
            g.remove();
            e.onClose(e);
            clearTimeout(d)
        }
        ;
        $(".c-message").remove();
        f.append(g);
        g.css({
            "margin-left": "-" + g.width() / 2 + "px"
        });
        g.one("webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend", function() {
            g.removeClass("messageFadeInDown")
        });
        f.on("click", ".c-message--close", function(k) {
            a()
        });
        if (e.autoClose) {
            d = setTimeout(function() {
                a()
            }, e.time)
        }
    }
});

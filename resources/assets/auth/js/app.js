require("lodash") ;
window.$ = window.jQuery = require("jquery") ;
Snackbar = require("node-snackbar") ;
NProgress = require("nprogress") ;
validator = require("bootstrap-validator") ;

$(".recaptcha .reload").click(function () {
    var a = $(this).closest(".image#captcha"),
        i = $("img", a),
        e = Math.floor(100 * Math.random() + 1);
    i.attr("src", i.attr("src") + "?" + e)
});


! function(t) {
    "use strict";
    t(".input100").each(function() {
        t(this).on("blur", function() {
            "" != t(this).val().trim() ? t(this).addClass("has-val") : t(this).removeClass("has-val")
        })
    });
    var a = t(".validate-input .input100");

    function i(a) {
        if ("email" == t(a).attr("type") || "email" == t(a).attr("name")) {
            if (null == t(a).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/)) return !1
        } else if ("" == t(a).val().trim()) return !1
    }
    t(".validate-form").on("submit", function() {
        for (var e, s, n = !0, r = 0; r < a.length; r++) 0 == i(a[r]) && (e = a[r], void 0, s = t(e).parent(), t(s).addClass("alert-validate"), n = !1);
        return n
    }), t(".validate-form .input100").each(function() {
        t(this).focus(function() {
            var a;
            a = t(this).parent(), t(a).removeClass("alert-validate")
        })
    });
    var e = 0;
    t(".btn-show-pass").on("click", function() {
        0 == e ? (t(this).next("input").attr("type", "text"), t(this).find("i").removeClass("zmdi-eye"), t(this).find("i").addClass("zmdi-eye-off"), e = 1) : (t(this).next("input").attr("type", "password"), t(this).find("i").addClass("zmdi-eye"), t(this).find("i").removeClass("zmdi-eye-off"), e = 0)
    })
}(jQuery);
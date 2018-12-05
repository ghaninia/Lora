! function(t) {
    "use strict";
    t(document).ready(function() {
        t(function() {
            function e() {
                if (t(window).width() <= "1099") {
                    t(".mmenu-init").remove(), t("#navigation").clone().addClass("mmenu-init").insertBefore("#navigation").removeAttr("id").removeClass("style-1 style-2").find("ul, div").removeClass("style-1 style-2 mega-menu mega-menu-content mega-menu-section").removeAttr("id"), t(".mmenu-init").find("ul").addClass("mm-listview"), t(".mmenu-init").find(".mobile-styles .mm-listview").unwrap(), t(".mmenu-init").mmenu({
                        counters: !0
                    }, {
                        offCanvas: {
                            pageNodetype: "#wrapper"
                        }
                    });
                    var e = t(".mmenu-init").data("mmenu");
                    t(".mmenu-trigger .hamburger");
                    t(".mmenu-trigger").on("click", function() {
                        e.open()
                    })
                }
                t(".mm-next").addClass("mm-fullsubopen")
            }
            e(), t(window).resize(function() {
                e()
            })
        }), t("#header-container").not("#header-container.not-sticky").clone(!0).removeClass("transparent-header").addClass("cloned unsticky").insertAfter("#header-container");
        var e = t("#header-container.transparent-header #logo img").attr("data-sticky-logo");
        void 0 !== e && t("#header-container.cloned #logo img").attr("src", e);
        var i = 2 * t("#header-container").height();

        function a() {
            t(".header-notifications").removeClass("active")
        }
        t(window).scroll(function() {
            t(window).scrollTop() >= i ? (t("#header-container.cloned").addClass("sticky").removeClass("unsticky"), t("#header-container .header-notifications").not("#header-container.cloned .header-notifications").removeClass("active")) : (t("#header-container.cloned").addClass("unsticky").removeClass("sticky"), t("#header-container.cloned .header-notifications").removeClass("active"))
        }), t(window).on("load resize", function() {
            var e = t(".transparent-header").outerHeight();
            t(".transparent-header-spacer").css({
                height: e
            })
        }), t(".ripple-effect, .ripple-effect-dark").on("click", function(e) {
            var i = t('<span class="ripple-overlay">'),
                a = t(this).offset(),
                n = e.pageY - a.top,
                s = e.pageX - a.left;
            i.css({
                top: n - i.height() / 2,
                left: s - i.width() / 2
            }).appendTo(t(this)), window.setTimeout(function() {
                i.remove()
            }, 800)
        }), t(".switch, .radio").each(function() {
            var e = t(this);
            e.on("click", function() {
                e.addClass("interactive-effect"), setTimeout(function() {
                    e.removeClass("interactive-effect")
                }, 400)
            })
        }), t(window).on("load", function() {
            t(".button.button-sliding-icon").not(".task-listing .button.button-sliding-icon").each(function() {
                var e = t(this).outerWidth() + 30;
                t(this).css("width", e)
            })
        }), t(".bookmark-icon").on("click", function(e) {
            e.preventDefault(), t(this).toggleClass("bookmarked")
        }), t(".bookmark-button").on("click", function(e) {
            e.preventDefault(), t(this).toggleClass("bookmarked")
        }), t("a.close").removeAttr("href").on("click", function() {
            t(this).parent().css({
                opacity: 0,
                transition: "opacity 0.5s"
            }).slideUp()
        }), t(".header-notifications").each(function() {
            var e = t(this),
                i = t(this).find(".header-notifications-trigger a");
            t(i).on("click", function(i) {
                i.preventDefault(), t(this).closest(".header-notifications").is(".active") ? a() : (a(), e.addClass("active"))
            })
        });
        var n = !1;
        t(".header-notifications").on("mouseenter", function() {
            n = !0
        }), t(".header-notifications").on("mouseleave", function() {
            n = !1
        }), t("body").mouseup(function() {
            n || a()
        }), t(document).keyup(function(t) {
            27 == t.keyCode && a()
        }), t(".status-switch label.user-invisible").hasClass("current-status") && t(".status-indicator").addClass("right"), t(".status-switch label.user-invisible").on("click", function() {
            t(".status-indicator").addClass("right"), t(".status-switch label").removeClass("current-status"), t(".user-invisible").addClass("current-status")
        }), t(".status-switch label.user-online").on("click", function() {
            t(".status-indicator").removeClass("right"), t(".status-switch label").removeClass("current-status"), t(".user-online").addClass("current-status")
        }), t(window).on("load resize", function() {
            var e, i;
            e = t("#header-container").outerHeight(), i = t(window).outerHeight() - e, t(".full-page-content-container, .dashboard-content-container, .dashboard-sidebar-inner, .dashboard-container, .full-page-container").css({
                height: i
            }), t(".dashboard-content-inner").css({
                "min-height": i
            }), t(".full-page-sidebar-inner, .dashboard-sidebar-inner").each(function() {
                var e = t("#header-container").outerHeight(),
                    i = t(window).outerHeight() - e;
                t(this).find(".sidebar-container, .dashboard-nav-container").outerHeight() > i ? t(this).css({
                    height: i
                }) : t(this).find(".simplebar-track").hide()
            })
        }), t(".enable-filters-button").on("click", function() {
            t(".full-page-sidebar").toggleClass("enabled-sidebar"), t(this).toggleClass("active"), t(".filter-button-tooltip").removeClass("tooltip-visible")
        }), t(window).on("load", function() {
            t(".filter-button-tooltip").css({
                left: t(".enable-filters-button").outerWidth() + 48
            }).addClass("tooltip-visible")
        }), t(".file-upload").on("change", function() {
            ! function(e) {
                if (e.files && e.files[0]) {
                    var i = new FileReader;
                    i.onload = function(e) {
                        t(".profile-pic").attr("src", e.target.result)
                    }, i.readAsDataURL(e.files[0])
                }
            }(this)
        }), t(".upload-button").on("click", function() {
            t(".file-upload").click()
        }), t(".dashboard-nav ul li a").on("click", function(e) {
            t(this).closest("li").children("ul").length && (t(this).closest("li").is(".active-submenu") ? t(".dashboard-nav ul li").removeClass("active-submenu") : (t(".dashboard-nav ul li").removeClass("active-submenu"), t(this).parent("li").addClass("active-submenu")), e.preventDefault())
        }), t(".dashboard-responsive-nav-trigger").on("click", function(e) {
            e.preventDefault(), t(this).toggleClass("active");
            var i = t("body").find(".dashboard-nav");
            t(this).hasClass("active") ? t(i).addClass("active") : t(i).removeClass("active"), t(".dashboard-responsive-nav-trigger .hamburger").toggleClass("is-active")
        }), t(".fun-fact").each(function() {
            var e = t(this).attr("data-fun-fact-color");
            void 0 !== e && (t(this).find(".fun-fact-icon").css("background-color", function(t) {
                var e;
                if (/^#([A-Fa-f0-9]{3}){1,2}$/.test(t)) return 3 == (e = t.substring(1).split("")).length && (e = [e[0], e[0], e[1], e[1], e[2], e[2]]), "rgba(" + [(e = "0x" + e.join("")) >> 16 & 255, e >> 8 & 255, 255 & e].join(",") + ",0.07)"
            }(e)), t(this).find("i").css("color", e))
        }), t(window).on("load resize", function() {
            t(window).width() > 1199 && t(".row").each(function() {
                if (t(this).find(".main-box-in-row").outerHeight() < t(this).find(".child-box-in-row").outerHeight()) {
                    var e = t(this).find(".child-box-in-row .headline").outerHeight(),
                        i = t(this).find(".main-box-in-row").outerHeight() - e + 39;
                    t(this).find(".child-box-in-row .content").wrap('<div class="dashboard-box-scrollbar" style="max-height: ' + i + 'px" data-simplebar></div>')
                }
            })
        }), t(".buttons-to-right").each(function() {
            t(this).width() < 36 && t(this).addClass("single-right-button")
        }), t(window).on("load resize", function() {
            var e = t(".small-footer").outerHeight();
            t(".dashboard-footer-spacer").css({
                "padding-top": e + 45
            })
        }), jQuery.each(jQuery("textarea[data-autoresize]"), function() {
            var t = this.offsetHeight - this.clientHeight;
            jQuery(this).on("keyup input", function() {
                var e;
                e = this, jQuery(e).css("height", "auto").css("height", e.scrollHeight + t)
            }).removeAttr("data-autoresize")
        }), t(".star-rating").each(function() {
            var e = t(this).attr("data-rating");

            function i(t, e, i, a, n) {
                return '<span class="' + t + '"></span><span class="' + e + '"></span><span class="' + i + '"></span><span class="' + a + '"></span><span class="' + n + '"></span>'
            }
            var a = i("star", "star", "star", "star", "star"),
                n = i("star", "star", "star", "star", "star half"),
                s = i("star", "star", "star", "star", "star empty"),
                o = i("star", "star", "star", "star half", "star empty"),
                r = i("star", "star", "star", "star empty", "star empty"),
                d = i("star", "star", "star half", "star empty", "star empty"),
                c = i("star", "star", "star empty", "star empty", "star empty"),
                l = i("star", "star half", "star empty", "star empty", "star empty"),
                h = i("star", "star empty", "star empty", "star empty", "star empty");
            e >= 4.75 ? t(this).append(a) : e >= 4.25 ? t(this).append(n) : e >= 3.75 ? t(this).append(s) : e >= 3.25 ? t(this).append(o) : e >= 2.75 ? t(this).append(r) : e >= 2.25 ? t(this).append(d) : e >= 1.75 ? t(this).append(c) : e >= 1.25 ? t(this).append(l) : e < 1.25 && t(this).append(h)
        }), t(".header-notifications-scroll").each(function() {
            var e = t(this).find("ul"),
                i = e.children("li").length;
            if (e.children("li").outerHeight() > 140) var a = 2;
            else a = 3;
            if (i > a) {
                var n = 0;
                t(e).find("li:lt(" + a + ")").each(function() {
                    n += t(this).height()
                }), t(this).css({
                    height: n
                })
            } else t(this).css({
                height: "auto"
            }), t(this).find(".simplebar-track").hide()
        }), tippy("[data-tippy-placement]", {
            delay: 100,
            arrow: !0,
            arrowType: "sharp",
            size: "regular",
            duration: 200,
            animation: "shift-away",
            animateFill: !0,
            theme: "dark",
            distance: 10
        });
        var s, o, r = (s = t(".js-accordion").find(".js-accordion-header"), o = {
            speed: 400,
            oneOpen: !1
        }, {
            init: function(e) {
                s.on("click", function() {
                    r.toggle(t(this))
                }), t.extend(o, e), o.oneOpen && t(".js-accordion-item.active").length > 1 && t(".js-accordion-item.active:not(:first)").removeClass("active"), t(".js-accordion-item.active").find("> .js-accordion-body").show()
            },
            toggle: function(t) {
                o.oneOpen && t[0] != t.closest(".js-accordion").find("> .js-accordion-item.active > .js-accordion-header")[0] && t.closest(".js-accordion").find("> .js-accordion-item").removeClass("active").find(".js-accordion-body").slideUp(), t.closest(".js-accordion-item").toggleClass("active"), t.next().stop().slideToggle(o.speed)
            }
        });

        function d(t) {
            for (var e = (t += "").split("."), i = e[0], a = e.length > 1 ? "." + e[1] : "", n = /(\d+)(\d{3})/; n.test(i);) i = i.replace(n, "$1,$2");
            return i + a
        }
        t(document).ready(function() {
            r.init({
                speed: 300,
                oneOpen: !0
            })
        }), t(window).on("load resize", function() {
            t(".tabs")[0] && t(".tabs").each(function() {
                var e = t(this),
                    i = e.find(".tabs-header .active").position();

                function a() {
                    i = e.find(".tabs-header .active").position(), e.find(".tab-hover").stop().css({
                        left: i.left,
                        width: e.find(".tabs-header .active").width()
                    })
                }
                a();
                var n = e.find(".tab.active").outerHeight();

                function s() {
                    n = e.find(".tab.active").outerHeight(), e.find(".tabs-content").stop().css({
                        height: n + "px"
                    })
                }

                function o() {
                    var i = e.find(".tabs-header .active a").attr("data-tab-id");
                    e.find(".tab").stop().fadeOut(300, function() {
                        t(this).removeClass("active")
                    }).hide(), e.find(".tab[data-tab-id=" + i + "]").stop().fadeIn(300, function() {
                        t(this).addClass("active"), s()
                    })
                }
                s(), e.find(".tabs-header a").on("click", function(i) {
                    i.preventDefault();
                    var n = t(this).attr("data-tab-id");
                    e.find(".tabs-header a").stop().parent().removeClass("active"), t(this).stop().parent().addClass("active"), a(), d = r.filter(".active"), e.find(".tab").stop().fadeOut(300, function() {
                        t(this).removeClass("active")
                    }).hide(), e.find('.tab[data-tab-id="' + n + '"]').stop().fadeIn(300, function() {
                        t(this).addClass("active"), s()
                    })
                });
                var r = e.find(".tabs-header ul li"),
                    d = r.filter(".active");
                e.find(".tab-next").on("click", function(t) {
                    t.preventDefault();
                    var e = d.next();
                    d.removeClass("active"), d = e.length ? e.addClass("active") : r.first().addClass("active"), a(), o()
                }), e.find(".tab-prev").on("click", function(t) {
                    t.preventDefault();
                    var e = d.prev();
                    d.removeClass("active"), d = e.length ? e.addClass("active") : r.last().addClass("active"), a(), o()
                })
            })
        }), t(".keywords-container").each(function() {
            var e = t(this).find(".keyword-input"),
                i = t(this).find(".keywords-list");

            function a() {
                var a = t("<span class='keyword'><span class='keyword-remove'></span><span class='keyword-text'>" + e.val() + "</span></span>");
                i.append(a).trigger("resizeContainer"), e.val("")
            }
            e.on("keyup", function(t) {
                13 == t.keyCode && "" !== e.val() && a()
            }), t(".keyword-input-button").on("click", function() {
                "" !== e.val() && a()
            }), t(document).on("click", ".keyword-remove", function() {
                t(this).parent().addClass("keyword-removed"), setTimeout(function() {
                    t(".keyword-removed").remove()
                }, 500), i.css({
                    height: "auto"
                }).height()
            }), i.on("resizeContainer", function() {
                var e = t(this).height(),
                    i = t(this).css({
                        "max-height": "auto",
                        height: "auto"
                    }).height();
                t(this).css({
                    height: e
                }).animate({
                    height: i
                }, 200)
            }), t(window).on("resize", function() {
                i.css({
                    height: "auto"
                }).height()
            }), t(window).on("load", function() {
                t(".keywords-list").children("span").length > 0 && i.css({
                    height: "auto"
                }).height()
            })
        });
        var c = (parseInt(t(".bidding-slider").attr("data-slider-min")) + parseInt(t(".bidding-slider").attr("data-slider-max"))) / 2;
        "auto" === t(".bidding-slider").data("slider-value") && t(".bidding-slider").attr({
            "data-slider-value": c
        }), t(".bidding-slider").slider(), t(".bidding-slider").on("slide", function(e) {
            t("#biddingVal").text(d(parseInt(e.value)))
        }), t("#biddingVal").text(d(parseInt(t(".bidding-slider").val())));
        var l = t(".range-slider").attr("data-slider-currency");
        t(".range-slider").slider({
            formatter: function(t) {
                return l + d(parseInt(t[0])) + " - " + l + d(parseInt(t[1]))
            }
        }), t(".range-slider-single").slider();
        for (var h = document.querySelectorAll(".payment-tab-trigger > input"), u = 0; u < h.length; u++) h[u].addEventListener("change", p);

        function p(t) {
            for (var e = this.closest(".payment").querySelectorAll(".payment-tab"), i = 0; i < e.length; i++) e[i].classList.remove("payment-tab-active");
            t.target.parentNode.parentNode.classList.add("payment-tab-active")
        }

        function f() {
            for (var t = document.getElementsByName("qtyInput"), e = 0; e < t.length; e++) parseInt(t[e].value) && parseInt(t[e].value)
        }
        t(".billing-cycle-radios").on("click", function() {
            t(".billed-yearly-radio input").is(":checked") && t(".pricing-plans-container").addClass("billed-yearly"), t(".billed-monthly-radio input").is(":checked") && t(".pricing-plans-container").removeClass("billed-yearly")
        }), f(), t(".qtyDec, .qtyInc").on("click", function() {
            var e = t(this),
                i = e.parent().find("input").val();
            e.hasClass("qtyInc") ? e.parent().find("input").val(parseFloat(i) + 1) : i > 1 ? e.parent().find("input").val(parseFloat(i) - 1) : e.parent().find("input").val(1), f(), t(".qtyTotal").addClass("rotate-x")
        }), t(".single-page-header, .intro-banner").each(function() {
            var e = t(this).attr("data-background-image");
            void 0 !== e && (t(this).append('<div class="background-image-container"></div>'), t(".background-image-container").css("background-image", "url(" + e + ")"))
        }), t(".intro-search-field").each(function() {
            t(this).children("label").length > 0 && t(this).addClass("with-label")
        }), t(".photo-box, .photo-section").each(function() {
            var e = t(this),
                i = t(this).attr("data-background-image");
            void 0 !== e && t(this).css("background-image", "url(" + i + ")")
        });
        var v = t(".popup-tabs-nav"),
            g = v.children("li");
        v.each(function() {
            var e = t(this);
            e.next().children(".popup-tab-content").stop(!0, !0).hide().first().show(), e.children("li").first().addClass("active").stop(!0, !0).show()
        }), g.on("click", function(e) {
            var i = t(this);
            i.siblings().removeClass("active").end().addClass("active"), i.parent().next().children(".popup-tab-content").stop(!0, !0).hide().siblings(i.find("a").attr("href")).fadeIn(), e.preventDefault()
        });
        var m = window.location.hash,
            b = t('.tabs-nav a[href="' + m + '"]');
        0 === b.length ? (t(".popup-tabs-nav li:first").addClass("active").show(), t(".popup-tab-content:first").show()) : b.parent("li").click(), t(".register-tab").on("click", function(e) {
            e.preventDefault(), t(".popup-tab-content").hide(), t("#register.popup-tab-content").show(), t("body").find('.popup-tabs-nav a[href="#register"]').parent("li").click()
        }), t(".popup-tabs-nav").each(function() {
            t(this).find("li").length < 2 && t(this).css({
                "pointer-events": "none"
            })
        }), t(".indicator-bar").each(function() {
            var e = t(this).attr("data-indicator-percentage");
            t(this).find("span").css({
                width: e + "%"
            })
        });
        var w = {
            $button: t(".uploadButton-input"),
            $nameField: t(".uploadButton-file-name")
        };
        w.$button.on("change", function() {
            ! function(t) {
                for (var e = [], i = 0; i < t.get(0).files.length; ++i) e.push(t.get(0).files[i].name + "<br>");
                w.$nameField.html(e)
            }(t(this))
        }), t(".default-slick-carousel").slick({
            infinite: !1,
            slidesToShow: 3,
            slidesToScroll: 1,
            dots: !1,
            arrows: !0,
            adaptiveHeight: !0,
            responsive: [{
                breakpoint: 1292,
                settings: {
                    dots: !0,
                    arrows: !1
                }
            }, {
                breakpoint: 993,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    dots: !0,
                    arrows: !1
                }
            }, {
                breakpoint: 769,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: !0,
                    arrows: !1
                }
            }]
        }), t(".testimonial-carousel").slick({
            centerMode: !0,
            centerPadding: "30%",
            slidesToShow: 1,
            dots: !1,
            arrows: !0,
            adaptiveHeight: !0,
            responsive: [{
                breakpoint: 1600,
                settings: {
                    centerPadding: "21%",
                    slidesToShow: 1
                }
            }, {
                breakpoint: 993,
                settings: {
                    centerPadding: "15%",
                    slidesToShow: 1
                }
            }, {
                breakpoint: 769,
                settings: {
                    centerPadding: "5%",
                    dots: !0,
                    arrows: !1
                }
            }]
        }), t(".logo-carousel").slick({
            infinite: !0,
            slidesToShow: 5,
            slidesToScroll: 1,
            dots: !1,
            arrows: !0,
            responsive: [{
                breakpoint: 1365,
                settings: {
                    slidesToShow: 5,
                    dots: !0,
                    arrows: !1
                }
            }, {
                breakpoint: 992,
                settings: {
                    slidesToShow: 3,
                    dots: !0,
                    arrows: !1
                }
            }, {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    dots: !0,
                    arrows: !1
                }
            }]
        }), t(".blog-carousel").slick({
            infinite: !1,
            slidesToShow: 3,
            slidesToScroll: 1,
            dots: !1,
            arrows: !0,
            responsive: [{
                breakpoint: 1365,
                settings: {
                    slidesToShow: 3,
                    dots: !0,
                    arrows: !1
                }
            }, {
                breakpoint: 992,
                settings: {
                    slidesToShow: 2,
                    dots: !0,
                    arrows: !1
                }
            }, {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    dots: !0,
                    arrows: !1
                }
            }]
        }), t(".mfp-gallery-container").each(function() {
            t(this).magnificPopup({
                type: "image",
                delegate: "a.mfp-gallery",
                fixedContentPos: !0,
                fixedBgPos: !0,
                overflowY: "auto",
                closeBtnInside: !1,
                preloader: !0,
                removalDelay: 0,
                mainClass: "mfp-fade",
                gallery: {
                    enabled: !0,
                    tCounter: ""
                }
            })
        }), t(".popup-with-zoom-anim").magnificPopup({
            type: "inline",
            fixedContentPos: !1,
            fixedBgPos: !0,
            overflowY: "auto",
            closeBtnInside: !0,
            preloader: !1,
            midClick: !0,
            removalDelay: 300,
            mainClass: "my-mfp-zoom-in"
        }), t(".mfp-image").magnificPopup({
            type: "image",
            closeOnContentClick: !0,
            mainClass: "mfp-fade",
            image: {
                verticalFit: !0
            }
        }), t(".popup-youtube, .popup-vimeo, .popup-gmaps").magnificPopup({
            disableOn: 700,
            type: "iframe",
            mainClass: "mfp-fade",
            removalDelay: 160,
            preloader: !1,
            fixedContentPos: !1
        })
    })
}(this.jQuery);
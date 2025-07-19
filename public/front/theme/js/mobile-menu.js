(function(s) {
    "use strict";
    s.fn.mobileMenu = function(e) {
        var i = {
            MenuWidth: 250,
            SlideSpeed: 300,
            WindowsMaxWidth: 767,
            PagePush: true,
            FromLeft: true,
            Overlay: true,
            CollapseMenu: true,
            ClassName: "mobile-menu"
        };

        return this.each(function() {
            var d = s.extend({}, i, e),
                c = s(this),
                h = s("#overlay"),
                u = s("body"),
                p = s("#page"),
                r = false;

            function n() {
                c.css(d.FromLeft ? "left" : "right", -d.MenuWidth);
                c.find("ul:first").addClass(d.ClassName);
                c.css("width", d.MenuWidth);
                c.find("." + d.ClassName + " ul").hide();
                var e = '<span class="expand fa fa-plus"></span>';
                c.find("li ul").parent().prepend(e);
                s("." + d.ClassName).append('<li style="height: 30px;"></li>');
                s("." + d.ClassName + " li:has(span)").each(function() {
                    s(this).find("a:first").css("padding-right", 55);
                });
            }

            function t() {
                u.addClass("mmPushBody");
                if (d.Overlay) h.addClass("overlay").css("opacity", 0);
                c.css({ display: "block", overflow: "hidden" });
                var animateProps = d.FromLeft ? { left: "0" } : { right: "0" };
                c.animate(animateProps, d.SlideSpeed, function() {
                    r = true;
                });
                if (d.PagePush) {
                    var pageProps = d.FromLeft ? { left: d.MenuWidth } : { left: -d.MenuWidth };
                    p.animate(pageProps, d.SlideSpeed, "linear");
                }
            }

            function o() {
                var animateProps = d.FromLeft ? { left: -d.MenuWidth } : { right: -d.MenuWidth };
                c.animate(animateProps, d.SlideSpeed, function() {
                    u.removeClass("mmPushBody");
                    h.removeClass("overlay").css("height", 0);
                    c.css("display", "none");
                    r = false;
                });
                if (d.PagePush) {
                    p.animate({ left: "0" }, d.SlideSpeed, "linear");
                }
            }

            n();

            // Toggle mobile menu
            s(".mm-toggle").on('click', function() {
                c.css("height", s(document).height());
                r ? o() : t();
            });

            // Toggle Menu items
            s("#menu").on('click', function(event) {
                event.preventDefault();
                if (!r) {
                    t();
                }
                
                // Only toggle menu items if category items are not visible
                if (!s("#menu-items").is(":visible") && s("#category-items").is(":visible")) {
                    s("#category-items").hide();
                }

                s("#menu-items").show(); // Toggle menu items
                
                // Set active link
                s(".menu-container li").removeClass("active");
                s("#menus").addClass("active");
            });

            // Toggle Category items
            s("#category").on('click', function(event) {
                event.preventDefault();
                if (!r) {
                    t();
                }
                
                // Only toggle category items if menu items are not visible
                if (!s("#category-items").is(":visible") && s("#menu-items").is(":visible")) {
                    s("#menu-items").hide();
                }

                s("#category-items").show(); // Toggle category items
                
                // Set active link
                s(".menu-container li").removeClass("active");
                s("#cats").addClass("active");
            });

            // Expand/collapse submenus
            c.on('click', '.expand', function(event) {
                event.preventDefault();
                var submenu = s(this).closest('li').children('ul');
                submenu.slideToggle(d.SlideSpeed);
                s(this).toggleClass('fa-plus fa-minus');
            });

            // Close menu on resize
            s(window).resize(function() {
                if (s(window).width() >= d.WindowsMaxWidth && r) {
                    o();
                }
            });

            // Close menu on overlay click
            h.on('click', function() {
                o();
            });
        });
    }
}(jQuery));

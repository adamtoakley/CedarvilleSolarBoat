$(document).ready(function () {

    var FF = !(window.mozInnerScreenX == null);

    $('a[href*="#"]').each(function () {
        $(this).addClass('tooltip').prop('title', 'Not Available');
    });

    $('a.button').hide();

    if (FF) {
        $('#main-navigation').addClass('scroll');
    } else {
        InitNaviScroll();
    }

    $("#team-nav a").each(function () {
        if ($(this).attr("href") == window.location.href.substring(window.location.href.lastIndexOf('/') + 1)) {
            $(this).parent().addClass("selected");
        } else {
            $(this).parent().removeClass("selected");
        }
    });

    $("#main-navigation a").each(function () {
        if ($(this).attr("href") == window.location.href.substring(window.location.href.lastIndexOf('/') + 1)) {
            $(this).addClass("main-selected");
        } else {
            $(this).removeClass("main-selected");
        }
    });
    if (Modernizr.history) {

        var newHash = "";

        $("#team-nav").delegate("a", "click", function () {
            _link = $(this).attr("href");
            history.pushState(null, null, _link);
            loadContent(_link);
            return false;
        });

        $(window).bind('popstate', function () {
            _link = location.pathname.replace(/^.*[\\\/]/, ''); //get filename only
            loadContent(_link);
        });

    }

    $('a[rel=lightbox]').lightBox({
        containerResizeSpeed: 250,
        fixedNavigation: true
    });

    $('a[href*="#"]').each(function () {
        $(this).addClass('tooltip').prop('title', 'Not Available');
    });

    $('a.button').hide();



});

function loadContent(href) {
    var $mainContent = $("#main-content");
    $mainContent
                .find("#team-info")
                .fadeOut(200, function () {
                    $('footer').css('background', 'white');
                    $(".social-media").css('background', 'white');
                    $mainContent.hide().load(href + " #team-info", function () {
                        $mainContent.fadeIn(200);
                        $('footer').css('background', '#00bce4');
                        $(".social-media").css('background', '#003a63');
                        $('a[rel=lightbox]').lightBox({
                            containerResizeSpeed: 250,
                            fixedNavigation: true
                        });
                        $('a[href*="#"]').each(function () {
                            $(this).addClass('tooltip').prop('title', 'Not Available');
                        });

                        $('a.button').hide();
                    });
                    $("#team-nav a").removeClass("current");
                    console.log(href);
                    $('#team-nav a[href$=" + href + "]').addClass("current");
                });
    $("#team-nav a").each(function () {
        if ($(this).attr("href") == window.location.href.substring(window.location.href.lastIndexOf('/') + 1)) {
            $(this).parent().addClass("selected");
        } else {
            $(this).parent().removeClass("selected");
        }
    });
}

function InitNaviScroll() {
    bannerHeight = $(".banner").height() - ($("#main-navigation").height() + 23);
    $(window).scroll(function () { NaviScroll() })
} 
function NaviScroll() {
    var e = $(window).scrollTop();
    if (e > bannerHeight) {
        if (!$("#main-navigation").hasClass("scroll")) {
            $("#main-navigation").addClass("scroll")
        }
    } else {
        if ($("#main-navigation").hasClass("scroll")) {
            $("#main-navigation").removeClass("scroll")
        }
    }
}

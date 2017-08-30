$(function () {
    $("[data-toggle]").each(function () {
        var href = $(this).attr('data-target');
        $(this).on('click', function (e) {
            $(href).stop();
            switch ($(this).attr('data-toggle')) {
                case 'scroll':
                    $("html, body").animate({scrollTop: $(href).offset().top}, 'slow');
                    break;
                case 'slide':
                    if ($(href).is(":visible"))
                        $(href).slideUp("fast");
                    else
                        $(href).slideDown("fast");
                    break;
                case 'menuslide':
                    $(this).parent().toggleClass('active');
                    if ($(href).is(":hidden"))
                        $(href).slideDown("fast", function () {
                            $(".header-anchors li").fadeIn(100);
                        });
                    else {
                        $(".header-anchors li").not(".lang-anchor").fadeOut(100);
                        $(href).slideUp("fast");
                    }
                    break;
                case 'toggle':
                    $(this).parent().toggleClass('active');
                    if ($(href).is(":visible")) {
                        $(href).fadeOut("fast");
                        if (href === "#search") {
                            if ($("#header .search").hasClass("active"))
                                $("#header .search").removeClass("active");
                            $("html").removeClass('no-scroll');
                        }
                    } else
                        $(href).fadeIn("fast");
                    if (typeof $(this).attr('data-focus') !== "undefined")
                        $($(this).attr('data-focus')).focus();
                    break;
            }
            e.preventDefault();
        });
    });
    $(".search-toggle").click(function () {
        $("html").addClass('no-scroll');
    });

    $(window).on('scroll', function () {
//        if ($("body").hasClass("_md") || $("body").hasClass("_lg")) {
            var headerHeight = $("#header").height() - $("#navbar").height();
            if ($(this).scrollTop() > headerHeight)
                $("body").addClass("sticky-navbar");
            else
                $("body").removeClass("sticky-navbar");
//        }
    });

    $(".item-image[data-video]").each(function () {
        var poster = $(this).find("img:first").attr('src');
        var file = $(this).attr('data-video');
        jwplayer($(this).attr('id')).setup({
            file: file,
            image: poster,
            width: "100%",
            aspectratio: "16:9"
        });
    });
    $(".page-tools").on('click', ".clickable", function (e) {
        if (!$(this).parent().hasClass('active')) {
            var type = $(this).attr('data-style');
            if (type === "grid")
                $(".box.episodes, .box.subcategories").addClass("grid");
            else
                $(".box.episodes, .box.subcategories").removeClass("grid");
            $(".page-tools").find("li").removeClass("active");
            $(this).parent().addClass("active");
        }
        e.preventDefault();
    });

    $(".box.gallery").on('click', ".thumbnail", function (e) {
        var imgPath = $(this).attr('href');
        $(".box.gallery .thumbs li").removeClass('active');
        $(this).parents("li:first").addClass('active');
        var $preview = $(".box.gallery .preview").find("img");
        $preview.fadeOut(function () {
            $preview.attr('src', imgPath).fadeIn();
        });
        e.preventDefault();
    });

    $itemWidth = $(".box.showcase > div ul").find("li:first").width();
    $showcaseItems = $(".box.showcase > div ul");
    $showcaseItems.find("li").each(function () {
        $(this).width($itemWidth);
    });

    var sc = $showcaseItems.owlCarousel({
        margin: 0
        , loop: true
        , center: true
        , items: 1
        , autoWidth: true
        , rtl: true
        , themeClass: 'carousel-theme'
        , baseClass: 'items-carousel'
        , startPosition: 5
        , itemClass: 'item'
        , animateOut: ''
        , nav: true
        , navText: ["", ""]
    });

    $(".box.content ul.slider:not(.blog-posts)").owlCarousel({
        margin: 0
        , loop: true
        , items: 1
        , autoWidth: false
        , rtl: true
        , themeClass: 'carousel-theme'
        , baseClass: 'items-carousel'
        , itemClass: 'item'
        , animateIn: 'fadeIn'
        , animateOut: 'fadeOut'
        , nav: true
        , navText: ["", ""]
    });

    $(".box.content ul.slider.blog-posts").owlCarousel({
        margin: 0
        , loop: true
        , items: 1
        , autoWidth: false
        , rtl: true
        , themeClass: 'carousel-theme'
        , baseClass: 'items-carousel'
        , itemClass: 'item'
        , animateIn: 'fadeIn'
        , animateOut: 'fadeOut'
        , nav: true
        , navText: ["", ""]
        , dots: true
    });

    $(".box.gallery ul.slider.galllery").owlCarousel({
        margin: 0
        , loop: true
        , items: 1
        , autoWidth: false
        , rtl: true
        , themeClass: 'carousel-theme'
        , baseClass: 'items-carousel'
        , itemClass: 'item'
        , animateIn: 'fadeIn'
        , animateOut: 'fadeOut'
        , nav: true
        , navText: ["", ""]
        , dots: true
    });

    $(".box.tiles.has-carousel ul").owlCarousel({
        margin: 20
        , loop: true
        , items: 4
        , autoWidth: false
        , rtl: true
        , themeClass: 'carousel-theme'
        , baseClass: 'items-carousel'
        , itemClass: 'item'
        , animateIn: 'fadeIn'
        , animateOut: 'fadeOut'
        , nav: true
        , navText: ["", ""]
    });

    $(".box.thumbs.carousel > div ul").owlCarousel({
        margin: 0
        , loop: true
//        , center: true
        , items: 4
        , autoWidth: false
        , rtl: true
        , themeClass: 'carousel-theme'
        , baseClass: 'items-carousel'
        , itemClass: 'item'
        , animateOut: ''
        , nav: true
        , navText: ["", ""]
    });

    $itemWidth = $(".box.special > .carousel ul").find("li:first").width();
    $(".box.showcase > .carousel ul").find("li").each(function () {
        $(this).width($itemWidth);
    });
    $(".box.special > div ul").owlCarousel({
        margin: 0
        , loop: true
        , center: false
        , items: 3
        , autoWidth: false
        , rtl: true
        , themeClass: 'carousel-theme'
        , baseClass: 'items-carousel'
        , itemClass: 'item'
    });

    $(".box.newsletter").on('submit', "form", function (e) {
        alert('Thanks!');
        e.preventDefault();
        return false;
    });

});

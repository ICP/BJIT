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
                        $(href).slideDown("fast", function() {
                            $(".header-anchors li").fadeIn();
                        });
                    else {
                        $(".header-anchors li").not(".lang-anchor").fadeOut("fast");
                        $(href).slideUp("fast");
                    }
                    break;
                case 'toggle':
                    $(this).parent().toggleClass('active');
                    if ($(href).is(":visible"))
                        $(href).fadeOut("fast");
                    else
                        $(href).fadeIn("fast");
                    if (typeof $(this).attr('data-focus') !== "undefined")
                        $($(this).attr('data-focus')).focus();
                    break;
            }
            e.preventDefault();
        });
    });
    $(".search-toggle").click(function() {
        $("html").toggleClass('no-scroll');
    })

    $(".item-image[data-video]").each(function () {
        var poster = $(this).find("img:first").attr('src');
        var file = $(this).attr('data-video');
        jwplayer($(this).attr('id')).setup({
            file: file,
            image: poster,
            width: "100%",
            aspectratio: "16:9",
        });
    });
    
    $(".box.gallery").on('click', ".thumbnail", function(e) {
        var imgPath = $(this).attr('href');
        $(".box.gallery .thumbs li").removeClass('active');
        $(this).parents("li:first").addClass('active');
        var $preview = $(".box.gallery .preview").find("img");
        $preview.fadeOut(function() {
            $preview.attr('src', imgPath).fadeIn();
        });
        e.preventDefault();
    });

    $itemWidth = $(".box.showcase > div ul").find("li:first").width();
    $(".box.showcase > div ul").find("li").each(function () {
        $(this).width($itemWidth);
    });
    $(".box.showcase > div ul").owlCarousel({
        margin: 0
        , loop: true
        , center: true
        , items: 1
        , autoWidth: true
        , rtl: true
        , themeClass: 'carousel-theme'
        , baseClass: 'items-carousel'
        , itemClass: 'item'
        , animateOut: 'fadeOut'
    });


    $itemWidth = $(".box.special > .carousel ul").find("li:first").width();
    $(".box.showcase > .carousel ul").find("li").each(function () {
        $(this).width($itemWidth);
    });
    $(".box.special > div ul").owlCarousel({
        margin: 0
        , loop: true
        , center: false
        , items: 2
        , autoWidth: false
        , rtl: true
        , themeClass: 'carousel-theme'
        , baseClass: 'items-carousel'
        , itemClass: 'item'
    });

    var fullHeightHeught = 0;
    $(".full-height").each(function() {
        fullHeightHeught = ($(this).height() > fullHeightHeught) ? $(this).height() : fullHeightHeught;
    });
    $(".full-height").height(fullHeightHeught);

//    $(".grayscale.color-on-hover figure").hover(
//            function () {
//                $(this).find('.original').stop().animate({opacity: 1}, 500);
//            },
//            function () {
//                $(this).find('.original').stop().animate({opacity: 0}, 500);
//            }
//    );
});

$(window).load(function () {
    $('.grayscale img').each(function () {
        var $wrapper = '<div style="position: relative; display:inline-block;width:' + this.width + 'px;height:' + this.height + 'px;">';
        $(this).wrap($wrapper).clone().addClass('original').css({'position': 'absolute', 'opacity': 0}).insertBefore(this);
        this.src = grayscale(this.src);
        if ($(this).is(":hidden"))
            $(this).fadeIn(500);
    });
});

// http://net.tutsplus.com/tutorials/javascript-ajax/how-to-transition-an-image-from-bw-to-color-with-canvas/
function grayscale(src) {
    var supportsCanvas = !!document.createElement('canvas').getContext;
    if (supportsCanvas) {
        var canvas = document.createElement('canvas'),
                context = canvas.getContext('2d'),
                imageData, px, length, i = 0, gray,
                img = new Image();
        img.src = src;
        canvas.width = img.width;
        canvas.height = img.height;
        context.drawImage(img, 0, 0);
        imageData = context.getImageData(0, 0, canvas.width, canvas.height);
        px = imageData.data;
        length = px.length;

        for (; i < length; i += 4) {
            gray = px[i] * .3 + px[i + 1] * .59 + px[i + 2] * .11;
            px[i] = px[i + 1] = px[i + 2] = gray;
        }
        context.putImageData(imageData, 0, 0);
        return canvas.toDataURL();
    } else {
        return src;
    }
}
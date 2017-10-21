//@prepros-append bootstrap.min.js
//@prepros-append slick.min.js

$ = (typeof $ === "undefined") ? jQuery.noConflict() : $;

$(function () {

    $(window).resize(function () { // Change width value on user resize, after DOM
        responsive_resize();
    });

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

    // Carousel
    if ($(".box.has-indicator").length) {
        $(".box.has-indicator").each(function () {
            var $box = $(this);
            if (typeof $box.attr('id') === "undefined" || !$box.attr('id'))
                $box.attr('id', 'box-' + Math.floor(Math.random() * 1001));
            var clone = $box.clone()
                    .attr('class', 'box cols cols-5 has-carousel hidden-desc no-header is-indicator')
                    .attr('data-target', "#" + $box.attr('id'))
                    .attr('id', 'box-' + Math.floor(Math.random() * 1001));
            clone.find("a").attr('href', 'javascript:;');
            clone.insertAfter($box);
        });
    }
    $(".box.has-carousel").each(function () {
        var $box = $(this);

        var count = $box.hasClass('cols') ? $box.attr('class').match(/cols-(\d+)/)[1] : 1;
        var carouselConfig = {
            autoplay: $box.hasClass('top') ? true : false
//			, fade: $box.hasClass('top') ? true : false
            , infinite: true
            , slidesToShow: +count
            , slidesToScroll: +count
            , SwipetoSlide: true
//                , centerMode: $box.hasClass('top') ? true : false
//            , rtl: true
            , dots: $box.hasClass('top') ? true : false
        };
        if ($box.hasClass('has-indicator')) {
            carouselConfig.asNavFor = "#" + $box.next().attr('id') + ' >div ul';
        }
        if ($box.hasClass('is-indicator')) {
            carouselConfig.asNavFor = $box.attr('data-target') + ' >div ul';
            carouselConfig.focusOnSelect = true;
        }
        if (count > 1) {
            carouselConfig.responsive = [
                {
                    breakpoint: 1199,
                    settings: {
                        slidesToShow: count > 4 ? 4 : count
                    }
                },
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: count > 2 ? 2 : count
                    }
                }
            ];
        }
        $box.find("> div ul").slick(carouselConfig);
    });

    $(".box.gallery").each(function () {
        var $box = $(this);

        var count = $box.hasClass('cols') ? $box.attr('class').match(/cols-(\d+)/)[1] : 1;
        var carouselConfig = {
            autoplay: false
            , infinite: true
            , slidesToShow: +count
            , slidesToScroll: 1
            , SwipetoSlide: true
            , arrows: true
            , dots: true
//                , centerMode: $box.hasClass('top') ? true : false
//            , rtl: true
        };
        if ($box.hasClass('has-indicator')) {
            carouselConfig.asNavFor = "#" + $box.next().attr('id') + ' >div ul';
        }
        if ($box.hasClass('is-indicator')) {
            carouselConfig.asNavFor = $box.attr('data-target') + ' >div ul';
            carouselConfig.focusOnSelect = true;
//                carouselConfig.centerMode = true;
        }
        $box.find("> div ul").slick(carouselConfig);
        console.log($box, carouselConfig);
    });

    if ($(".box.comments.comment-form").length)
        new CommentForm();

    function handleStickyHeader() {
        var headerHeight = $("#header").height();
        if ($(this).scrollTop() > headerHeight)
            $("body").addClass("sticky-navbar");
        else
            $("body").removeClass("sticky-navbar");
    }
    handleStickyHeader();
    $(window).on('scroll', function () {
        handleStickyHeader();
    });

    $(".short-link-container").click(function (e) {
        e.preventDefault();
        $(this).find("input").select();
        try {
            document.execCommand('copy');
        } catch (er) {
            console.log(er);
        }
//        $(this).find("input").focus();
//        document.execCommand('selectAll');
    }); // Short link selections

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

    if ($(".box.sticky").length) {
        var top = $(".box.sticky").offset().top;
        var width = $(".box.sticky").width();
        $(window).on('scroll', function () {
            if ($(this).scrollTop() + 60 >= top && ($("body").hasClass("_lg") || $("body").hasClass("_md"))) {
                if ($(".box.sticky").css('position') !== "fixed") {
                    $(".box.sticky").css({
                        position: 'fixed'
                        , top: -40
                        , left: $(".box.sticky").offset().left
                        , width: width
                    });
                }
            } else {
                $(".box.sticky").css({position: 'static'});
            }
        });
    }

    $(document).on('click', ".box.list a", function (e) {
        var id = $(this).parents("li:first").attr("data-id");
        if ($("#item-" + id).length) {
            e.preventDefault();
            $("html, body").animate({"scrollTop": $("#item-" + id).offset().top - 80})
        }
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

    $(".box.newsletter").on('submit', "form", function (e) {
        if (confirm("Subscribe?"))
            $.post(Config.base + 'api/subscribe', $(this).serializeObject(), function (d) {
                $('<div class="alert alert-success" id="subscribe-status">ایمیل شما با موفقیت ثبت شد.<br /><p style="direction: ltr; text-align: left;">Your email saved successfully</p></div>').insertBefore(".box.newsletter").promise().done(function () {
                    window.setTimeout(function () {
                        $("#subscribe-status").slideUp(function () {
                            $(this).remove();
                        })
                    }, 2000);
                });
            }).fail(function (err) {
                alert(JSON.parse(err.responseText)["msg"]);
            });
        e.preventDefault();
        return false;
    });

});

$.fn.serializeObject = function () {
    var o = {};
    var a = this.serializeArray(); // serializeArray - serialize form as an array instead of default object
    $.each(a, function () {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};

function CommentForm() {
    this.form = $(".box.comments.comment-form form");
    this.note = $(".box.comments.comment-form .comment-notes");
    this.result = $(".box.comments.comment-form .comment-result");

    this.clearForm = function ($form) {
        $form.find("input[type=text], input[type=email], textarea").val('');
        if (typeof grecaptcha == "object")
            grecaptcha.reset();
        return true;
    };

    var __construct = function (that) {
        $form = that.form;
        $msg = that.note;
        $result = that.result;
        $form.find("input, textarea").on('focusin', function () {
            if ($msg.is(":hidden"))
                $msg.slideDown();
        });
        $form.on('submit', function (e) {
            var $this = $(this);

            if ($(".g-recaptcha-response").length)
                if ($(".g-recaptcha-response").val() === "")
                    return false;

            var data = $this.serialize();
            $.ajax({
                url: $this.attr('action')
                , data: data
                , type: $this.attr('method')
                , success: function (d) {
                    var msg = JSON.parse(d);
                    $result.html(msg.message);
                    switch (msg.cssClass) {
                        case 'k2FormLogSuccess':
                            $result.removeClass('alert-danger').addClass('alert-success');
                            break;
                        case 'k2FormLogError':
                            $result.addClass('alert-danger').removeClass('alert-success');
                            break;
                    }
                    if ($result.is(":hidden"))
                        $result.slideDown();
                    that.clearForm($this);
                }
            });
            e.preventDefault();
            return false;
        });
    }(this);
}

function responsive_resize() {
    var current_width = $(window).width();
    if (current_width < 768) {
        // XS
        $('body').addClass("_xs").removeClass("_sm _md _lg");
    } else if (current_width > 767 && current_width < 992) {
        $('body').addClass("_sm").removeClass("_xs _md _lg");
    } else if (current_width > 991 && current_width < 1200) {
        $('body').addClass("_md").removeClass("_xs _sm _lg");
    } else if (current_width > 1199) {
        $('body').addClass("_lg").removeClass("_xs _sm _md");
    }
}
responsive_resize();
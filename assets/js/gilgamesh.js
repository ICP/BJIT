//@prepros-append slick.min.js
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
			, rtl: true
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
            , rtl: true
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

    function handleStickyHeader() {
        var headerHeight = $("#header").height() - $("#navbar").height();
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

    if ($("#sidebar .box.ads").length) {
        var top = $("#sidebar .box.ads").offset().top;
        $(window).on('scroll', function () {
            
            if ($(this).scrollTop() + 60 >= top) {
                if ($("#sidebar .box.ads").css('position') !== "fixed") {
                    $("#sidebar .box.ads").css({
                        position: 'fixed'
                        , top: 60
                        , left: $("#sidebar .box.ads").offset().left
                    });
                }
            } else {
                $("#sidebar .box.ads").css({position: 'static'});
            }
        });
    }

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
        alert('Thanks!');
        e.preventDefault();
        return false;
    });

});
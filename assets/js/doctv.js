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
                        if (href === "#search")
                            if ($("#header .search").hasClass("active"))
                                $("#header .search").removeClass("active");
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
        $("html").toggleClass('no-scroll');
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

    $(".nano").nanoScroller({
        alwaysVisible: true
    });

    var $tilesTmpl = '<li><figure class="img"><a href="{link}"><img src="{img}" alt="{title}" /></a></figure><div class="desc"><div class="item-header"><h3 class="item-title"><a href="{link}">{title}</a></h3></div><time class="created">{created}</time></div></li>';
    if ($(".item-boxes .box.more").length) {
        var moreItems = $(".item-boxes .box.more");
        var itemsContainer = moreItems.find("ul");
        var url = moreItems.attr("data-catlink");
        $.ajax({
            url: url
            , data: 'format=json'
            , success: function (d) {
                if (typeof d === "object") {
                    items = d.items;
                    $.each(items, function () {
                        item = $tilesTmpl.replace(/{link}/g, this.link).replace(/{img}/g, this.image).replace(/{title}/g, this.title).replace(/{created}/g, this.time);
                        itemsContainer.append(item);
                    });
                }
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

    $itemWidth = $(".box.showcase > div ul").find("li:first").width();
    $showcaseItems = $(".box.showcase > div ul");
    $showcaseItems.find("li").each(function () {
        $(this).width($itemWidth);
    });
    $showcaseItems.on('changed.owl.carousel', function (property) {
        var current = property.item.index;
        if (current !== null) {
            var img = $(property.target).find(".item").eq(current + 1).find("img");
            var o = {
                src: img.attr('src')
                , alt: img.attr('alt')
            };
            var $img = $showcaseItems.parents(".box-wrapper:first").find(".active-img img");
            $img.parent().append('<img src="' + o.src + '" alt="' + o.alt + '" />').promise().done(function () {
                $img.fadeOut('slow').remove();
            });
        }
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
        , items: 2
        , autoWidth: false
        , rtl: true
        , themeClass: 'carousel-theme'
        , baseClass: 'items-carousel'
        , itemClass: 'item'
    });

    equalHeights();

    if ($(".feed-holder").length) {
        $(".feed-holder").each(function () {
            var conf = JSON.parse($(this).attr("data-conf"));
            var $box = $(this);
            $.ajax({
                url: conf.url
                , success: function (d) {
                    loadExternalFeed(conf, d, $box);
                }
            });
        });
    }

    $("#datepicker").pDatepicker({
        enabled: true
        , navigator: {
            text: {
                btnNextText: '<span>ماه بعد</span><i class="icon-left-open"></i>'
                , btnPrevText: '<i class="icon-right-open"></i><span>ماه قبل</span>'
            }
            , enabled: false
        }
        , toolbox: false
//        , minDate: Math.floor(Date.now() + (3600000 * (24)))
        , maxDate: Math.floor(Date.now() - (3600000 * (24)))
        , onSelect: function (d) {
            date = new Date(d);
            $("#date-input").val(date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate());
            $("#load-schedule").submit();
        }
    });

    if ($(".schedule-header-date").length) {
        $(".schedule-header-date").appendTo('h1');
    }

    var searchItemsTemplate = '<li><figure class="img"><a href="{item.link}"><img src="{item.imageSmall}" alt="{item.title}" /></a></figure><div class="desc"><h3><a href="{item.link}">{item.title}</a></h3></div></li>';
    $(".search-form input[name=searchword]").keypress(function (e) {
        $form = $(this).parents("form:first");
        $results = $form.parent().find(".box");
//        $('input[name=t]').val($.now());
        if ($(this).val().length > 2 && e.key !== 'enter' && e.which !== 0 && !e.ctrlKey && !e.metaKey && !e.altKey) {
            $.ajax({
                url: base + '?task=search&format=json&limit=8'
                , data: $form.serialize()
                , success: function (d) {
                    if (d.items.length > 0) {
                        var output = '<div><ul>';
                        $.each(d.items, function () {
                            output += searchItemsTemplate.replace(/{item.link}/g, this.link)
                                    .replace(/{item.imageSmall}/g, this.imageSmall)
                                    .replace(/{item.title}/g, this.title);
                        });
                        output += '</ul></div>';
                        $results.html(output);
                        if ($results.is(":hidden"))
                            $results.slideDown();
                    } else {
                        $results.slideUp();
                    }
                }
            });
        }
    });

});

function feedCarousels($items) {
    $items.owlCarousel({
        margin: 0
        , loop: true
//        , center: true
        , items: 3
        , autoWidth: false
        , rtl: true
        , themeClass: 'carousel-theme'
        , baseClass: 'items-carousel'
        , itemClass: 'item'
        , animateOut: ''
        , nav: true
        , navText: ["", ""]
    });
}

function equalHeights() {
    var fullHeightHeight = 450;
    $(".full-height").each(function () {
        fullHeightHeight = ($(this).height() > fullHeightHeight) ? $(this).height() : fullHeightHeight;
    });
    $(".full-height").height(fullHeightHeight);
    return fullHeightHeight;
}

function loadExternalFeed(conf, data, $box) {
    var items_tmpl = window["items_" + conf.tmpl];
    var box_tmpl = window["box_" + conf.tmpl];
    var items = '';
    var count = (conf.count == '-1') ? data.items.length : conf.count;
    for (var i = 0; i < count; i++) {
        items += items_tmpl.replace(/{site.url}/g, data.site.url)
                .replace(/{category.link}/g, data.category.link)
                .replace(/{item.link}/g, data.items[i].link)
                .replace(/{item.imageSmall}/g, data.items[i].imageSmall)
                .replace(/{item.title}/g, data.items[i].title);
    }
    var box = box_tmpl.replace(/{site.url}/g, data.site.url)
            .replace(/{site.name}/g, data.site.name)
            .replace(/{items}/g, items);
    $box.parent().append(box);
    equalHeights();
    if (typeof conf.carousel !== "undefined" && conf.carousel === true)
        feedCarousels($box.parent().find("ul"));
}
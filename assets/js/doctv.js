$(function () {

    // Event Listeners
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
    $(".search-toggle").on('click', function () {
        $("html").toggleClass('no-scroll');
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
    $("form[data-type=ajax]").on('submit', function (e) {
        var $form = $(this);
        if ($(this).attr('data-eligibility') === "false") {
            if ($(this).find(".alert-danger").length)
                $(this).find(".alert-danger").fadeIn();
            return false;
        }
        if ($form.find("input[name=file]").length) {
            if (typeof $form.find("input[name=file]").val() === "undefined" || $form.find("input[name=file]").val() === "") {
                alert('File not selected!');
                return false;
            }
        }
        var params = {
            data: $form.serialize()
            , url: $form.attr('action')
            , type: $form.attr('method')
        };
        var $result = $form.parent().find(".results-container");
        $.ajax({
            url: params.url
            , data: params.data
            , type: params.type
            , success: function (d) {
//                console.log(typeof d);
                $result.addClass("alert-success").removeClass("alert-danger").html(d.msg);
            }
            , error: function (er) {
                er = JSON.parse(er.responseText);
                $result.addClass("alert-danger").removeClass("alert-success").html(er.msg);
            }
        });
        if ($result.is(":hidden"))
            $result.fadeIn();
        e.preventDefault();
        return false;
    });
    $(".upload-form form").on('focusin', "input, textarea", function (e) {
        if ($(this).parents("form").attr("data-eligibility") === "false")
            $(this).parents("form").find(".alert.alert-danger").fadeIn();
    });

    // Plugin Attachments & Object Initiations
    if ($("#datepicker").length) {
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
            , maxDate: Math.floor(Date.now() - (3600000 * (24 * 7)))
            , onSelect: function (d) {
                date = new Date(d);
                $("#date-input").val(date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate());
                $("#load-schedule").submit();
            }
        });
    }
    if ($(".nano").length) {
        $(".nano").nanoScroller({
            alwaysVisible: true
        });
    }
    if ($(".feed-holder").length) {
        new Feeds($(".feed-holder"));
    }
    if ($(".item-image[data-video]").length) {
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
    }
    if ($(".box.comments.comment-form").length) {
        new CommentForm();
    }
    if ($(".box.showcase").length) {
        BoxHelper.showcase();
    }
    if ($(".box.thumbs.carousel").length) {
        BoxHelper.thumbCarousels();
    }
    if ($(".box.special").length) {
        BoxHelper.special();
    }
    if ($(".ajax-upload").length) {
        $(".ajax-upload").fineUploader({
            multiple: false
            , request: {endpoint: base + 'api/ugc/file'}
            , validation: {
                allowedExtensions: ['jpg', 'jpeg', 'png', 'mp4', 'flv'],
                sizeLimit: 20971520 // 20M
            }
            , debug: true
        }).on('complete', function (event, id, filename, responseJSON) {
            if (responseJSON.success) {
                console.log(event, id, filename, responseJSON);
                $("input[name=file]").val(responseJSON.uuid + '/' + responseJSON.uploadName);
                $(".qq-upload-button-selector").fadeOut(function () {
                    $(this).remove();
                });
            }
        });
    }
    if ($(".page-slogan").length) {
        $(".page-slogan").appendTo("h1:first").removeClass("hide");
    }

    // Dynamic Item Loadings
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
                        item = Templates.tiles.replace(/{link}/g, this.link).replace(/{img}/g, this.image).replace(/{title}/g, this.title).replace(/{created}/g, this.time);
                        itemsContainer.append(item);
                    });
                }
            }
        });
    }
    $(".search-form input[name=searchword]").keypress(function (e) {
        $form = $(this).parents("form:first");
        $results = $form.parent().find(".box");
        var searchItemsTemplate = Templates.searchItems;
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
    if ($("#program-list").length) {
        $.ajax({
            url: base + 'api/programepisodes'
            , success: function (d) {
                $.each(d.items, function () {
                    $("#program-list").append('<option value="' + this.id + '">' + this.name + '</option>');
                });
                $("#program-list").select2({
                    dir: "rtl"
                });
            }
        });
    }

    // Misc
    Helper.equalHeights();
    responsiveResize();
    if ($(".schedule-header-date").length) {
        $(".schedule-header-date").appendTo('h1');
    }
});

$(window).resize(function () { // Change width value on user resize, after DOM
    responsiveResize();
});

// Functions
function responsiveResize() {
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

// Helper Objects
var Helper = {
    equalHeights: function () {
        var fullHeightHeight = 450;
        $(".full-height").each(function () {
            fullHeightHeight = ($(this).height() > fullHeightHeight) ? $(this).height() : fullHeightHeight;
        });
        $(".full-height").height(fullHeightHeight);
        return fullHeightHeight;
    }
};
var StringHelper = {
    getFirstWord: function (str) {
        if (str.indexOf(' ') === -1)
            return str;
        else
            return str.substr(0, str.indexOf(' '));
    }
    , isInt: function (n) {
        return typeof parseInt(n) === "number" && isFinite(parseInt(n)) && parseInt(n) % 1 === 0;
    }
    , ucfirst: function (string) {
        if (typeof string !== "undefined") {
            return string.charAt(0).toUpperCase() + string.slice(1);
        } else {
            return string;
        }
    }
};
var Templates = {
    tiles: '<li><figure class="img"><a href="{link}"><img src="{img}" alt="{title}" /></a></figure><div class="desc"><div class="item-header"><h3 class="item-title"><a href="{link}">{title}</a></h3></div><time class="created">{created}</time></div></li>'
    , searchItems: '<li><figure class="img"><a href="{item.link}"><img src="{item.imageSmall}" alt="{item.title}" /></a></figure><div class="desc"><h3><a href="{item.link}">{item.title}</a></h3></div></li>'
}
var BoxHelper = {
    showcase: function () {
        $itemWidth = $(".box.showcase > div ul").find("li:first").width();
        $showcaseItems = $(".box.showcase > div ul");
        if ($showcaseItems.find("li").length > 1) {
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
                , autoplay: true
                , autoplayTimeout: 7000
                , autoplayHoverPause: true

            });
        }
        $(".box.showcase > .carousel ul").find("li").each(function () {
            $(this).width($itemWidth);
        });
    }
    , thumbCarousels: function () {
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
    }
    , special: function () {
        $itemWidth = $(".box.special > .carousel ul").find("li:first").width();
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
    }
};

// Objects
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
function Feeds($obj) {
    this.obj = $obj;
    this.load = function (conf, data, $box, parent) {
        var items_tmpl = window["items_" + conf.tmpl];
        var box_tmpl = window["box_" + conf.tmpl];
        var items = '';
        var count = (conf.count == '-1') ? data.items.length : conf.count;
        for (var i = 0; i < count; i++) {
            items += items_tmpl.replace(/{site.url}/g, data.site.url)
                    .replace(/{category.link}/g, 'features' + data.category.link)
                    .replace(/{item.link}/g, data.items[i].link)
                    .replace(/{item.imageSmall}/g, data.items[i].imageSmall)
                    .replace(/{item.title}/g, data.items[i].title);
        }
        var box = box_tmpl.replace(/{site.url}/g, data.site.url)
                .replace(/{site.name}/g, data.site.name)
                .replace(/{items}/g, items);
        $box.parent().append(box);
        Helper.equalHeights();
        if (typeof conf.carousel !== "undefined" && conf.carousel === true)
            parent.createCarousel($box.parent().find("ul"));
    };
    this.createCarousel = function ($items) {
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
            , responsive: {
                0: {items: 2}
                , 480: {items: 2}
                , 980: {items: 3}
            }
        });
    };
    var __construct = function (that) {
        if (typeof that.obj === "undefined")
            return false;
        that.obj.each(function () {
            var conf = JSON.parse($(this).attr("data-conf"));
            var $box = $(this);
            $.ajax({
                url: conf.url
                , success: function (d) {
                    that.load(conf, d, $box, that);
                }
            });
        });
    }(this);
}

// Plugins
/*!
 * TrplClick - real Triple Click event plugin for jQuery
 * Version: 1.1.0
 * Author: @deliaz https://github.com/Deliaz
 * Licensed under the MIT license
 */
(function ($) {
    $.event.special.trplclick = {
        setup: function () {
            $(this).bind('click', clickHandler);
        },
        teardown: function () {
            $(this).unbind('click', clickHandler);
        },
        add: function (obj) {
            var oldHandler = obj.handler;

            // Default settings
            var defaults = {
                minClickInterval: 100,
                maxClickInterval: 500,
                minPercentThird: 85.0,
                maxPercentThird: 130.0
            };

            // Runtime
            var hasOne = false,
                    hasTwo = false,
                    time = [0, 0, 0],
                    diff = [0, 0];

            obj.handler = function (event, data) {
                var now = Date.now(),
                        conf = $.extend({}, defaults, event.data);

                // Clear runtime after timeout fot the 2nd click
                if (time[1] && now - time[1] >= conf.maxClickInterval) {
                    obj.clearRuntime();
                }
                // Clear runtime after timeout fot the 3rd click
                if (time[0] && time[1] && now - time[0] >= conf.maxClickInterval) {
                    obj.clearRuntime();
                }

                // Catch the third click
                if (hasTwo) {
                    time[2] = Date.now();
                    diff[1] = time[2] - time[1];

                    var deltaPercent = 100.0 * (diff[1] / diff[0]);

                    if (deltaPercent >= conf.minPercentThird && deltaPercent <= conf.maxPercentThird) {
                        oldHandler.apply(this, arguments);
                    }
                    obj.clearRuntime();
                }

                // Catch the first click
                else if (!hasOne) {
                    hasOne = true;
                    time[0] = Date.now();
                }

                // Catch the second click
                else if (hasOne) {
                    time[1] = Date.now();
                    diff[0] = time[1] - time[0];

                    (diff[0] >= conf.minClickInterval && diff[0] <= conf.maxClickInterval) ?
                            hasTwo = true : obj.clearRuntime();
                }

            };

            /**
             * Clear runtime
             */
            obj.clearRuntime = function () {
                hasOne = false;
                hasTwo = false;
                time[0] = 0;
                time[1] = 0;
                time[2] = 0;
                diff[0] = 0;
                diff[1] = 0;
                //cuz i'm thug
            };
        }
    };

    function clickHandler(event) {
        $(this).triggerHandler('trplclick', [event.data]);
    }

})(jQuery);
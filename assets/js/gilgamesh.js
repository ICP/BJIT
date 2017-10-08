//@prepros-append slick.min.js
//@prepros-append bootstrap.min.js

$ = (typeof $ === "undefined") ? jQuery.noConflict() : $;
        
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
    
    if ($(".box.comments.comment-form").length)
        new CommentForm();

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


    if (typeof (j2store) == 'undefined') {
        var j2store = {};
    }
    if (typeof (j2storeURL) == 'undefined') {
        var j2storeURL = '';
    }
    $(document).ready(function () {
        $.ajaxSetup({'beforeSend': function (xhr) {
                xhr.overrideMimeType('text/html; charset=UTF-8');
            }
        });
    });

    $(document).on('click', '.j2store_add_to_cart_button', function (e) {

        // AJAX add to cart request
        var $thisbutton = $(this);

        if (!$thisbutton.attr('data-product_id'))
            return true;

        $thisbutton.removeClass('added');
        $thisbutton.addClass('loading');

        var data = {
            option: 'com_j2store',
            view: 'carts',
            task: 'addItem',
            ajax: '1',
        };

        $.each($thisbutton.data(), function (key, value) {
            data[key] = value;
        });

        // Trigger event
        $('body').trigger('adding_to_cart', [$thisbutton, data]);

        var href = $thisbutton.attr('href');
        if (typeof href !== 'undefined' || href == '') {
            href = 'index.php';
        }

        // Ajax action
        $.post(href, data, function (response) {

            if (!response)
                return;

            var this_page = window.location.toString();

            this_page = this_page.replace('add-to-cart', 'added-to-cart');

            if (response['error']) {
                window.location = response.product_url;
                return;
            }

            if (response['redirect']) {
                window.location.href = response['redirect'];
                return;
            }
            if (response['success']) {
                $thisbutton.removeClass('loading');
                // Changes button classes
                $thisbutton.addClass('added');
                $thisbutton.parent().find('.cart-action-complete').show();
                //if module is present, let us update it.
                $('body').trigger('after_adding_to_cart', [$thisbutton, response, 'link']);
                //doMiniCart();
            }
        }, 'json');

        return false;


        return true;
    });
    $('.j2store-addtocart-form').each(function () {
        $(this).submit(function (e) {
            e.preventDefault();
            var form = $(this);

            //this will help detect if the form is submitted via ajax or normal submit.
            //sometimes people will submit the form before the DOM loads
            form.find('input[name=\'ajax\']').val(1);
            /* Get input values from form */
            var values = form.find('input[type=\'text\'], input[type=\'number\'], input[type=\'hidden\'], input[type=\'radio\']:checked, input[type=\'checkbox\']:checked, select, textarea');
            form.find('input[type=\'submit\']').val(form.find('input[type=\'submit\']').data('cart-action-always'));

            var href = form.attr('action');
            if (typeof href == 'undefined' || href == '') {
                var href = 'index.php';
            }
            // Trigger event
            $('body').trigger('adding_to_cart', [form, values]);
            //var values = form.serializeArray();
            var j2Ajax = $.ajax({
                url: href,
                type: 'post',
                data: values,
                dataType: 'json'

            });

            j2Ajax.done(function (json) {
                form.find('.j2success, .j2warning, .j2attention, .j2information, .j2error').remove();
                $('.j2store-notification').hide();
                if (json['error']) {

                    form.find('input[type=\'submit\']').val(form.find('input[type=\'submit\']').data('cart-action-done'));

                    if (json['error']['option']) {
                        for (i in json['error']['option']) {
                            form.find('#option-' + i).after('<span class="j2error">' + json['error']['option'][i] + '</span>');
                        }
                    }
                    if (json['error']['stock']) {
                        form.find('.j2store-notifications').html('<span class="j2error">' + json['error']['stock'] + '</span>');
                    }

                    if (json['error']['general']) {
                        form.find('.j2store-notifications').html('<span class="j2error">' + json['error']['general'] + '</span>');
                    }

                    if (json['error']['product']) {
                        form.find('.j2store-notifications').after('<span class="j2error">' + json['error']['product'] + '</span>');
                    }
                }

                if (json['redirect']) {
                    window.location.href = json['redirect'];
                }

                if (json['success']) {
                    setTimeout(function () {
                        form.find('input[type=\'submit\']').val(form.find('input[type=\'submit\']').data('cart-action-done'));
                        form.find('.cart-action-complete').fadeIn('slow');
                    }, form.find('input[type=\'submit\']').data('cart-action-timeout'));

                    $('body').trigger('after_adding_to_cart', [form, json, 'normal']);
                    //if module is present, let us update it.
                    //	doMiniCart();
                }
            })
                    .fail(function (jqXHR, textStatus, errorThrown) {
                        form.find('input[type=\'submit\']').val(form.find('input[type=\'submit\']').data('cart-action-done'));
                        console.log(textStatus + errorThrown);
                    })
                    .always(function (jqXHR, textStatus, errorThrown) {
                        //form.find('input[type=\'submit\']').val(form.find('input[type=\'submit\']').data('cart-action-always'));	 		
                    });
        });
    });
    if ($('#j2store_shipping_make_same').length > 0) {
        if ($('#j2store_shipping_make_same').is(':checked')) {
            $('#j2store_shipping_section').css({'visible': 'visible', 'display': 'none'});

            $('#j2store_shipping_section').children(".input-label").removeClass("required");

            $('#j2store_shipping_section').children(".input-text").removeClass("required");
        }
    }

    $('input[name=\'next\']').bind('click', function () {
        $('#j2store-cart-modules > div').hide();
        $('#' + this.value).slideToggle('slow');
    });
    $(document).on('click', '#button-quote', function () {
        var values = $('#shipping-estimate-form').serializeArray();
        $.ajax({
            url: 'index.php?option=com_j2store&view=carts&task=estimate',
            type: 'get',
            data: values,
            dataType: 'json',
            beforeSend: function () {
                $('#button-quote').after('<span class="wait">&nbsp;<img src="media/j2store/images/loader.gif" alt="" /></span>');
            },
            complete: function () {
                $('.wait').remove();
            },
            success: function (json) {
                $('.warning, .j2error').remove();
                if (json['error']) {
                    $.each(json['error'], function (key, value) {
                        if (value) {
                            $('#shipping-estimate-form #estimate_' + key).after('<br class="j2error" /><span class="j2error">' + value + '</span>');
                        }

                    });
                }

                if (json['redirect']) {
                    window.location.href = json['redirect'];
                }
            }
        });

    });
    $('select[name=\'country_id\']').bind('change', function () {
        $.ajax({
            url: 'index.php?option=com_j2store&view=carts&task=getCountry&country_id=' + this.value,
            type: 'get',
            dataType: 'json',
            beforeSend: function () {
                $('select[name=\'country_id\']').after('<span class="wait">&nbsp;<img src="' + Config.base + '/media/j2store/images/loader.gif" alt="" /></span>');
            },
            complete: function () {
                $('.wait').remove();
            },
            success: function (json) {

                html = '<option value="">' + shopCountry.defaultVal + '</option>';

                if (json['zone'] != '') {
                    for (i = 0; i < json['zone'].length; i++) {
                        html += '<option value="' + json['zone'][i]['j2store_zone_id'] + '"';

                        if (json['zone'][i]['j2store_zone_id'] == shopCountry.zone_id) {
                            html += ' selected="selected"';
                        }

                        html += '>' + json['zone'][i]['zone_name'] + '</option>';
                    }
                } else {
                    html += '<option value="0" selected="selected">' + shopCountry.noneChecked + '</option>';
                }

                $('select[name=\'zone_id\']').html(html);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });

    $('select[name=\'country_id\']').trigger('change');

    // Checkout
    $(document).on('change', '#checkout .checkout-content input[name=\'account\']', function () {
        if ($(this).attr('value') == 'register') {
            $('#billing-address .checkout-heading span').html(Checkout.account);
        } else {
            $('#billing-address .checkout-heading span').html(Checkout.address);
        }
    });

    $(document).on('click', '.checkout-heading a', function () {
        $('.checkout-content').slideUp('slow');

        $(this).parent().parent().find('.checkout-content').slideDown('slow');
    });

    //incase only guest checkout is allowed we got to process that first
    $(document).ready(function () {
        if (typeof Checkout !== "undefined" && Checkout.guestAllowed) {
            $('#billing-address .checkout-heading span').html(Checkout.address);
            $('#checkout').hide();
            $.ajax({
                url: Config.base,
                type: 'post',
                cache: false,
                data: 'option=com_j2store&view=checkout&task=guest',
                dataType: 'html',
                success: function (html) {
                    $('.warning, .j2error').remove();
                    $('#billing-address .checkout-content').html(html);
                    $('#checkout .checkout-content').slideUp('slow');
                    $('#billing-address .checkout-content').slideDown('slow');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        } else if (typeof Checkout !== "undefined" && Checkout.notLoggedIn) {
            $.ajax({
                url: Config.base,
                type: 'post',
                cache: false,
                data: 'option=com_j2store&view=checkout&task=login',
                success: function (html) {
                    $('#checkout .checkout-content').html(html);

                    $('#checkout .checkout-content').slideDown('slow');
                    $('body').trigger('after_login_response');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        } else {
            $.ajax({
                url: Config.base,
                type: 'post',
                cache: false,
                data: 'option=com_j2store&view=checkout&task=billing_address',
                dataType: 'html',
                success: function (html) {
                    $('#billing-address .checkout-content').html(html);

                    $('#billing-address .checkout-content').slideDown('slow');
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    });

    //new account
    $(document).on('click', '#button-account', function () {
        var task = $('input[name=\'account\']:checked').attr('value');
        $.ajax({
            url: Config.base,
            type: 'post',
            cache: false,
            data: 'option=com_j2store&view=checkout&task=' + task,
            dataType: 'html',
            beforeSend: function () {
                $('#button-account').attr('disabled', true);
                $('#button-account').after('<span class="wait">&nbsp;<img src="' + Config.base + '/media/j2store/images/loader.gif" alt="" /></span>');
            },
            complete: function () {
                $('#button-account').attr('disabled', false);
                $('.wait').remove();
            },
            success: function (html) {
                $('.warning, .j2error').remove();

                $('#billing-address .checkout-content').html(html);

                $('#checkout .checkout-content').slideUp('slow');

                $('#billing-address .checkout-content').slideDown('slow');

                $('.checkout-heading a').remove();

                $('#checkout .checkout-heading').append('<a>' + Checkout.modify + '</a>');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });

    //Login
    $(document).on('click', '#button-login', function () {
        $.ajax({
            url: Checkout.base,
            type: 'post',
            cache: false,
            data: $('#checkout #login :input'),
            dataType: 'json',
            beforeSend: function () {
                $('#button-login').attr('disabled', true);
                $('#button-login').after('<span class="wait">&nbsp;<img src="' + Config.base + '/media/j2store/images/loader.gif" alt="" /></span>');
            },
            complete: function () {
                $('#button-login').attr('disabled', false);
                $('.wait').remove();
            },
            success: function (json) {
                $('.warning, .j2error').remove();

                if (json['redirect']) {
                    //it is sufficient to just reload the page
                    location.reload(true);
                } else if (json['error']) {
                    $('#checkout .checkout-content').prepend('<div class="warning alert alert-danger" style="display: none;">' + json['error']['warning'] + '<button data-dismiss="alert" class="close" type="button">×</button></div>');

                    $('.warning').fadeIn('slow');
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });

    // Register
    $(document).on('click', '#button-register', function () {
        $.ajax({
            url: Checkout.base,
            type: 'post',
            cache: false,
            data: $('#billing-address input[type=\'text\'], #billing-address input[type=\'password\'], #billing-address input[type=\'checkbox\']:checked, #billing-address input[type=\'radio\']:checked, #billing-address input[type=\'hidden\'], #billing-address select, #billing-address textarea'),
            dataType: 'json',
            beforeSend: function () {
                $('#button-register').attr('disabled', true);
                $('#button-register').after('<span class="wait">&nbsp;<img src="' + Config.base + '/media/j2store/images/loader.gif" alt="" /></span>');
            },
            complete: function () {
                $('#button-register').attr('disabled', false);
                $('.wait').remove();
            },
            success: function (json) {
                $('.warning, .j2error').remove();

                if (json['redirect']) {
                    location = json['redirect'];
                } else if (json['error']) {
                    if (json['error']['warning']) {
                        $('#billing-address .checkout-content').prepend('<div class="warning alert alert-block alert-danger" style="display: none;">' + json['error']['warning'] + '<button data-dismiss="alert" class="close" type="button">×</button></div>');

                        $('.warning').fadeIn('slow');
                    }

                    $.each(json['error'], function (key, value) {
                        if (value) {
                            $('#billing-address #' + key).after('<br class="j2error" /><span class="j2error">' + value + '</span>');
                        }
                        //alert( key + ": " + value );
                    });

                    if (json['error']['password']) {
                        $('#billing-address input[name=\'password\'] + br').after('<span class="j2error">' + json['error']['password'] + '</span>');
                    }

                    if (json['error']['confirm']) {
                        $('#billing-address input[name=\'confirm\'] + br').after('<span class="j2error">' + json['error']['confirm'] + '</span>');
                    }

                } else {
                    if (Checkout.showShipping) {
                        var shipping_address = $('#billing-address input[name=\'shipping_address\']:checked').attr('value');

                        if (shipping_address) {
                            $.ajax({
                                url: Checkout.base,
                                type: 'post',
                                cache: false,
                                data: 'option=com_j2store&view=checkout&task=shipping_payment_method',
                                dataType: 'html',
                                success: function (html) {
                                    $('#shipping-payment-method .checkout-content').html(html);

                                    $('#billing-address .checkout-content').slideUp('slow');

                                    $('#shipping-payment-method .checkout-content').slideDown('slow');

                                    $('#checkout .checkout-heading a').remove();
                                    $('#billing-address .checkout-heading a').remove();
                                    $('#shipping-address .checkout-heading a').remove();
                                    $('#shipping-payment-method .checkout-heading a').remove();
                                    //$('#payment-method .checkout-heading a').remove();

                                    $('#shipping-address .checkout-heading').append('<a>' + Checkout.modify + '</a>');
                                    $('#billing-address .checkout-heading').append('<a>' + Checkout.modify + '</a>');
                                    $(window).scrollTop(200);
                                    $.ajax({
                                        url: Checkout.base,
                                        type: 'post',
                                        data: 'option=com_j2store&view=checkout&task=shipping_address',
                                        dataType: 'html',
                                        cache: false,
                                        success: function (html) {
                                            $('#shipping-address .checkout-content').html(html);
                                        },
                                        error: function (xhr, ajaxOptions, thrownError) {
                                            //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                        }
                                    });
                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                                    //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                }
                            });
                        } else {
                            $.ajax({
                                url: Checkout.base,
                                type: 'post',
                                cache: false,
                                data: 'option=com_j2store&view=checkout&task=shipping_address',
                                dataType: 'html',
                                success: function (html) {
                                    $('#shipping-address .checkout-content').html(html);

                                    $('#billing-address .checkout-content').slideUp('slow');

                                    $('#shipping-address .checkout-content').slideDown('slow');

                                    $('#checkout .checkout-heading a').remove();
                                    $('#billing-address .checkout-heading a').remove();
                                    $('#shipping-address .checkout-heading a').remove();
                                    $('#shipping-payment-method .checkout-heading a').remove();
                                    //$('#payment-method .checkout-heading a').remove();

                                    $('#billing-address .checkout-heading').append('<a>' + Checkout.modify + '</a>');
                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                                    //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                }
                            });
                        }
                    } else {
                        $.ajax({
                            url: Checkout.base,
                            type: 'post',
                            cache: false,
                            data: 'option=com_j2store&view=checkout&task=shipping_payment_method',
                            dataType: 'html',
                            success: function (html) {
                                $('#shipping-payment-method .checkout-content').html(html);

                                $('#billing-address .checkout-content').slideUp('slow');

                                $('#shipping-payment-method .checkout-content').slideDown('slow');

                                $('#checkout .checkout-heading a').remove();
                                $('#billing-address .checkout-heading a').remove();
                                //$('#payment-method .checkout-heading a').remove();
                                $('#shipping-payment-method .checkout-heading a').remove();

                                $('#billing-address .checkout-heading').append('<a>' + Checkout.modify + '</a>');
                                $(window).scrollTop(200);
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            }
                        });
                    }

                    $.ajax({
                        url: Checkout.base,
                        type: 'post',
                        cache: false,
                        data: 'option=com_j2store&view=checkout&task=billing_address',
                        dataType: 'html',
                        success: function (html) {
                            $('#billing-address .checkout-content').html(html);

                            $('#billing-address .checkout-heading span').html(Checkout.address);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });

    //billing address

    $(document).on('click', '#button-billing-address', function () {
        $.ajax({
            url: Checkout.base,
            type: 'post',
            cache: false,
            data: $('#billing-address input[type=\'text\'], #billing-address input[type=\'password\'], #billing-address input[type=\'checkbox\']:checked, #billing-address input[type=\'radio\']:checked, #billing-address input[type=\'hidden\'], #billing-address select, #billing-address textarea'),
            dataType: 'json',
            beforeSend: function () {
                $('#button-billing-address').attr('disabled', true);
                $('#button-billing-address').after('<span class="wait">&nbsp;<img ="' + Config.base + '"/media/j2store/images/loader.gif" alt="" /></span>');
            },
            complete: function () {
                $('#button-billing-address').attr('disabled', false);
                $('.wait').remove();
            },
            success: function (json) {
                $('.warning, .j2error').remove();

                if (json['redirect']) {
                    location = json['redirect'];
                } else if (json['error']) {
                    if (json['error']['warning']) {
                        $('#billing-address .checkout-content').prepend('<div class="warning" style="display: none;">' + json['error']['warning'] + '<button data-dismiss="alert" class="close" type="button">×</button></div>');

                        $('.warning').fadeIn('slow');
                    }

                    $.each(json['error'], function (key, value) {
                        if (value) {
                            $('#billing-address #' + key).after('<br class="j2error" /><span class="j2error">' + value + '</span>');
                        }
                    });

                } else {
                    if (Checkout.showShipping) {
                        $.ajax({
                            url: Checkout.base,
                            type: 'post',
                            cache: false,
                            data: 'option=com_j2store&view=checkout&task=shipping_address',
                            dataType: 'html',
                            success: function (html) {
                                $('#shipping-address .checkout-content').html(html);

                                $('#billing-address .checkout-content').slideUp('slow');

                                $('#shipping-address .checkout-content').slideDown('slow');

                                $('#billing-address .checkout-heading a').remove();
                                $('#shipping-address .checkout-heading a').remove();
                                $('#shipping-payment-method .checkout-heading a').remove();
                                //$('#payment-method .checkout-heading a').remove();

                                $('#billing-address .checkout-heading').append('<a>' + Checkout.modify + '</a>');
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            }
                        });
                    } else {
                        $.ajax({
                            url: Checkout.base,
                            type: 'post',
                            cache: false,
                            data: 'option=com_j2store&view=checkout&task=shipping_payment_method',
                            dataType: 'html',
                            success: function (html) {
                                $('#shipping-payment-method .checkout-content').html(html);

                                $('#billing-address .checkout-content').slideUp('slow');

                                $('#shipping-payment-method .checkout-content').slideDown('slow');

                                $('#billing-address .checkout-heading a').remove();
                                $('#shipping-payment-method .checkout-heading a').remove();

                                $('#billing-address .checkout-heading').append('<a>' + Checkout.modify + '</a>');
                                $(window).scrollTop(200);
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            }
                        });
                    }

                    $.ajax({
                        url: Checkout.base,
                        type: 'post',
                        cache: false,
                        data: 'option=com_j2store&view=checkout&task=billing_address',
                        dataType: 'html',
                        success: function (html) {
                            $('#billing-address .checkout-content').html(html);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });


    //Shipping Address

    $(document).on('click', '#button-shipping-address', function () {
        $.ajax({
            url: Checkout.base,
            type: 'post',
            cache: false,
            data: $('#shipping-address input[type=\'text\'], #shipping-address input[type=\'hidden\'], #shipping-address input[type=\'password\'], #shipping-address input[type=\'checkbox\']:checked, #shipping-address input[type=\'radio\']:checked, #shipping-address select, #shipping-address textarea'),
            dataType: 'json',
            beforeSend: function () {
                $('#button-shipping-address').attr('disabled', true);
                $('#button-shipping-address').after('<span class="wait">&nbsp;<img ="' + Config.base + '"/media/j2store/images/loader.gif" alt="" /></span>');
            },
            complete: function () {
                $('#button-shipping-address').attr('disabled', false);
                $('.wait').remove();
            },
            success: function (json) {
                $('.warning, .j2error').remove();
                if (json['redirect']) {
                    location = json['redirect'];
                } else if (json['error']) {
                    if (json['error']['warning']) {
                        $('#shipping-address .checkout-content').prepend('<div class="warning alert alert-danger" style="display: none;">' + json['error']['warning'] + '<button data-dismiss="alert" class="close" type="button">×</button></div>');

                        $('.warning').fadeIn('slow');
                    }

                    $.each(json['error'], function (key, value) {
                        if (value) {
                            $('#shipping-address #' + key).after('<br class="j2error" /><span class="j2error">' + value + '</span>');
                        }
                    });

                } else {
                    $.ajax({
                        url: Checkout.base,
                        type: 'post',
                        cache: false,
                        data: 'option=com_j2store&view=checkout&task=shipping_payment_method',
                        dataType: 'html',
                        success: function (html) {
                            $('#shipping-payment-method .checkout-content').html(html);

                            $('#shipping-address .checkout-content').slideUp('slow');

                            $('#shipping-payment-method .checkout-content').slideDown('slow');

                            $('#shipping-address .checkout-heading a').remove();
                            $('#shipping-payment-method .checkout-heading a').remove();
                            //$('#payment-method .checkout-heading a').remove();

                            $('#shipping-address .checkout-heading').append('<a>' + Checkout.modify + '</a>');
                            $(window).scrollTop(200);
                            $.ajax({
                                url: Checkout.base,
                                type: 'post',
                                cache: false,
                                data: 'option=com_j2store&view=checkout&task=shipping_address',
                                dataType: 'html',
                                success: function (html) {
                                    $('#shipping-address .checkout-content').html(html);
                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                                    //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                }
                            });
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });

                    $.ajax({
                        url: Checkout.base,
                        type: 'post',
                        cache: false,
                        data: 'option=com_j2store&view=checkout&task=billing_address',
                        dataType: 'html',
                        success: function (html) {
                            $('#billing-address .checkout-content').html(html);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });


    //Guest

    $(document).on('click', '#button-guest', function () {
        $.ajax({
            url: Checkout.base,
            type: 'post',
            cache: false,
            data: $('#billing-address input[type=\'text\'], #billing-address input[type=\'checkbox\']:checked, #billing-address input[type=\'radio\']:checked, #billing-address input[type=\'hidden\'], #billing-address select, #billing-address textarea'),
            dataType: 'json',
            beforeSend: function () {
                $('#button-guest').attr('disabled', true);
                $('#button-guest').after('<span class="wait">&nbsp;<img ="' + Config.base + '"/media/j2store/images/loader.gif" alt="" /></span>');
            },
            complete: function () {
                $('#button-guest').attr('disabled', false);
                $('.wait').remove();
            },
            success: function (json) {
                $('.warning, .j2error').remove();

                if (json['redirect']) {
                    location = json['redirect'];
                } else if (json['error']) {
                    if (json['error']['warning']) {
                        $('#billing-address .checkout-content').prepend('<div class="warning alert alert-danger" style="display: none;">' + json['error']['warning'] + '<button data-dismiss="alert" class="close" type="button">×</button></div>');

                        $('.warning').fadeIn('slow');
                    }

                    $.each(json['error'], function (key, value) {
                        if (value) {
                            $('#billing-address #' + key).after('<br class="j2error" /><span class="j2error">' + value + '</span>');
                        }
                    });

                } else {
                    if (Checkout.showShipping) {
                        var shipping_address = $('#billing-address input[name=\'shipping_address\']:checked').attr('value');

                        if (shipping_address) {
                            $.ajax({
                                url: Checkout.base,
                                type: 'post',
                                cache: false,
                                data: 'option=com_j2store&view=checkout&task=shipping_payment_method',
                                dataType: 'html',
                                success: function (html) {
                                    $('#shipping-payment-method .checkout-content').html(html);

                                    $('#billing-address .checkout-content').slideUp('slow');

                                    $('#shipping-payment-method .checkout-content').slideDown('slow');

                                    $('#billing-address .checkout-heading a').remove();
                                    $('#shipping-address .checkout-heading a').remove();
                                    $('#shipping-payment-method .checkout-heading a').remove();

                                    $('#billing-address .checkout-heading').append('<a>' + Checkout.modify + '</a>');
                                    $('#shipping-address .checkout-heading').append('<a>' + Checkout.modify + '</a>');
                                    $(window).scrollTop(200);
                                    $.ajax({
                                        url: Checkout.base,
                                        type: 'post',
                                        cache: false,
                                        data: 'option=com_j2store&view=checkout&task=guest_shipping',
                                        dataType: 'html',
                                        success: function (html) {
                                            $('#shipping-address .checkout-content').html(html);
                                        },
                                        error: function (xhr, ajaxOptions, thrownError) {
                                            //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                        }
                                    });
                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                                    //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                }
                            });
                        } else {
                            $.ajax({
                                url: Checkout.base,
                                type: 'post',
                                cache: false,
                                data: 'option=com_j2store&view=checkout&task=guest_shipping',
                                dataType: 'html',
                                success: function (html) {

                                    $('#shipping-address .checkout-content').html(html);

                                    $('#billing-address .checkout-content').slideUp('slow');

                                    $('#shipping-address .checkout-content').slideDown('slow');

                                    $('#billing-address .checkout-heading a').remove();
                                    $('#shipping-address .checkout-heading a').remove();
                                    $('#shipping-payment-method .checkout-heading a').remove();
                                    //$('#payment-method .checkout-heading a').remove();

                                    $('#billing-address .checkout-heading').append('<a>' + Checkout.modify + '</a>');
                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                                    //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                }
                            });
                        }
                    } else {
                        $.ajax({
                            url: Checkout.base,
                            type: 'post',
                            cache: false,
                            data: 'option=com_j2store&view=checkout&task=shipping_payment_method',
                            dataType: 'html',
                            success: function (html) {
                                $('#shipping-payment-method .checkout-content').html(html);

                                $('#billing-address .checkout-content').slideUp('slow');

                                $('#shipping-payment-method .checkout-content').slideDown('slow');

                                $('#billing-address .checkout-heading a').remove();
                                $('#shipping-payment-method .checkout-heading a').remove();

                                $('#billing-address .checkout-heading').append('<a>' + Checkout.modify + '</a>');
                                $(window).scrollTop(200);
                            },
                            error: function (xhr, ajaxOptions, thrownError) {
                                //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                            }
                        });
                    }
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });


    // Guest Shipping

    $(document).on('click', '#button-guest-shipping', function () {
        $.ajax({
            url: Checkout.base,
            type: 'post',
            cache: false,
            data: $('#shipping-address input[type=\'text\'], #shipping-address input[type=\'checkbox\']:checked, #shipping-address input[type=\'radio\']:checked, #shipping-address input[type=\'hidden\'], #shipping-address select, #shipping-address textarea'),
            dataType: 'json',
            beforeSend: function () {
                $('#button-guest-shipping').attr('disabled', true);
                $('#button-guest-shipping').after('<span class="wait">&nbsp;<img ="' + Config.base + '"/media/j2store/images/loader.gif" alt="" /></span>');
            },
            complete: function () {
                $('#button-guest-shipping').attr('disabled', false);
                $('.wait').remove();
            },
            success: function (json) {
                $('.warning, .j2error').remove();

                if (json['redirect']) {
                    location = json['redirect'];
                } else if (json['error']) {
                    if (json['error']['warning']) {
                        $('#shipping-address .checkout-content').prepend('<div class="warning alert alert-danger" style="display: none;">' + json['error']['warning'] + '<button data-dismiss="alert" class="close" type="button">×</button></div>');

                        $('.warning').fadeIn('slow');
                    }

                    $.each(json['error'], function (key, value) {
                        if (value) {
                            $('#shipping-address #' + key).after('<br class="j2error" /><span class="j2error">' + value + '</span>');
                        }
                    });
                } else {
                    $.ajax({
                        url: Checkout.base,
                        type: 'post',
                        cache: false,
                        data: 'option=com_j2store&view=checkout&task=shipping_payment_method',
                        dataType: 'html',
                        success: function (html) {
                            $('#shipping-payment-method .checkout-content').html(html);

                            $('#shipping-address .checkout-content').slideUp('slow');

                            $('#shipping-payment-method .checkout-content').slideDown('slow');

                            $('#shipping-address .checkout-heading a').remove();
                            $('#shipping-payment-method .checkout-heading a').remove();

                            $('#shipping-address .checkout-heading').append('<a>' + Checkout.modify + '</a>');
                            $(window).scrollTop(200);
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });


    //shipping and payment methods

    $(document).on('click', '#button-payment-method', function () {
        $.ajax({
            url: Checkout.base,
            type: 'post',
            cache: false,
            data: $('#shipping-payment-method input[type=\'text\'], #shipping-payment-method input[type=\'hidden\'], #shipping-payment-method input[type=\'radio\']:checked, #shipping-payment-method input[type=\'checkbox\']:checked, #shipping-payment-method textarea, #shipping-payment-method select'),
            dataType: 'json',
            beforeSend: function () {
                $('#button-payment-method').attr('disabled', true);
                $('#button-payment-method').after('<span class="wait">&nbsp;<img ="' + Config.base + '"/media/j2store/images/loader.gif" alt="" /></span>');
            },
            complete: function () {

            },
            success: function (json) {
                $('.warning, .j2error').remove();

                if (json['redirect']) {
                    location = json['redirect'];
                } else if (json['error']) {
                    $('.checkout-content').scrollTop();
                    if (json['error']['shipping']) {
                        $('#shipping_error_div').html('<span class="j2error">' + json['error']['shipping'] + '</span>');
                        $(window).scrollTop($('#shipping-payment-method').offset().top);
                    }

                    if (json['error']['warning']) {
                        $('#shipping-payment-method .checkout-content').prepend('<div class="warning alert alert-danger" style="display: none;">' + json['error']['warning'] + '<button data-dismiss="alert" class="close" type="button">×</button></div>');

                        $('.warning').fadeIn('slow');
                        $(window).scrollTop($('#shipping-payment-method .checkout-content .warning').offset().top);
                    }

                    $.each(json['error'], function (key, value) {
                        if (value) {
                            $('#shipping-payment-method #' + key).after('<br class="j2error" /><span class="j2error">' + value + '</span>');
                        }
                    });


                } else {
                    $.ajax({
                        url: Checkout.base,
                        type: 'post',
                        cache: false,
                        data: 'option=com_j2store&view=checkout&task=confirm',
                        dataType: 'html',
                        success: function (html) {
                            $('#confirm .checkout-content').html(html);

                            $('#shipping-payment-method .checkout-content').slideUp('slow');

                            $('#confirm .checkout-content').slideDown('slow');

                            $('#shipping-payment-method .checkout-heading a').remove();

                            $('#shipping-payment-method .checkout-heading').append('<a>' + Checkout.modify + '</a>');
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                }
                $('#button-payment-method').attr('disabled', false);
                $('.wait').remove();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });
});

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

function getFormData(target) {
    var d = document, ret = '';
    if (typeof (target) == 'string')
        target = d.getElementById(target);
    if (target === undefined)
        target = d;
    var typelist = ['input', 'select', 'textarea'];
    for (var t in typelist) {
        t = typelist[t];
        var inputs = target.getElementsByTagName(t);
        for (var i = inputs.length - 1; i >= 0; i--) {
            if (inputs[i].name && !inputs[i].disabled) {
                var evalue = inputs[i].value, etype = '';
                if (t == 'input')
                    etype = inputs[i].type.toLowerCase();
                if ((etype == 'radio' || etype == 'checkbox') && !inputs[i].checked)
                    evalue = null;
                if ((etype != 'file' && etype != 'submit') && evalue != null) {
                    if (ret != '')
                        ret += '&';
                    ret += encodeURI(inputs[i].name) + '=' + encodeURIComponent(evalue);
                }
            }
        }
    }
    return ret;
}
function loginKeyPress(e) {
    if (e.keyCode == 13) {
        $("#button-login").click();
    }
}
function j2storeUpdateShipping(name, price, tax, extra, code, combined) {
    (function ($) {
        var form = $('#j2store-cart-shipping-form');
        form.find("input[type='hidden'][name='shipping_name']").val(name);
        form.find("input[type='hidden'][name='shipping_code']").val(code);
        form.find("input[type='hidden'][name='shipping_price']").val(price);
        form.find("input[type='hidden'][name='shipping_tax']").val(tax);
        form.find("input[type='hidden'][name='shipping_extra']").val(extra);
        //override the task
        form.find("input[type='hidden'][name='task']").val('shippingUpdate');

        $.ajax({
            url: 'index.php?option=com_j2store&view=carts&task=shippingUpdate',
            type: 'get',
            data: $('#j2store-cart-shipping-form input[type=\'hidden\'], #j2store-cart-shipping-form input[type=\'radio\']:checked'),
            dataType: 'json',
            cache: false,
            beforeSend: function () {
                $('#j2store-cart-shipping').after('<span class="wait">&nbsp;<img src="' + Config.base + '/media/j2store/images/loader.gif" alt="" /></span>');
            },
            complete: function () {
                $('.wait').remove();
            },
            success: function (json) {
                if (json['redirect']) {
                    location = json['redirect'];
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                //alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    })($);
}
function doMiniCart() {
    (function ($) {
        var murl = j2storeURL
                + 'index.php?option=com_j2store&view=carts&task=ajaxmini';

        $.ajax({
            url: murl,
            type: 'get',
            cache: false,
            contentType: 'application/json; charset=utf-8',
            dataType: 'json',
            success: function (json) {
                if (json != null && json['response']) {
                    $.each(json['response'], function (key, value) {
                        if ($('.j2store_cart_module_' + key).length) {
                            $('.j2store_cart_module_' + key).each(function () {
                                $(this).html(value);
                            });
                        }
                    });
                }
            }

        });

    })($);

}

function j2storeDoTask(url, container, form, msg, formdata) {

    (function ($) {
        //to make div compatible
        container = '#' + container;

        // if url is present, do validation
        if (url && form) {
            var str = $(form).serialize();
            // execute Ajax request to server
            $.ajax({
                url: url,
                type: 'get',
                cache: false,
                contentType: 'application/json; charset=utf-8',
                data: formdata,
                dataType: 'json',
                beforeSend: function () {
                    $(container).before('<span class="wait"><img src="' + j2storeURL + 'media/j2store/images/loader.gif" alt="" /></span>');
                },
                complete: function () {
                    $('.wait').remove();
                },
                // data:{"elements":Json.toString(str)},
                success: function (json) {
                    if ($(container).length > 0) {
                        $(container).html(json.msg);
                    }
                    return true;
                }
            });
        } else if (url && !form) {
            // execute Ajax request to server
            $.ajax({
                url: url,
                type: 'get',
                cache: false,
                contentType: 'application/json; charset=utf-8',
                data: formdata,
                dataType: 'json',
                beforeSend: function () {
                    $(container).before('<span class="wait"><img src="' + j2storeURL + 'media/j2store/images/loader.gif" alt="" /></span>');
                },
                complete: function () {
                    $('.wait').remove();
                },
                success: function (json) {
                    if ($(container).length > 0) {
                        $(container).html(json.msg);
                    }
                }
            });
        }
    })($);
}

function j2storeSetShippingRate(name, price, tax, extra, code, combined, ship_element, css_id)
{

    (function ($) {
        $("input[type='hidden'][name='shipping_name']").val(name);
        $("input[type='hidden'][name='shipping_code']").val(code);
        $("input[type='hidden'][name='shipping_price']").val(price);
        $("input[type='hidden'][name='shipping_tax']").val(tax);
        $("input[type='hidden'][name='shipping_extra']").val(extra);
        var ship_name = name.replace(' ', '');
        $('#onCheckoutShipping_wrapper .shipping_element').hide();
        $('#onCheckoutShipping_wrapper .' + css_id + '_select_text').show();
    })($);

}


function doAjaxFilter(pov_id, product_id, po_id, id) {
    (function ($) {

        if (pov_id == '' || $('#ChildOptions' + po_id).length != 0) {
            $('#ChildOptions' + po_id).html('');
        }

        var form = $(id).closest('form');
        //sanity check
        if (form.data('product_id') != product_id)
            return;

        var values = form.serializeArray();
        // pop these params from values-> task : add & view : mycart
        values.pop({
            name: "task",
            value: 'addItem'
        });

        values.pop({
            name: "view",
            value: 'carts'
        });

        values.push({
            name: "product_id",
            value: product_id
        });

        var arrayClean = function (thisArray) {
            "use strict";
            $.each(thisArray, function (index, item) {
                if (item.name == 'task' || item.name == 'view') {
                    delete values[index];
                }
            });
        }
        arrayClean(values);

        //variable check
        if (form.data('product_type') == 'advancedvariable') {

            var csv = [];
            form.find('input[type=\'radio\']:checked, select').each(function (index, el) {
                if (el.value) {
                    if ($(el).data('is-variant')) {
                        csv.push(el.value);
                    }
                }
            });

            //need to sort the csv array to make sure correct array orde passing			

            var processed_csv = [];
            processed_csv = csv.sort(function (a, b) {
                return a - b
            });

            var $selected_variant = processed_csv.join();

            //get all variants
            //var $variants = form.data('product_variants');		


            var $variants = form.data('product_variants');


            var $variant_id = get_matching_variant($variants, $selected_variant);

            form.find('input[name=\'variant_id\']').val($variant_id);


            values.push({
                name: "variant_id",
                value: $variant_id
            });
        }
        values = values.filter(function (element) {
            return element !== undefined;
        });
        values = jQuery.param(values);
        $('body').trigger('before_doAjaxFilter', [form, values]);
        $.ajax({
            url: j2storeURL + 'index.php?option=com_j2store&view=products&task=update&po_id='
                    + po_id
                    + '&pov_id='
                    + pov_id
                    + '&product_id='
                    + product_id,
            type: 'get',
            cache: false,
            data: values,
            dataType: 'json',
            beforeSend: function () {
                $('#option-' + po_id).append('<span class="wait">&nbsp;<img src="' + j2storeURL + '/media/j2store/images/loader.gif" alt="" /></span>');
            },
            complete: function () {
                $('.wait').remove();
            },
            success: function (response) {

                var $product = $('.product-' + product_id);

                if ($product.length
                        && typeof response.error == 'undefined') {

                    //SKU
                    if (response.sku) {
                        $product.find('.sku').html(response.sku);
                    }
                    //base price
                    if (response.pricing.base_price) {
                        $product.find('.base-price').html(response.pricing.base_price);
                    }
                    //price
                    if (response.pricing.price) {
                        $product.find('.sale-price').html(response.pricing.price);
                    }

                    //afterDisplayPrice
                    if (response.afterDisplayPrice) {
                        $product.find('.afterDisplayPrice').html(response.afterDisplayPrice);
                    }

                    //qty
                    if (response.quantity) {
                        $product.find('input[name="product_qty"]').val(response.quantity);
                        if (form.data('product_type') == 'variable' || form.data('product_type') == 'advancedvariable') {
                            $product.find('input[name="product_qty"]').attr({
                                value: response.quantity
                            });
                        }
                    }

                    //dimensions
                    if (response.dimensions) {
                        $product.find('.product-dimensions').html(response.dimensions);
                    }

                    //weight
                    if (response.weight) {
                        $product.find('.product-weight').html(response.weight);
                    }

                    //stock status

                    if (typeof response.stock_status != 'undefined') {
                        if (response.availability == 1) {
                            $product.find('.product-stock-container').html('<span class="instock">' + response.stock_status + '</span>');
                        } else {
                            $product.find('.product-stock-container').html('<span class="outofstock">' + response.stock_status + '</span>');
                        }
                    }

                    // option html
                    if (response.optionhtml) {
                        $product.find(' #ChildOptions' + po_id).html(response.optionhtml);
                    }

                }
                $('body').trigger('after_doAjaxFilter_response', [$product, response]);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText
                        + "\r\n" + xhr.responseText);
            }
        });
    })($);
}

function get_matching_variant(variants, selected) {
    for (var i in variants) {
        if (variants[i] == selected)
            return i;
    }
}


function doAjaxPrice(product_id, id) {
    (function ($) {
        /* Get input values from form */
        var form = $(id).closest('form');
        //sanity check
        if (form.data('product_id') != product_id)
            return;

        var values = form.serializeArray();
        //pop these params from values-> task : add & view : mycart 			
        values.pop({
            name: "task",
            value: 'addItem'
        });

        values.pop({
            name: "view",
            value: 'carts'
        });

        values.push({
            name: "product_id",
            value: product_id
        });

        var arrayClean = function (thisArray) {
            "use strict";
            $.each(thisArray, function (index, item) {
                if (item.name == 'task' || item.name == 'view') {
                    delete values[index];
                }
            });
        }
        arrayClean(values);

        //variable check
        if (form.data('product_type') == 'variable' || form.data('product_type') == 'advancedvariable' || form.data('product_type') == 'variablesubscriptionproduct') {
            var csv = [];
            if (form.data('product_type') == 'advancedvariable') {
                form.find('input[type=\'radio\']:checked, select').each(function (index, el) {
                    if (el.value) {
                        if ($(el).data('is-variant')) {
                            csv.push(el.value);
                        }
                    }
                });
            } else {
                form.find('input[type=\'radio\']:checked, select').each(function (index, el) {
                    csv.push(el.value);
                });
            }
            var processed_csv = [];
            processed_csv = csv.sort(function (a, b) {
                return a - b
            });

            var $selected_variant = processed_csv.join();
            //get all variants
            var $variants = form.data('product_variants');

            var $variant_id = get_matching_variant($variants, $selected_variant);
            form.find('input[name=\'variant_id\']').val($variant_id);

            values.push({
                name: "variant_id",
                value: $variant_id
            });
        }
        values = values.filter(function (element) {
            return element !== undefined;
        });
        $('body').trigger('before_doAjaxPrice', [form, values]);
        $.ajax({
            url: j2storeURL + 'index.php?option=com_j2store&view=product&task=update',
            type: 'get',
            data: values,
            dataType: 'json',
            success: function (response) {

                var $product = $('.product-' + product_id);

                if ($product.length
                        && typeof response.error == 'undefined') {
                    //SKU
                    if (response.sku) {
                        $product.find('.sku').html(response.sku);
                    }
                    //base price
                    if (response.pricing.base_price) {
                        $product.find('.base-price').html(response.pricing.base_price);
                    }
                    //price
                    if (response.pricing.price) {
                        $product.find('.sale-price').html(response.pricing.price);
                    }
                    //afterDisplayPrice
                    if (response.afterDisplayPrice) {
                        $product.find('.afterDisplayPrice').html(response.afterDisplayPrice);
                    }
                    //qty
                    if (response.quantity) {
                        $product.find('input[name="product_qty"]').val(response.quantity);
                        if (form.data('product_type') == 'variable' || form.data('product_type') == 'advancedvariable' || form.data('product_type') == 'variablesubscriptionproduct') {
                            $product.find('input[name="product_qty"]').attr({
                                value: response.quantity
                            });
                        }
                    }
                    if (response.main_image) {

                        $product.find('.j2store-product-thumb-image-' + product_id).attr("src", response.main_image);
                        $('.j2store-product-thumb-image-' + product_id).attr("src", response.main_image);
                        $('.j2store-product-main-image-' + product_id).attr("src", response.main_image);
                        $product.find('.j2store-mainimage .j2store-img-responsive').attr("src", response.main_image);
                        $product.find('.j2store-product-additional-images .additional-mainimage').attr("src", response.main_image);
                    }
                    //stock status

                    if (typeof response.stock_status != 'undefined') {
                        if (response.availability == 1) {
                            $product.find('.product-stock-container').html('<span class="instock">' + response.stock_status + '</span>');
                        } else {
                            $product.find('.product-stock-container').html('<span class="outofstock">' + response.stock_status + '</span>');
                        }
                    }

                    //dimensions
                    if (response.dimensions) {
                        $product.find('.product-dimensions').html(response.dimensions);
                    }

                    //weight
                    if (response.weight) {
                        $product.find('.product-weight').html(response.weight);
                    }
                    // Trigger event
                    $('body').trigger('after_doAjaxFilter', [$product, response]);
                    $('body').trigger('after_doAjaxPrice', [$product, response]);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n"
                        + xhr.responseText);
            }
        });
    })($);
}

function setMainPreview(addimagId, product_id, imageZoom, zoom_type) {
    zoom_type = zoom_type || "outer";
    var src = "";
    (function ($) {
        src = $("#" + addimagId).attr('src');
        //$("#main-image-hidden").show();
        $("#j2store-item-main-image-" + product_id + " img").attr('src', '');
        $("#j2store-item-main-image-" + product_id + " img").attr('src', src);
        if (imageZoom) {
            if (zoom_type == 'outer') {
                $('#j2store-item-main-image-' + product_id).elevateZoom({
                    cursor: "crosshair",
                    zoomWindowFadeIn: 500,
                    zoomWindowFadeOut: 750,
                    zoomWindowWidth: 450,
                    zoomWindowHeight: 300
                });
            } else if (zoom_type == 'inner') {
                $("#j2store-item-main-image-" + product_id + " .zoomImg").attr('src', src);
                $("#j2store-item-main-image-" + product_id + " img").attr('src', src);
                $('#j2store-item-main-image-' + product_id).elevateZoom({
                    cursor: "crosshair",
                    zoomWindowFadeIn: 500,
                    zoomWindowFadeOut: 750,
                    zoomWindowWidth: 450,
                    zoomWindowHeight: 300
                });
            }
        }
    })($);
}

function removeAdditionalImage(product_id, main_image, imageZoom, zoom_type) {
    zoom_type = zoom_type || "outer";
    (function ($) {
        $("#j2store-item-main-image-" + product_id + " img").attr('src', main_image);
        setMainPreview('j2store-item-main-image-' + product_id, product_id, imageZoom, zoom_type);
    })($);
}

/**
 * Method to Submit the Form
 * used product list view filters
 */
function getJ2storeFiltersSubmit() {
    //show the loading image
    jQuery("#j2store-product-loading").show();
    //submit the form
    jQuery("#productsideFilters").submit();
}


function resetJ2storeBrandFilter(inputid) {
    if (inputid) {
        jQuery("#productsideFilters").find("#" + inputid).prop('checked', false);
    } else {
        jQuery(".j2store-brand-checkboxes").each(function () {
            this.checked = false;
        });
    }
    //getJ2storeFiltersSubmit();
}


/**
 * Method to reset the vendor filter
 */
function resetJ2storeVendorFilter(inputid) {
    if (inputid) {
        jQuery("#productsideFilters").find("#" + inputid).prop('checked', false);
    } else {
        jQuery(".j2store-vendor-checkboxes").each(function () {
            this.checked = false;
        });
    }
//	getJ2storeFiltersSubmit();
}


/**
 * Method to Reset Product Filter Based on the group
 * @params string productfilter checkboxes class name
 * @return result
 */
function resetJ2storeProductFilter(productfilter_class, inputid) {
    if (productfilter_class) {
        //loop the class element
        jQuery("." + productfilter_class).each(function () {
            //set the checked to false
            this.checked = false;
        });

    } else if (inputid) {
        jQuery("#productsideFilters").find("#" + inputid).prop('checked', false);
    }
//	getJ2storeFiltersSubmit();	
}

/** Toggle Methods **/
function getPriceFilterToggle() {
    (function ($) {
        $('#price-filter-icon-plus').toggle();
        $('#price-filter-icon-minus').toggle();
        $('#j2store-slider-range').toggle();
        $('#j2store-slider-range-box').toggle();
    })($);
}

function getCategoryFilterToggle() {
    (function ($) {
        $('#cat-filter-icon-plus').toggle();
        $('#cat-filter-icon-minus').toggle();
        $('#j2store_category').toggle();
    })($);
}

function getBrandFilterToggle() {
    (function ($) {
        $('#brand-filter-icon-plus').toggle();
        $('#brand-filter-icon-minus').toggle();
        $('#j2store-brand-filter-container').toggle();
    })($);
}

function getVendorFilterToggle() {
    (function ($) {
        $('#vendor-filter-icon-plus').toggle();
        $('#vendor-filter-icon-minus').toggle();
        $('#j2store-vendor-filter-container').toggle();
    })($);
}

function getPFFilterToggle(id) {
    (function ($) {
        $('#pf-filter-icon-plus-' + id).toggle();
        $('#pf-filter-icon-minus-' + id).toggle();
        $('#j2store-pf-filter-' + id).toggle();
    })($);
}

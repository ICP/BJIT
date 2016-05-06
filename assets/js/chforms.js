// gtooltip.js
jQuery.gtooltip={tipclass:"gtooltip",awaytime:800,ontime:0,ajax:0,ajax_cache:{},ajaxloading:"Loading....",append:"after",position:"top",closable:0,on_close:"hide",tid:"",content:"",trigger:"hover",resetOnShow:false,createOnShow:false,spacing:3,arrow_size:7,css:{"background-color":"#000","border-color":"#000","border-radius":"4px","border-width":"1px",padding:"8px",color:"#fff","font-size":"12px","max-width":"200px","text-align":"center"}};(function(a){a.fn.gtooltip=function(c,f){if(this.length>0){if(a.type(f)==="undefined"&&a.type(c)==="object"){f=c}if(a.type(c)==="undefined"||a.type(c)==="object"){f=a.extend(true,{},a.gtooltip,f);var e="";if(f.tid){e="-"+f.tid}return this.each(function(){if(!a(this).data("gtooltip"+e)){a(this).data("gtooltip"+e,new b(this,f))}})}if(a.type(c)==="string"){f=a.extend(true,{},a.gtooltip,f);var e="";if(f.tid){e="-"+f.tid}var d=a(this).data("gtooltip"+e);if(typeof d=="undefined"){return null}switch(c){case"show":return d.show();case"hide":return d.hide();case"destroy":return d.destroy();case"reset":return d.reset();case"get":return d.get()}}}};var b=function(c,d){this.element=c;this.settings=d;this.shown=false;this.hidden=false;this.content=null;this.location=null;this.init()};b.prototype={init:function(){var c=this;c.create();if(c.settings.trigger=="hover"){c.initHover()}else{if(c.settings.trigger=="click"){c.initClick()}}a(c.element).on("show.gtooltip",function(){if(c.settings.resetOnShow||c.settings.createOnShow){c.reset()}if(c.settings.ajax){if(a.type(a(c.element).data("ajax"))!=="undefined"){if(a.type(c.ajax_result)==="undefined"){c.setContent(c.settings.ajaxloading);c.reset();a.ajax({type:"GET",url:a(c.element).data("ajax"),cache:true,beforeSend:function(d){},success:function(d){c.setContent(d);c.ajax_result=d}})}}}})},get:function(){var c=this;return c},destroy:function(){var c=this;c.tip.remove();var d="";if(c.settings.tid){d="-"+c.settings.tid}a(c.element).removeData("gtooltip"+d);return true},initClick:function(){var c=this;a(c.element).on("click",function(){if(c.shown){c.hide()}else{c.show()}})},initHover:function(){var c=this;a(c.element).on("mouseover",function(){clearTimeout(c.awaytime);var d=setTimeout(function(){c.show();c.tip.on("mouseover",function(){clearTimeout(c.awaytime)});c.tip.on("mouseleave",function(){var e=setTimeout(function(){c.hide()},c.settings.awaytime);c.awaytime=e})},c.settings.ontime);c.ontime=d});a(c.element).on("mouseleave",function(){clearTimeout(c.ontime);var d=setTimeout(function(){c.hide()},c.settings.awaytime);c.awaytime=d})},initClose:function(){var c=this;c.tip.find(".gtooltip-close").on("click",function(){a(c.element).trigger("close.gtooltip");if(c.settings.on_close=="hide"){c.hide()}else{if(c.settings.on_close=="destroy"){c.destroy()}}})},initContent:function(){var c=this;if(a(c.element).prop("title")){c.content=a(c.element).prop("title");a(c.element).prop("title","")}if(c.settings.content){c.content=c.settings.content}else{if(a(c.element).data("content")){c.content=a(c.element).data("content")}else{}}},setContent:function(d){var c=this;c.content=d;c.tip.find(".gtooltip-content").html(d)},show:function(){var c=this;a(c.element).triggerHandler("show.gtooltip");c.tip.show();c.shown=true;c.hidden=false;return true},hide:function(){var c=this;a(c.element).triggerHandler("hide.gtooltip");c.tip.hide();c.hidden=true;c.shown=false;return true},reset:function(){var c=this;if(a.type(c.tip)!=="undefined"&&a.contains(document,c.tip[0])){c.tip.remove()}c.create();return true},create:function(){var c=this;if(a.type(c.tip)!=="undefined"&&a.contains(document,c.tip[0])){return}c.createTip();c.positionTip();c.styleTip();c.initClose()},createTip:function(){var c=this;if(c.settings.closable){var d='<div class="gtooltip-close">&times;</div>'}else{var d=""}c.tip=a('<div class="'+c.settings.tipclass+'" tid="'+c.settings.tid+'">'+d+'<div class="gtooltip-content"></div><div class="gtooltip-arrow-border gtooltip-arrow-border-'+c.settings.position+'"></div><div class="gtooltip-arrow gtooltip-arrow-'+c.settings.position+'"></div></div>');c.initContent();c.setContent(c.content)},positionTip:function(){var c=this;var d=a(c.element).offset();var e=a(c.element).position();if(a(c.element).data("target")){var d=a(c.element).data("target").offset();var e=a(c.element).data("target").position()}if(c.settings.append=="after"){a(c.element).after(c.tip);c.location=e}else{if(c.settings.append=="body"){a("body").append(c.tip);c.location=d}}},styleTip:function(){var c=this;c.tip.css(c.settings.css);var h={};h["border-"+c.settings.position+"-color"]=c.settings.css["background-color"];c.tip.find(".gtooltip-arrow").css(h);var g={};g["border-"+c.settings.position+"-color"]=c.settings.css["border-color"];c.tip.find(".gtooltip-arrow-border").css(g);c.tip.find(".gtooltip-arrow, .gtooltip-arrow-border").css("border-width",c.settings.arrow_size+"px");var d=parseInt(c.settings.css["border-width"]);if(c.settings.position=="top"){var i=c.location.top-c.tip.outerHeight()-c.tip.find(".gtooltip-arrow").outerHeight()-c.settings.spacing;var e=c.location.left+a(c.element).outerWidth()/2-c.tip.outerWidth()/2;var f=a(window).height()-i-c.tip.outerHeight(true);c.tip.find(".gtooltip-arrow-border").css("left",c.tip.outerWidth()/2-c.tip.find(".gtooltip-arrow-border").outerWidth()/2);c.tip.find(".gtooltip-arrow").css("left",c.tip.outerWidth()/2-c.tip.find(".gtooltip-arrow").outerWidth()/2);c.tip.find(".gtooltip-arrow, .gtooltip-arrow-border").css("border-bottom-width","0px");c.tip.find(".gtooltip-arrow").css("bottom",-1*(c.settings.arrow_size)+"px");c.tip.find(".gtooltip-arrow-border").css("bottom",-1*(c.settings.arrow_size+d+1)+"px");c.tip.find(".gtooltip-arrow-border").css("border-top-width",(c.settings.arrow_size+1)+"px")}else{if(c.settings.position=="bottom"){var i=c.location.top+a(c.element).outerHeight()+c.tip.find(".gtooltip-arrow").outerHeight()+c.settings.spacing;var e=c.location.left+a(c.element).outerWidth()/2-c.tip.outerWidth()/2;c.tip.find(".gtooltip-arrow-border").css("left",c.tip.outerWidth()/2-c.tip.find(".gtooltip-arrow-border").outerWidth()/2);c.tip.find(".gtooltip-arrow").css("left",c.tip.outerWidth()/2-c.tip.find(".gtooltip-arrow").outerWidth()/2);c.tip.find(".gtooltip-arrow, .gtooltip-arrow-border").css("border-top-width","0px");c.tip.find(".gtooltip-arrow").css("top",-1*(c.settings.arrow_size)+"px");c.tip.find(".gtooltip-arrow-border").css("top",-1*(c.settings.arrow_size+d+1)+"px");c.tip.find(".gtooltip-arrow-border").css("border-bottom-width",(c.settings.arrow_size+1)+"px")}else{if(c.settings.position=="right"){var i=c.location.top+a(c.element).outerHeight()/2-c.tip.outerHeight()/2;var e=c.location.left+a(c.element).outerWidth()+c.tip.find(".gtooltip-arrow").outerWidth()+c.settings.spacing;c.tip.find(".gtooltip-arrow-border").css("top",c.tip.outerHeight()/2-c.tip.find(".gtooltip-arrow-border").outerHeight()/2);c.tip.find(".gtooltip-arrow").css("top",c.tip.outerHeight()/2-c.tip.find(".gtooltip-arrow").outerHeight()/2);c.tip.find(".gtooltip-arrow, .gtooltip-arrow-border").css("border-left-width","0px");c.tip.find(".gtooltip-arrow").css("left",-1*(c.settings.arrow_size)+"px");c.tip.find(".gtooltip-arrow-border").css("left",-1*(c.settings.arrow_size+d+1)+"px");c.tip.find(".gtooltip-arrow-border").css("border-right-width",(c.settings.arrow_size+1)+"px")}else{if(c.settings.position=="left"){var i=c.location.top+a(c.element).outerHeight()/2-c.tip.outerHeight()/2;var e=c.location.left-c.tip.outerWidth()-c.tip.find(".gtooltip-arrow").outerWidth()-c.settings.spacing;c.tip.find(".gtooltip-arrow-border").css("top",c.tip.outerHeight()/2-c.tip.find(".gtooltip-arrow-border").outerHeight()/2);c.tip.find(".gtooltip-arrow").css("top",c.tip.outerHeight()/2-c.tip.find(".gtooltip-arrow").outerHeight()/2);c.tip.find(".gtooltip-arrow, .gtooltip-arrow-border").css("border-right-width","0px");c.tip.find(".gtooltip-arrow").css("right",-1*(c.settings.arrow_size)+"px");c.tip.find(".gtooltip-arrow-border").css("right",-1*(c.settings.arrow_size+d+1)+"px");c.tip.find(".gtooltip-arrow-border").css("border-left-width",(c.settings.arrow_size+1)+"px")}}}}c.tip.css("top",i);if(c.settings.position=="top"&&c.settings.append=="body"){c.tip.css("bottom",f);c.tip.css("top","")}c.tip.css("left",e);c.tip.hide();return true}}}(jQuery));

// gvalidation.js
jQuery.gvalidation={rules:{required:/[^.*]/,alpha:/^[a-z ._-]+$/i,alphanum:/^[a-z0-9 ._-]+$/i,digit:/^[-+]?[0-9]+$/,nodigit:/^[^0-9]+$/,nospace:/^[^ ]+$/,number:/^[-+]?\d*\.?\d+$/,email:/^([a-zA-Z0-9_\.\-\+%])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/,image:/.(jpg|jpeg|png|gif|bmp)$/i,phone:/^\+{0,1}[0-9 \(\)\.\-]+$/,phone_inter:/^\+{0,1}[0-9 \(\)\.\-]+$/,url:/^(http|https|ftp)\:\/\/[a-z0-9\-\.]+\.[a-z]{2,3}(:[a-z0-9]*)?\/?([a-z0-9\-\._\?\,\'\/\\\+&amp;%\$#\=~])*$/i},errors:{required:"This field is required.",alpha:"This field accepts alphabetic characters only.",alphanum:"This field accepts alphanumeric characters only.",digit:"Please enter a valid integer.",nodigit:"No digits are accepted.",nospace:"No spaces are accepted.",number:"Please enter a valid number.",email:"Please enter a valid email.",image:"This field should only contain image types",phone:"Please enter a valid phone.",phone_inter:"Please enter a valid international phone number.",url:"Please enter a valid url.",group:"Please make at least %1 selection(s).",confirm:"Please make sure that the value matches the %1 field value.",custom:"The value entered is not valid."},display:"tooltip",css:{"background-color":"#ff4242","border-color":"#ff0000",padding:"4px"}};(function(b){b.fn.gvalidate=function(c,e){if(this.length>0){if(b.type(e)==="undefined"&&b.type(c)==="object"){e=c}if(b.type(c)==="undefined"||b.type(c)==="object"){e=b.extend({},b.gvalidation,e);return this.each(function(){if(!b(this).data("gvalidation")){b(this).data("gvalidation",new a(this,e))}})}if(b.type(c)==="string"){e=b.extend({},b.gvalidation,e);var d=b(this).data("gvalidation");if(typeof d=="undefined"||!d){return null}switch(c){case"get":return d.get()}}}};var a=function(c,d){this.element=c;this.settings=d;this.rules=[];this.errors={};this.invalid_rule="";this.error_shown=false;this.disabled=false;this.init()};a.prototype={init:function(){var c=this;if(b(c.element).is(":input")){c.validate(false);b(c.element).on("change",function(){c.validate(true)});b(c.element).on("blur",function(){c.validate(true)})}else{if(b(c.element).prop("tagName")=="FORM"){b(c.element).find(":input").each(function(d,e){b(e).gvalidate()});b(c.element).on("submit",function(d){b(c.element).find(":input").each(function(e,f){b(f).gvalidate()});if(c.validate_area()==true){b(c.element).trigger("success.gvalidation");return true}else{d.stopImmediatePropagation();b(c.element).trigger("fail.gvalidation");return false}});b(c.element).on("reset",function(d){setTimeout(function(){b(c.element).find(":input").trigger("change")},500)})}else{return c.validate_area()}}},validate_area:function(){var d=this;var c=null;b(d.element).find(":input").each(function(e,f){b(f).gvalidate();if(c==null){var g=b(f).gvalidate("get");if(!g.validate()){c=g;return false}}});if(c!=null){b(c.element).focus();b("html, body").animate({scrollTop:b(c.element).offset().top-100},300);c.show_error();return false}return true},get:function(){var c=this;return c},reset:function(){var c=this;b(c.element).data("gvalidation",null)},validate:function(d){var e=this;e.inspect();var c=e.check();if(c){if(e.rule_name(e.invalid_rule)=="group"){b('input[class*="'+e.invalid_rule+'"]').each(function(h,f){var g=b(f).gvalidate("get");if(g!=null){g.remove_error()}})}else{if(e.rules.length&&e.rule_name(e.rules[0])=="group"){b('input[class*="'+e.rules[0]+'"]').each(function(h,f){var g=b(f).gvalidate("get");if(g!=null){g.remove_error()}})}else{e.remove_error()}}}else{if(e.rule_name(e.invalid_rule)=="group"){b('input[class*="'+e.invalid_rule+'"]').each(function(h,f){var g=b(f).gvalidate("get");if(g!=null){g.check()}})}if(d==true){e.show_error()}}return c},inspect:function(){var d=this;var c=b(d.element).prop("class").match(/validate\[(.*?)\]/g);if(c){b.each(c,function(e,g){var f=g.match(/validate\[(.*?)\]/);if(f&&typeof f[1]!="undefined"){var h=f[1].split(",");var i=[];b.each(h,function(j,k){k=k.replace(/("|')/g,"");i.push(k)});d.set_rules(i)}})}},check:function(){var c=this;var d=true;b(c.element).trigger("check.gvalidation");b.each(c.rules,function(e,f){if(!c.check_rule(f)){c.invalid_rule=f;d=false;return false}});if(d==false){b(c.element).trigger("invalid.gvalidation")}if(c.disabled==true){return true}if(b(c.element).is(":hidden")){return true}return d},set_rules:function(d){var c=this;c.rules=d},check_rule:function(i){var h=this;if(b(h.element).prop("disabled")){return true}var d=b(h.element).prop("type");var g=i.split(":");if(b.gvalidation.rules.hasOwnProperty(g[0])){if(b.inArray(d,["checkbox","radio"])>-1){return b(h.element).prop("checked")}else{if(g[0]=="required"){if(b(h.element).val()==null){return false}else{if(b.isArray(b(h.element).val())){if(b(h.element).val().length==0){return false}else{return true}}else{return b(h.element).val().trim().match(b.gvalidation.rules[g[0]])}}}else{return(!b(h.element).val().trim()||b(h.element).val().trim().match(b.gvalidation.rules[g[0]]))}}}else{if(g[0]=="group"){var f=0;b('input[class*="'+i+'"]').each(function(k,j){if(b(j).prop("checked")){f=f+1}});var c=(g[2]?g[2]:1);return(f>=c)}else{if(g[0]=="confirm"){return(b("#"+g[1]).val()==b(h.element).val())}else{if(g[0]=="custom"){var e=g[1];if(e in window){return window[e](b(h.element))}return true}}}}},show_error:function(){var f=this;if(!f.invalid_rule){return}var d=f.invalid_rule.split(":");rule=d[0];if(typeof f.errors[rule]=="undefined"){if(b(f.element).prop("title")){f.errors[rule]=b(f.element).prop("title")}else{var e=b.gvalidation.errors[rule];if(rule=="group"){var c=false;b('input[class*="'+f.invalid_rule+'"]').each(function(k,h){var j=b(h).gvalidate("get");var g=(j==null?false:j.error_shown);if(g!==false){c=true;return false}});if(c){return}}if(rule=="group"){if(typeof d[2]=="undefined"){d[1]=1}}b.each(d,function(g,h){e=e.replace("%"+g,h)});f.errors[rule]=e}}f.display_error();f.error_shown=true},display_error:function(){var d=this;b(d.element).trigger("display.gvalidation");var c=b(d.element);if(b(d.element).data("gvalidation-target")){var c=b(d.element).data("gvalidation-target")}if(b.gvalidation.display=="tooltip"){c.data("content",'<span class="gvalidation-error-text">'+d.errors[d.rule_name(d.invalid_rule)]+"</span>");c.gtooltip({tipclass:"gtooltip gvalidation-error-tip",closable:1,tid:"gval",trigger:"manual",css:d.settings.css});c.gtooltip("reset",{tid:"gval"});c.gtooltip("show",{tid:"gval"})}else{}},remove_error:function(){var c=this;if(!c.invalid_rule){return}c.errors={};c.error_shown=false;c.invalid_rule="";if(b.gvalidation.display=="tooltip"){b(c.element).gtooltip("destroy",{tid:"gval"})}else{}},disable:function(){var c=this;c.disabled=true},enable:function(){var c=this;c.disabled=false},rule_name:function(d){var c=d.split(":");return c[0]},rule_params:function(d){var c=d.split(":");c.splice(0,1);return c}}}(jQuery));

// fa.js
jQuery.gvalidation.errors=jQuery.extend(jQuery.gvalidation.errors,{required:"این فیلد الزامی است.",alpha:"لطفا فقط از ٘ҙə`الفباء برای این بخش استفاده کنید. کاراکترهای دیگر و فاصله مجاز نیستند.",alphanum:"لطفا فقط از ٘ҙə`الفباء و اعداد در این بخش استفاده کنید. کاراکترهای دیگر و فاصله مجاز نیستند.",nodigit:"لطفا عدد وارد نکنید.",digit:"لطفا یک عدد صٛ͘ وارد کنید.",digitmin:"عدد باید بزرگتر از %1 باشد.",digitltd:"عدد باید بین %1 و 1% باشد.",number:"لطفا یک عدد معتبر وارد کنید.",email:"لطفا یک ایمیل معتبر وارد کنید: <br /><span>نمونه: yourn...@domain.com</span>",image:"لطفا فقط تصویر انتخاب کنید.",phone:"لطفا یک شماره تلفن معتبر وارد کنید.",url:"لطفا یک URL صٛ͘ وارد کنید: <br /><span>نمونه: http://www.domain.com</span>",confirm:"این بخش با %1 متفاوت است.",differs:"این بخش باید با %1 متفاوت باشد.",length_str:"طول مقدار وارد شده صٛ͘ نیست و باید بین %1 و %2 کاراکتر باشد.",length_fix:"طول مقدار وارد شده صٛ͘ نیست و باید دقیقا برابر %1 کاراکتر باشد.",lengthmax:"طول مقدار وارد شده صٛ͘ نیست و باید ٘ИȚʘ̘Ѡ%1 کاراکتر باشد.",lengthmin:"طول مقدار وارد شده صٛ͘ نیست و باید ٘ИșÙĠ%1 کاراکتر باشد.",words_min:"این بخش باید ٘șɛ̠٘ИșÙĠ%1 کلمه باشد. %2 کلمه وارد شده.",words_range:"این بخش باید ٘șɛ̠%1-%2 کلمه باشد. %3 کلمه وارد شده.",words_max:"این بخش باید ٘șɛ̠٘ИȚʘ̘Ѡ%1 کلمه باشد. %2 کلمه وارد شده.",checkbox:"لطفا این مورد را انتخاب کنید.",group:"Please make at least %1 selection(s).",custom:"لطفا این گزینه را انتخاب کنید",select:"لطفا مقداری را انتخاب کنید"});

// Inline
function loadForm() {
    $(".register-form").gvalidate();
    $(".register-form").find(":input").on("invalid.gvalidation", function () {
        var field = $(this);
        if (field.is(":hidden")) {
            if (field.closest(".tab-pane").length > 0) {
                var tab_id = field.closest(".tab-pane").attr("id");
                $('a[href="#' + tab_id + '"]').closest(".nav").gtabs("get").show($('a[href="#' + tab_id + '"]'));
            }
            if (field.closest(".panel-collapse").length > 0) {
                var slider_id = field.closest(".panel-collapse").attr("id");
                $('a[href="#' + slider_id + '"]').closest(".panel-group").gsliders("get").show($('a[href="#' + slider_id + '"]'));
            }
        }
        if (field.data("wysiwyg") == "1") {
            field.data("gvalidation-target", field.parent());
        }
    });
    $(".register-form").on("success.gvalidation", function (e) {
        if ($(".register-form").data("gvalidate_success")) {
            var gvalidate_success = $(".register-form").data("gvalidate_success");
            if (gvalidate_success in window) {
                window[gvalidate_success](e, $(".register-form"));
            }
        }
    });
    $(".register-form").on("fail.gvalidation", function (e) {
        if ($(".register-form").data("gvalidate_fail")) {
            var gvalidate_fail = $(".register-form").data("gvalidate_fail");
            if (gvalidate_fail in window) {
                window[gvalidate_fail](e, $(".register-form"));
            }
        }
    });
    function chronoforms_validation_signs(formObj) {
        formObj.find(":input[class*=validate]").each(function () {
            if ($(this).attr("class").indexOf("required") >= 0 || $(this).attr("class").indexOf("group") >= 0) {
                var required_parent = [];
                if ($(this).closest(".gcore-subinput-container").length > 0) {
                    var required_parent = $(this).closest(".gcore-subinput-container");
                } else if ($(this).closest(".gcore-form-row, .form-group").length > 0) {
                    var required_parent = $(this).closest(".gcore-form-row, .form-group");
                }
                if (required_parent.length > 0) {
                    var required_label = required_parent.find("label");
                    if (required_label.length > 0 && !required_label.first().hasClass("required_label")) {
                        required_label.first().addClass("required_label");
                        required_label.first().html(required_label.first().html() + " <i class='fa fa-asterisk' style='color:#ff0000; font-size:9px; vertical-align:top;'></i>");
                    }
                }
            }
        });
    }
    chronoforms_validation_signs($(".register-form"));
    function chronoforms_data_tooltip(formObj) {
        formObj.find(":input").each(function () {
            if ($(this).data("tooltip") && $(this).closest(".gcore-input, .gcore-input-wide").length > 0) {
                var tipped_parent = [];
                if ($(this).closest(".gcore-subinput-container").length > 0) {
                    var tipped_parent = $(this).closest(".gcore-subinput-container");
                } else if ($(this).closest(".gcore-form-row, .form-group").length > 0) {
                    var tipped_parent = $(this).closest(".gcore-form-row, .form-group");
                }
                if (tipped_parent.length > 0) {
                    var tipped_label = tipped_parent.find("label");
                    if (tipped_label.length > 0 && !tipped_label.first().hasClass("tipped_label")) {
                        tipped_label.first().addClass("tipped_label");
                        var $tip = $("<i class='fa fa-exclamation-circle input-tooltip' style='color:#2693FF; padding-left:5px;'></i>");
                        $tip.data("content", $(this).data("tooltip"));
                        tipped_label.first().append($tip);
                    }
                }
            }
        });
        formObj.find(".input-tooltip").gtooltip();
    }
    chronoforms_data_tooltip($(".register-form"));
    function chronoforms_data_loadstate(formObj) {
        formObj.find(':input[data-load-state="disabled"]').prop("disabled", true);
        formObj.find('*[data-load-state="hidden"]').css("display", "none");
        formObj.find(':input[data-load-state="hidden_parent"]').each(function () {
            if ($(this).closest(".gcore-subinput-container").length > 0) {
                $(this).closest(".gcore-subinput-container").css("display", "none");
            } else if ($(this).closest(".gcore-form-row").length > 0) {
                $(this).closest(".gcore-form-row").css("display", "none");
            }
        });
    }
    chronoforms_data_loadstate($(".register-form"));
    function chrono_ajax_submit() {
        $(document).on("click", ".register-form :input[type=submit]", function (event) {
            $(".register-form").append("<input type='hidden' name='" + $(this).attr("name") + "' value='" + $(this).val() + "' />");
        });
        var files;
        $("input[type=file]").on("change", function (event) {
            files = event.target.files;
        });
        $(document).on("submit", ".register-form", function (event) {
            var overlay = $("<div/>").css({
                "position": "fixed",
                "top": "0",
                "left": "0",
                "width": "100%",
                "height": "100%",
                "background-color": "#000",
                "filter": "alpha(opacity=50)",
                "-moz-opacity": "0.5",
                "-khtml-opacity": "0.5",
                "opacity": "0.5",
                "z-index": "10000",
                "background-image": "url(\"http://localhost/irib/tourism/libraries/cegcore/assets/images/loading-small.gif\")",
                "background-position": "center center",
                "background-repeat": "no-repeat",
            });
            if (!$(".register-form").hasClass("form-overlayed")) {
                $(".register-form").append(overlay);
                $(".register-form").addClass("form-overlayed");
            }
            var form_action = $(".register-form").prop("action");
            var sep = (form_action.indexOf("?") > -1) ? "&" : "?";
            var ajax_url = form_action + sep + "tvout=ajax";
            //data processing
            $.ajax({
                "type": "POST",
                "url": ajax_url,
                "data": $(".register-form").serialize(),
                "success": function (res) {
                    $(".register-form").replaceWith(res);
                    $(".register-form").gvalidate();
                    chronoforms_fields_events();
                    chronoforms_validation_signs($(".register-form"));
                    chronoforms_data_tooltip($(".register-form"));
                    chronoforms_data_loadstate($(".register-form"));
                    if (typeof chronoforms_pageload_fields_events == "function") {
                        chronoforms_pageload_fields_events();
                    }
                    //chrono_ajax_submit();//this line duplicates submissions, should be removed
                },
            });
            return false;
        });
    }
    chrono_ajax_submit();
    function chronoforms_fields_events() {
        $("[name='workshop_req']").on("click", function () {
            if ($("[name='workshop_req']:checked").val() == "1") {
                $("#fin-workshop_type, #workshop_type").css("display", "");
            }
            if ($("[name='workshop_req']:checked").val() == "0") {
                $("#fin-workshop_type, #workshop_type").css("display", "none");
            }
        });
    }
    chronoforms_fields_events();
    function chronoforms_pageload_fields_events() {
        if ($("[name='workshop_req']:checked").val() == "1") {
            $("#fin-workshop_type, #workshop_type").css("display", "");
        }
        if ($("[name='workshop_req']:checked").val() == "0") {
            $("#fin-workshop_type, #workshop_type").css("display", "none");
        }
    }
    chronoforms_pageload_fields_events();
}
function clearForm() {
    $(".register-form").find(":input").off("invalid.gvalidation");
    $(".register-form").off("success.gvalidation");
    $(".register-form").off("fail.gvalidation");
    
    $(document).off("click", ".register-form :input[type=submit]");
    $("input[type=file]").off("change");
    $(document).off("submit", ".register-form");
    $("[name='workshop_req']").off("click");
}
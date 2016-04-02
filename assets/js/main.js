$(function() {
    $("[data-toggle]").each(function () {
//        var href = typeof($(this).attr('href')) !== "undefined" ? $(this).attr('href') : $(this).attr('data-target');
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
});


(function($){$.fn.hoverizr=function(m){var o={'effect':"grayscale",'overlay':"top",'container':"overlayed",'width':"responsive",'height':"auto",'stretch':"no",'speedIn':"slow",'speedOut':"fast"};var m=$.extend(o,m);if($('img').css('maxWidth')!="none"){var p=1;$('img').css('maxWidth',"none")}else{var p=0}this.each(function(){$(this).wrap('<div class="'+m.container+'" />');$(this).parent('.'+m.container+'').css({'position':'relative'});$(this).parent('.'+m.container+'').append('<canvas class="canv"></canvas>');$(this).next('.canv').css({'position':'absolute','top':'0','left':'0','z-index':10});if(m.overlay=="top"){$(this).css({'z-index':-1})}else{$(this).css({'z-index':1});$(this).next('.canv').css({'display':'none'})}var a=$(this).width();var b=$(this).height();$(this).next('.canv').attr({"width":a,"height":b});var c=$(this).next('.canv').get(0);var d=c.getContext("2d");var f=$(this).get(0);d.drawImage(f,0,0);if(m.effect!='noise'&&'blur'){try{try{var g=d.getImageData(0,0,a,b)}catch(e){netscape.security.PrivilegeManager.enablePrivilege("UniversalBrowserRead");var g=d.getImageData(0,0,a,b)}}catch(e){throw new Error("unable to access image data: "+e)}var h=g.data}switch(m.effect){case"invert":for(var i=0,n=h.length;i<n;i+=4){h[i]=255-h[i];h[i+1]=255-h[i+1];h[i+2]=255-h[i+2]}break;case"blur":var j,x,y;var k=new Image;k.src=$(this).attr('src');d.globalAlpha=0.0625;for(y=-3;y<3;y+=1){for(x=-3;x<3;x+=1){d.drawImage(k,x,y)}}d.globalAlpha=1;break;default:for(var i=0,n=h.length;i<n;i+=4){var l=h[i]*.3+h[i+1]*.59+h[i+2]*.11;h[i]=l;h[i+1]=l;h[i+2]=l}break}if(m.effect!=("blur"||"noise")){d.putImageData(g,0,0)}if(m.width=="responsive"){$(this).next('.canv').css({'max-width':'100%'});$(this).css({'max-width':'100%'});$(this).parent('.'+m.container+'').css({'width':'100%'})}else if(m.stretch=="no"){$(this).parent('.'+m.container+'').css({'width':m.width,'height':m.height,overflow:"hidden"})}else{$(this).next('.canv').css({'width':m.width,'height':m.height});$(this).css({'width':m.width,'height':m.height});$(this).parent('.'+m.container+'').css({'width':m.width,'height':m.height})}});if(p==1){$('img').css('maxWidth',"100%")}if(m.overlay=="top"){this.parent('.'+m.container+'').hover(function(){$(this).children('.canv').stop(true,true).fadeOut(m.speedOut)},function(){$(this).children('.canv').stop(true,true).fadeIn(m.speedIn)})}else{this.parent('.'+m.container+'').hover(function(){$(this).children('.canv').stop(true,true).fadeIn(m.speedOut)},function(){$(this).children('.canv').stop(true,true).fadeOut(m.speedIn)})}}})(jQuery);
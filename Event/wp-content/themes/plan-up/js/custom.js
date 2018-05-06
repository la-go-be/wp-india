;(function($) {

    "use strict";
    var HAINTHEME = HAINTHEME || {};
    var previousScroll = 0;

    //== Check if element exist
    //
    $.fn.exists = function(callback) {
        var args = [].slice.call(arguments, 1);
        if (this.length) {
            callback.call(this, args);
        }
        return this;
    };

    //===== Header area
    //
    HAINTHEME.navbar = function() {
        /*
        Desktop Menu
         */
        $('#site-navigation ul li').each(function() {
            $(this).on({
                mouseenter: function(e) {
                    $(this).find('ul').first()
                        .css({display:"block"})
                        .stop()
                        .animate(
                        {
                            opacity: 0.99,
                            'margin-top': 0
                        },
                        {
                            duration: 300
                        }
                    );
                },
                mouseleave: function(e) {
                    $(this).find('ul').first()
                        .stop()
                        .animate(
                        {
                            opacity: 0,
                            'margin-top': -15
                        },
                        {
                            duration: 300,
                            complete : function() {
                                $(this).css({display:"none"});
                            }
                        }
                    );
                }
            });
            $(this).find('ul').first().find('li').on({
                mouseenter: function(e) {
                    $(this).find('ul').first()
                        .css({display:"block"})
                        .stop()
                        .animate(
                        {
                            opacity: 0.99
                        },
                        {
                            duration: 300
                        }
                    );
                },
                mouseleave: function(e) {
                    $(this).find('ul').first()
                        .stop()
                        .animate(
                        {
                            opacity: 0
                        },
                        {
                            duration: 300,
                            complete : function() {
                                $(this).css({display:"none"});
                            }
                        }
                    );
                }
            })
        });
        /*
        Mobile Menu
         */
        $('ul.dl-submenu').each(function(index, el) {
            var sub = $(this);
            var cl = $(this).closest('li').attr('class');
            $(this).closest('li').find('a:first').each(function(index, el) {
                sub.prepend('<li class="'+cl+'">'+$(this).prop('outerHTML')+'</li>');
            });
        });
        $( '#dl-menu' ).dlmenu({
            animationClasses : { classin : 'dl-animate-in-5', classout : 'dl-animate-out-5' }
        });
        if( $('#dl-menu-sc').length > 0 )
            $('.blog-header-wrapper').remove();
        $('#dl-menu-sc').dlmenu({
            animationClasses : { classin : 'dl-animate-in-5', classout : 'dl-animate-out-5' }
        });
        /*
        Sticky Menu
         */
        if( !($(window).width() < 768) ){
            $('.has_sticky.blog-header-wrapper:not(".not-sticky")').sticky();
            $('.has_sticky.blog-header-wrapper:not(".not-sticky")').on({
                'sticky-start' : function() {
                    $(this).addClass('sticky');
                },
                'sticky-end' : function() {
                    $(this).removeClass('sticky');
                }
            });
            $('.has_sticky.blog-navigation.sc:not(".not-sticky")').sticky();
            $('.has_sticky.blog-navigation.sc:not(".not-sticky")').on({
                'sticky-start' : function() {
                    $(this).addClass('sticky');
                },
                'sticky-end' : function() {
                    $(this).removeClass('sticky');
                }
            });
        }
        /*One Page nav*/
        $('ul.primary.menu, ul.dl-menu.primary').onePageNav({
            currentClass: 'active',
            changeHash: false,
            scrollSpeed: 750,
            scrollThreshold: 1,
            filter: '',
            easing: 'swing',
        });
    };

    //===== Slider
    //
    HAINTHEME.slider = function() {
        $('.flexslider.basic').each(function(){
            $(this).flexslider({
                namespace       :   "flex-",
                selector        :   ".slides > li",
                animation       :   $(this).data('effect'), //"fade" or "slide"
                slideshow       :   $(this).data('auto'), // Boolean: Animate slider automatically
                easing          :   "easeInOutExpo", // Easing
                useCSS          :   true, // Use css animation
                direction       :   $(this).data('direction'), // horizontal, vertical
                controlNav      :   $(this).data('pager'), // Pagination
                directionNav    :   $(this).data('navi'), // Next, prev
                animationSpeed  :   $(this).data('animation-speed'),
                slideshowSpeed  :   $(this).data('slide-speed'),
                smoothHeight    :   false,
                prevText        :   '<i class ="ion-ios-arrow-thin-left"></i>',
                nextText        :   '<i class ="ion-ios-arrow-thin-right"></i>',
                start: function(slider){
                    $('.ht-preload-slider').fadeOut('1000');
                    $('.flexslider.basic').fadeIn();
                    var curSlide = slider.find("li.flex-active-slide");
                    curSlide.find('.slider-caption').animate({opacity: 1}, 3000);
                },
                after: function(slider){
                    var curSlide = slider.find("li.flex-active-slide");
                    curSlide.find('.slider-caption').animate({opacity: 1}, 3000);
                },
                end: function(slider){
                    $('.slider-caption').css('opacity', '0');
                }
            });
        });
        $('.flexslider.sync').each(function(){
            $($(this).data('sync')).flexslider({
                asNavFor        :   $('#'+$(this).attr('id')),
                animation       :   "slide",
                itemWidth       :   60,
                directionNav    :   false,
                controlNav      :   false,
                animationLoop   :   false,
                itemMargin      :   0
            });
            $(this).flexslider({
                sync            :   $(this).data('sync'),
                namespace       :   "flex-",
                selector        :   ".slides > li",
                animation       :   $(this).data('effect'), //"fade" or "slide"
                slideshow       :   $(this).data('auto'), // Boolean: Animate slider automatically
                //easing            :   "easeInOutExpo", // Easing
                useCSS          :   true, // Use css animation
                direction       :   $(this).data('direction'), // horizontal, vertical
                controlNav      :   $(this).data('pager'), // Pagination
                directionNav    :   $(this).data('navi'), // Next, prev
                animationSpeed  :   $(this).data('animation-speed'),
                slideshowSpeed  :   $(this).data('slide-speed'),
                smoothHeight    :   false,
                prevText        :   '<i class ="ion-ios-arrow-left"></i>',
                nextText        :   '<i class ="ion-ios-arrow-right"></i>'
            });
        });
        $('.ht-carousel').each(function(){
            $(this).find('.slides').owlCarousel({
                responsive : {
                    0: {
                        items: $(this).data('items')[0]
                    },
                    481: {
                        items: $(this).data('items')[1]
                    },
                    769: {
                        items: $(this).data('items')[2]
                    },
                    993: {
                        items: $(this).data('items')[3]
                    },
                    1201: {
                        items: $(this).data('items')[4]
                    }
                },
                loop: $(this).data('loop'),

                autoplay: $(this).data('auto'),
                autoplayTimeout: $(this).data('slide-speed'),
                autoplayHoverPause: true,

                smartSpeed: $(this).data('animation-speed'),

                fallbackEasing: 'swing',

                nestedItemSelector: false,
                itemElement: 'div',
                stageElement: 'div',

                // Classes and Names
                themeClass: '',
                baseClass: 'owl-carousel',
                itemClass: 'owl-item',
                centerClass: 'center',
                activeClass: 'active',

                dots: $(this).data('pager'),
                nav: $(this).data('navi'),
                navText: ['<i class ="ion-ios-arrow-thin-left"></i>', '<i class ="ion-ios-arrow-thin-right"></i>']
            });
        });
        $('.slides-ajax-loading').remove();
        $('.ht-carousel .slides, .flexslider.basic .slides').show();
    };

    //===== Isotope
    //
    HAINTHEME.isotope = function() {
        $('.isotope-filter').each(function(){
            var targetGrid = $(this).data('target');
            $(targetGrid).isotope({
                itemSelector: '.entry',
                layoutMode: 'masonry',
                transitionDuration: '1s'
            });
            $(this).find('a').on( 'click', function(e) {
                $(this).parent().parent().find('li').removeClass('is-filtered');
                $(this).parent().addClass('is-filtered');
                var filterValue = $(this).data('filter');
                $(targetGrid).isotope({
                    filter: filterValue,
                    transitionDuration: '1s'
                });
                e.preventDefault();
            });
        });
    };

    //===== Masonry
    //
    HAINTHEME.masonry = function() {
        $('.ht-masonry-layout').each(function(){
            var gridSizer = $(this).data('grid-size');
            $(this).isotope({
                layoutMode: 'masonry',
                columnWidth: gridSizer,
                isFitWidth: true,
                gutter: '1'
            });
        });
    };

    //===== Comment Reply
    //
    HAINTHEME.commentReply = function() {
        var html =
        '<div class="comment-reply">'+
            '<button class="close">&times;</button>'+
            '<div class="">'+
                '<h3 class="heading">REPLY TO THIS COMMENT</h3>'+
            '</div>'+
            '<form action="">'+
                '<div class="form-group half">'+
                    '<label for="">Name <span class="label-description">(ex: William) <sup>*</sup></span></label>'+
                    '<input type="text">'+
                '</div>'+
                '<div class="form-group half">'+
                    '<label for="">Email <span class="label-description">(Not Published)</span> <sup>*</sup></label>'+
                    '<input type="text">'+
                '</div>'+
                '<div class="form-group half">'+
                    '<label for="">Website <span class="label-description">(Optional)</span></label>'+
                    '<input type="text">'+
                '</div>'+
                '<div class="form-group">'+
                    '<label for="">Comment <sup>*</sup></label>'+
                    '<textarea name="" id="" cols="30" rows="5"></textarea>'+
                '</div>'+
                '<div class="form-group submit-group">'+
                    '<div><input type="checkbox"> Notify me of followup comments in this post via email</div>'+
                    '<button type="submit" class="ht-button view-more-button">'+
                        '<i class="fa fa-arrow-left"></i> SUBMIT <i class="fa fa-arrow-right"></i>'+
                    '</button>'+
                '</div>'+
            '</form>'+
        '</div>'

        $('.comment-reply-link').on('click', function() {
            var target = $(this).attr('href');
            if ($(target).find('.comment-reply').length == 0) {
                $(target).find('.comment-content').append(html);
            }
        });

        $(document).on('click', '.comment-reply .close', function(){
            $(this).parent().remove();
        });
    };

    HAINTHEME.googleMapAPI = function() {
        var mapCounter = 1;
        $('.ht-map').each(function(){
            $(this).attr('id','ht-map-'+ mapCounter);
            mapCounter++;
            var coor = $(this).data('coor');
            var id = $(this).attr('id');
            var zooming = $(this).data('zoom');
            var mapType = $(this).data('map-type');
            var controlUI = $(this).data('control-ui') ? false : true;
            var scrollWheel = $(this).data('scroll-wheel');
            var marker = $(this).data('marker');
            var style = $(this).data('style');

            $(this).css('height',$(this).data('height'));

            function initialize() {
                var map_canvas = document.getElementById(id);
                var myLatlng = new google.maps.LatLng(coor[0],coor[1]);
                var map_options = {
                    center: myLatlng,
                    zoom: zooming,
                    mapTypeId: mapType,
                    disableDefaultUI: controlUI,
                    scrollwheel: scrollWheel,
                    styles: style
                }
                var map = new google.maps.Map(map_canvas, map_options);
                if (marker != "") {
                    var mapMarker = new google.maps.Marker({
                        position: myLatlng,
                        map: map,
                        title: marker
                    });
                }
            }
            google.maps.event.addDomListener(window, 'load', initialize);
        });
    };

    HAINTHEME.recipeSubmit = function() {
        var minutesConverter = function(minute) {
            var hou = Math.floor(minute / 60);
            var min = minute % 60;

            hou = hou > 9 ? hou : '0' + hou;
            min = min > 9 ? min : '0' + min;

            return hou + ':' + min;
        }
        $('.upload').each(function() {
            var $target = $($(this).data('target'));
            var $button = $(this).find('a.upload-trigger');
            var $visibleInput = $(this).find('.upload-visible');

            $button.on('click', function(e) {
                $target.trigger('click');
                e.preventDefault();
            })
            $target.on('change', function() {
                $visibleInput.val($(this).val());
            })
        });
        $( ".slider-range" ).each(function() {
            var $this = $(this);
            var $targetInput = $($(this).data('target'));
            $this.slider({
                // range: true,
                min: 0,
                max: $(this).data('max') * 60,
                step: 1,
                values: [ 0 ],
                slide: function( event, ui ) {
                    $targetInput.val( minutesConverter(ui.values[ 0 ]) );
                }
            });
        })
    };

    HAINTHEME.parallaxGen = function() {
        $('[data-ht-parallax]').each(function() {
            var dataMove = $(this).attr("data-ht-parallax");
            var dataAttrFrom, dataFrom, dataAttrTo, dataTo;
            if($(this).is('#ht-top-area')) {
                var height = $(this).outerHeight();
                dataAttrFrom = 'data-0';
                dataFrom = 'background-position:0px 0px';
                dataAttrTo = 'data-' + height;
                dataTo = 'background-position: 0px ' + dataMove + 'px';
            } else {
                dataAttrFrom = 'data-bottom-top';
                dataFrom = 'background-position: 0px -' + dataMove + 'px';
                dataAttrTo = 'data-top-bottom';
                dataTo = 'background-position:0px 0px';
            }
            $(this).attr(dataAttrFrom,dataFrom).attr(dataAttrTo,dataTo);
        });
    };

    HAINTHEME.parallaxInit = function() {
        var vW = $(window).width();
        if( vW >= 768) {
            var s = skrollr.init({
                forceHeight: false,
                smoothScrolling: false,
                smoothScrollingDuration: 200,
                easing: {
                    wtf: Math.random,
                        inverted: function(p) {
                        return 1 - p;
                    }
                }
            });
        } else {
            var s = skrollr.init();
            s.destroy();
        }
        if(Modernizr.touch) {
            var s = skrollr.init();
            s.destroy();
        }
    };

    HAINTHEME.others = function() {
        $('.ht-accordion').each(function() {
            var $this = $(this);
            $(this).find('.panel-heading').on('click', function() {
                $this.find('.panel-heading').removeClass('current');
                $(this).addClass('current');
            })
        });

        //Twitter shortcode
        $('.timelines-navigation a, .timeline-badge a').click(function(event) {
            event.preventDefault();
            var target = $(this).attr('href');
            $('.timelines-navigation a').removeClass('active');
            $('.timelines-navigation a[href="'+target+'"]').addClass('active');
            $('ul.timeline').fadeOut("200");
            $('ul.timeline').promise().done(function(){
                $('ul.timeline'+target).fadeIn("400");
            });
        });

        $('.tweet-navigation a').click(function(event) {
            event.preventDefault();
            var target = $(this).attr('href');
            // console.log(target);
            $('.wrap-twitter .tweet-navigation a').removeClass('current');
            $('.wrap-twitter .tweet-navigation a[href='+target+']').addClass('current');
            $('.wrap-twitter .tweet-entry').fadeOut("200");
            $('.wrap-twitter .tweet-entry').promise().done(function(){
                 $('.tweet-entry.entry'+target).fadeIn("400");
            });
        });
        //Unwrap anchor from image in info block shortcode
        $('.slide-info .info-text a > img').unwrap();
        $('.slide-info img').removeAttr("width").removeAttr("height");
        // Scroll (in pixels) after which the "To Top" link is shown
        var offset = 300,
        //Scroll (in pixels) after which the "back to top" link opacity is reduced
        offset_opacity = 1200,
        //Get the "To Top" link
        $back_to_top = $('#back-to-top');

        //Visible or not "To Top" link
        $(window).scroll(function(){
            if ( $(this).scrollTop() > offset ) {
                $back_to_top
                    .css({display:"block"})
                    .stop()
                    .animate(
                    {
                        opacity: 0.5,
                    },
                    {
                        duration: 300,
                        easing: "easeOutExpo"
                    }
                );
            } else {
                $back_to_top
                    .stop()
                    .animate(
                    {
                        opacity: 0,
                    },
                    {
                        duration: 300,
                        easing: "easeOutExpo",
                        complete : function() {
                            $(this).css({display:"none"});
                        }
                    }
                );
            }
            if( $(this).scrollTop() > offset_opacity ) {
                $back_to_top.addClass('top-fade-out');
            }
        });

        //Smoothy scroll to top
        $back_to_top.on('click', function(event){
            $("html, body").animate({scrollTop : 0}, 1000 ,"easeInOutExpo");
            event.preventDefault();
        });
        // Wow animation
        if($(document).width() > 767 ){
            new WOW().init();
        }
        /*Flickr Widget*/
        $('.ht-online-gallery.flickr').isotope({
            itemSelector: '.ht-online-gallery.flickr > div',
            percentPosition: true,
            masonry: {
                // use outer width of grid-sizer for columnWidth
                columnWidth: '.ht-online-gallery.flickr > div'
            }
        });
        /*Click the button to go to form*/
        $('a.fw-btn, a.btn, li.reserve > a').click(function(event) {
            var target = $(this).attr('href');
            if( target.indexOf("http") < 0 ){
                event.preventDefault();
                var sc = $(target).offset().top;
                $("html, body").animate({scrollTop : sc}, 1000);
            }
        });
        /*Slider paginatio*/
        $('<span>0</span>').prependTo('.flex-control-paging li a');
        if( $('.header-slider').hasClass('vertical-direction') ){
            $('<li><a class="flex-prev"><i class="ion-ios-arrow-thin-up"></i></a></li>').prependTo('.flex-control-paging');
            $('<li><a class="flex-next"><i class="ion-ios-arrow-thin-down"></i></a></li>').appendTo('.flex-control-paging');
        }else{
            $('<li><a class="flex-prev"><i class="ion-ios-arrow-thin-left"></i></a></li>').prependTo('.flex-control-paging');
            $('<li><a class="flex-next"><i class="ion-ios-arrow-thin-right"></i></a></li>').appendTo('.flex-control-paging');
        }
        $('.flex-control-nav .flex-prev').click(function(event) {
            event.preventDefault();
            event.stopPropagation();
            $('.flexslider').flexslider("prev");
        });
        $('.flex-control-nav .flex-next').click(function(event) {
            event.preventDefault();
            event.stopPropagation();
            $('.flexslider').flexslider("next");
        });

        /*Reservation form validation submit on safari*/
        if (true || navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1){
            $('form.fw_form_fw_form input[type=submit]').on('click', function(event) {
                event.preventDefault();
                if( !$('form.fw_form_fw_form')[0].checkValidity() ){
                    /*https://github.com/jaredreich/notie.js*/
                    notie.alert(3, 'Please enter a valid email and do not leave the required fields empty!', 6);
                    $('.fw_form_fw_form input[required=required]').css('border-color', '#f30c74');
                }else{
                    $('form.fw_form_fw_form').trigger('submit');
                }
            });
        }
        //Prevent form from submiting when ENTER key pressed
        $('form.fw_form_fw_form, form.event-register-form').on('keyup keypress', function(e) {
            var code = e.keyCode || e.which;
            if (code == 13) {
                e.preventDefault();
                return false;
            }
        });
    };

    HAINTHEME.ht_slider_setEqualHeight = function(selector) {
        var heights = new Array();

        $(selector).each(function() {

            $(this).css('min-height', '0');
            $(this).css('max-height', 'none');
            $(this).css('height', 'auto');

            heights.push($(this).height());
        });

        var max = Math.max.apply( Math, heights );
        $(selector).each(function() {
            $(this).css('height', max + 'px');
        });
    }

    $(document).ready( function() {
        $('html').removeClass('no-js');
        HAINTHEME.slider();
        HAINTHEME.ht_slider_setEqualHeight('.header-has-slide .slides li');
        HAINTHEME.navbar();
        HAINTHEME.isotope();
        HAINTHEME.masonry();
        HAINTHEME.parallaxInit();
        HAINTHEME.others();
    });

    $(window)
    .on( 'load', function() {
        HAINTHEME.isotope();
        HAINTHEME.masonry();
    })
    .on( 'resize', function() {
        HAINTHEME.ht_slider_setEqualHeight('.header-has-slide .slides li');
    })
    .on( 'scroll', function() {
    });
    // Timeline tabs menu
    $(".tl2-nav a").on('click', function(event) {
        event.preventDefault();
        $(this).addClass("tl2-nav-current");
        $(this).siblings().removeClass("tl2-nav-current");
        var tab = $(this).attr("href");
        $(".tl2-content").not(tab).css("display", "none");
        $(tab).fadeIn(1000);
    });

})(jQuery); // EOF
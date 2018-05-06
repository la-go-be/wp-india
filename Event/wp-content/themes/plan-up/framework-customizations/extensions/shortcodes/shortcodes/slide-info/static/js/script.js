jQuery(document).ready(function($) {
    //Caarousel
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
});
(function($) {

    $('.accordion > .accordion-title:first, .accordion > .accordion-title > a:first').addClass('active');
    $('.accordion > .accordion-content:not(:first)').hide();
    var allPanels = $('.accordion > .accordion-content');

    $('.accordion > .accordion-title').click(function(event) {
        event.preventDefault();
        if( !$(this).find('a').eq(0).hasClass('active') ){
            $('.accordion > .accordion-title a').removeClass().addClass('ion-arrow-down-b');
            $(this).find('a').eq(0).removeClass().addClass('ion-arrow-up-b active');
            allPanels.slideUp();
            $(this).next().slideDown();
            $('.accordion > .accordion-title').removeClass('active');
            $(this).addClass('active');
        }
        return false;
    });

})(jQuery);
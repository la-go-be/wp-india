(function($) {

    $('.accordion > .accordion-title:first, .accordion > .accordion-title > a:first').addClass('active');
    $('.accordion > .accordion-content:not(:first)').hide();
    var allPanels = $('.accordion > .accordion-content');

    $('.accordion > .accordion-title > a').click(function(event) {
        event.preventDefault();
        if( !$(this).hasClass('active') ){
            $('.accordion > .accordion-title a').removeClass().addClass('ion-arrow-down-b');
            $(this).removeClass().addClass('ion-arrow-up-b active');
            allPanels.slideUp();
            $(this).parent().next().slideDown();
            $('.accordion > .accordion-title').removeClass('active');
            $(this).parent().addClass('active');
        }
        return false;
    });

})(jQuery);
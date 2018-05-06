jQuery(document).ready(function($) {
    //Isotope
    $('.fw-testimonials-list').isotope({
        itemSelector: '.fw-testimonials-item',
        percentPosition: true,
        masonry: {
            // use outer width of grid-sizer for columnWidth
            columnWidth: '.fw-testimonials-item'
        }
    })
});
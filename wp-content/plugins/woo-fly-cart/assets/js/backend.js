jQuery(document).ready(function () {
    jQuery('.woosmc_color_picker').wpColorPicker();
    woosmc_icon_show();
    jQuery('#woosmc_count_icon').on('change', function () {
        woosmc_icon_show();
    });

    // choose background image
    var woosmc_file_frame;
    jQuery('#woosmc_upload_image_button').on('click', function (event) {
        event.preventDefault();
        // If the media frame already exists, reopen it.
        if (woosmc_file_frame) {
            // Open frame
            woosmc_file_frame.open();
            return;
        } else {
        }
        // Create the media frame.
        woosmc_file_frame = wp.media.frames.woosmc_file_frame = wp.media({
            title: 'Select a image to upload',
            button: {
                text: 'Use this image',
            },
            multiple: false	// Set to true to allow multiple files to be selected
        });
        // When an image is selected, run a callback.
        woosmc_file_frame.on('select', function () {
            // We set multiple to false so only get one image from the uploader
            attachment = woosmc_file_frame.state().get('selection').first().toJSON();
            // Do something with attachment.id and/or attachment.url here
            jQuery('#woosmc_image_preview').attr('src', attachment.url).css('width', 'auto');
            jQuery('#woosmc_image_attachment_url').val(attachment.id);
        });
        // Finally, open the modal
        woosmc_file_frame.open();
    });
});

function woosmc_icon_show() {
    var woosmc_icon = jQuery('#woosmc_count_icon').find(":selected").attr('value');
    jQuery('#woosmc_count_icon_view').html('<i class="' + woosmc_icon + '"></i>');
}
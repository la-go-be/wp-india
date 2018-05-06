<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }
/**
Control metabox when change the post format when edit a post in backend
 */
add_action('admin_footer', 'fw_pf_switch');
function fw_pf_switch() {
?>
<script>
    (function($){
        function pf_metabox_change(){
            var selected = $("#post-formats-select input.post-format:checked");
            var meta_box = $('div[id^="fw-options-box-pf-"]');
            meta_box.hide("slow");
            $('div[id^="fw-options-box-pf-'+selected.val()+'"]').show("slow");
        }
        jQuery(document).ready(function($) {
            pf_metabox_change();
            $("#post-formats-select input.post-format").change(function(event) {
                pf_metabox_change();
            });
        });
    })(jQuery);
</script>
<?php
}
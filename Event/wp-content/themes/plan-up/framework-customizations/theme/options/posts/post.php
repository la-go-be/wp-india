<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$options = array(
    'sb_sub_title' => array(
        'type' => 'text',
        'value' => '',
        'label' => esc_html__('Post subtitle', 'plan-up')
    ),
    'pf-video' => array(
        'type'     => 'box',
        'title'    => esc_html__('Video', 'plan-up'),
        'priority' => 'high',
        'attr'    => array('class' => 'custom-class', 'data-foo' => 'barrr'),
        'options'  => array(
            'youtube' => array(
                'type' => 'short-text',
                'label' => esc_html__('Youtube Video', 'plan-up'),
                'desc' => esc_html__('Paste ID of the video here', 'plan-up'),
                "help" => esc_html__("Just paste the bold part of the video's URL: https://www.youtube.com/watch?v=<b style='color: yellow;'>4SYlLi5djz0</b>","plan-up")
            ),
            'vimeo' => array(
                'type' => 'short-text',
                'label' => esc_html__('or Vimeo Video', 'plan-up'),
                'desc' => esc_html__('Paste ID of the video here', 'plan-up'),
                "help" => esc_html__("Just paste the bold part of the video's URL: https://vimeo.com/channels/staffpicks/<b style='color: yellow;'>121428012</b>","plan-up")
            ),
        )
    ),
    'pf-quote' => array(
        'type'     => 'box',
        'title'    => esc_html__('Quote', 'plan-up'),
        'priority' => 'high',
        'options'  => array(
            'quote' => array(
                'type' => 'textarea',
                'label' => esc_html__('Content', 'plan-up'),
                'desc' => esc_html__('The quote content', 'plan-up'),
                "help" => esc_html__("","plan-up"),
            ),
            'author' => array(
                'type' => 'text',
                'label' => esc_html__('Speaker', 'plan-up'),
                'desc' => esc_html__('The speech owner', 'plan-up'),
                "help" => esc_html__("","plan-up"),
            ),
            'position' => array(
                'type' => 'text',
                'label' => esc_html__('Position', 'plan-up'),
            )
        )
    ),
    'pf-gallery' => array(
        'type'     => 'box',
        'title'    => esc_html__('Gallery Image', 'plan-up'),
        'priority' => 'high',
        'options'  => array(
            'gallery' => array(
                'type' => 'multi-upload',
                'label' => esc_html__('Images', 'plan-up'),
                'desc' => esc_html__('Upload the images for the galery', 'plan-up'),
                "help" => esc_html__("The images should have the same size for the best performance.","plan-up"),
            ),
        )
    ),
);
?>
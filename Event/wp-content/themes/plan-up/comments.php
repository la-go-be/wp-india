<?php
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>

	<h3 class="comments-title">
		<?php
			printf( _n( 'There is one comment on this post;', 'There are %1$s comments on this post', get_comments_number(), 'plan-up' ),
				number_format_i18n( get_comments_number() ), get_the_title() );
		?>
	</h3>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
	<nav id="comment-nav-above" class="navigation comment-navigation">
		<h1 class="screen-reader-text"><?php _e( 'Comment navigation', 'plan-up' ); ?></h1>
		<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'plan-up' ) ); ?></div>
		<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'plan-up' ) ); ?></div>
	</nav><!-- #comment-nav-above -->
	<?php endif; // Check for comment navigation. ?>

	<ol class="comment-list">
		<?php
			wp_list_comments( array(
				'style'      => 'ol',
				'short_ping' => true,
				'avatar_size' => 70,
				'callback' => 'fw_commentcb',
				'max_depth'         => 5,
			) );
		?>
	</ol><!-- .comment-list -->

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
	<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
		<div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'plan-up' ) ); ?></div>
		<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'plan-up' ) ); ?></div>
	</nav><!-- #comment-nav-below -->
	<?php endif; // Check for comment navigation. ?>

	<?php endif; // have_comments() ?>

	<?php
		$commenter = wp_get_current_commenter();
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );
		$fields =  array(
		  'author' =>
		    '<p class="c-field comment-form-author"><label for="author">' . esc_html__('Name', 'plan-up') .( $req ? '<span class="required">*</span>' : '' ) .'</label> ' .
		    '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
		    '" '.$aria_req . ' /></p>',

		  'email' =>
		    '<p class="c-field comment-form-email"><label for="email">' . esc_html__('Email', 'plan-up') .( $req ? '<span class="required">*</span>' : '' ). '</label> ' .
		    '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
		    '" '.$aria_req . ' /></p>',
		);
		comment_form(array(
			'title_reply' => apply_filters( 'ht_heading_comment_label', esc_html__('Leave your thought here', 'plan-up') ),
			'label_submit' => apply_filters( 'ht_comment_submit_btn_label', esc_html__('SUBMIT', 'plan-up') ),
			'comment_notes_after' => '<p class="comment-note">'.apply_filters( 'ht_comment_not_after', esc_html__('*Note: Your email will be kept secret and not be published', 'plan-up') ).'</p>',
			'comment_notes_before' => false,
			'fields' => apply_filters( 'comment_form_default_fields', $fields ),
		));
	?>

</div><!-- #comments -->

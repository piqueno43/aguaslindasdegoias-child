<?php

if ( ! function_exists( 'presscore_display_related_posts' ) ) :

	/**
	 * Display related posts.
	 *
	 */
function presscore_display_related_posts() {

		if ( !of_get_option( 'general-show_rel_posts', false ) ) {
			return '';
		}

		global $post;

		$html = '';
		$terms = array();

		switch ( get_post_meta( $post->ID, '_dt_post_options_related_mode', true ) ) {
			case 'custom': $terms = get_post_meta( $post->ID, '_dt_post_options_related_categories', true ); break;
			default: $terms = wp_get_object_terms( $post->ID, 'category', array('fields' => 'ids') );
		}

		if ( $terms && !is_wp_error($terms) ) {

			$attachments_data = presscore_get_related_posts( array(
				'cats'		=> $terms,
				'post_type' => 'post',
				'taxonomy'	=> 'category',
				'args'		=> array( 'posts_per_page' => intval(of_get_option('general-rel_posts_max', 12)) )
				) );

			$head_title = esc_html(of_get_option( 'general-rel_posts_head_title', 'Related posts' ));

			$posts_list = presscore_get_posts_small_list( $attachments_data );
			if ( $posts_list ) {

				foreach ( $posts_list as $p ) {
					$html .= sprintf( '<div class="wf-cell wf-1-3"><div class="borders">%s</div></div>', $p );
				}

				$html = '<section class="items-grid wf-container">' . $html . '</section>';

				// add title
				if ( $head_title ) {
					$html = '<h2 class="entry-title">' . $head_title . '</h2><div class="gap-10"></div>' . $html;
				}

				$html = '<div class="hr-thick"></div><div class="gap-30"></div>' . $html . '<div class="gap-10"></div>';
			}
		}

		echo (string) apply_filters( 'presscore_display_related_posts', $html );
}

endif; // presscore_display_related_posts
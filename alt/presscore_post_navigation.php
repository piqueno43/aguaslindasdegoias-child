<?php
if ( ! function_exists( 'presscore_post_navigation' ) ) :

	/**
	 * Next/previous post buttons helper.
	 *
	 * Works only in the loop. Sample options array:
	 * array(
	 *		'wrap'				=> '<div class="paginator-r inner-navig">%LINKS%</div>',
	 *		'title_wrap'		=> '<span class="pagin-info">%TITLE%</span>',
	 *		'no_link_next'		=> '<a href="#" class="prev no-act" onclick="return false;"></a>',
	 *		'no_link_prev'		=> '<a href="#" class="next no-act" onclick="return false;"></a>',
	 *		'title'				=> 'Post %CURRENT% of %MAX%',
	 *		'next_post_class'	=> 'prev',
	 *		'prev_post_class'	=> 'next',
	 *		 next_post_text'	=> '',
	 *		'prev_post_text'	=> '',
	 *		'echo'				=> true
	 * )
	 *
	 * @param array $args Options array.
	 * @since presscore 1.0
	 */
function presscore_post_navigation( $args = array() ) {
	global $wpdb, $post;

	if ( !in_the_loop() ) {
		return false;
	}

	$next_post_text = _x('Prev', 'post nav', LANGUAGE_ZONE);
	$prev_post_text = _x('Next', 'post nav', LANGUAGE_ZONE);

	$defaults = array(
		'wrap'			=> '<div class="navigation-inner">%LINKS%</div>',
		'title_wrap'		=> '',
		'no_link_next'		=> '<a class="prev-post disabled" href="javascript: void(0);">' . $next_post_text . '</a>',
		'no_link_prev'		=> '<a class="next-post disabled" href="javascript: void(0);">' . $prev_post_text . '</a>',
		'title'			=> '',
		'next_post_class'	=> 'prev-post',
		'prev_post_class'	=> 'next-post',
		'next_post_text'	=> $next_post_text,
		'prev_post_text'	=> $prev_post_text,
		'echo'				=> true
		);

	$args = apply_filters( 'presscore_post_navigation-args', wp_parse_args( $args, $defaults ) );
	$args = wp_parse_args( $args, $defaults );

	$title = $args['title'];

	if ( false !== strpos( $title, '%CURRENT%' ) || false !== strpos( $title, '%MAX%' ) ) {

		$posts = new WP_Query( array(
			'no_found_rows'	=> true,
			'fields'			=> 'ids',
			'posts_per_page'	=> -1,
			'category'	=> 11,
			'post_type'		=> get_post_type(),
			'post_status'		=> 'publish',
			'orderby'		=> 'date',
			'order'			=> 'DESC'
			) );

		$current = 1;
		foreach( $posts->posts as $index=>$post_id ) {
			if ( $post_id == get_the_ID() ) {
				$current = $index + 1;
				break;
			}
		}

		$title = str_replace( array( '%CURRENT%', '%MAX%' ), array( $current, count( $posts->posts ) ), $title );
	}



	$output = '';

	$output .= str_replace( array( '%TITLE%' ), array( $title ), $args['title_wrap'] );

	// next link

		$next_post_link = get_next_post_link( '%link', $args['next_post_text'] ,"category__not_in=2");

	if ( $next_post_link ) {
		$next_post_link = str_replace( 'href=', 'class="'. $args['next_post_class']. '" href=', $next_post_link );
	} else {
		$next_post_link = $args['no_link_next'];
	}

		// previos link
	$previous_post_link = get_previous_post_link( '%link', $args['prev_post_text']);
	if ( $previous_post_link ) {
		$previous_post_link = str_replace( 'href=', 'class="'. $args['prev_post_class']. '" href=', $previous_post_link );
	} else {
		$previous_post_link = $args['no_link_prev'];
	}

	$output = str_replace( array( '%LINKS%', '%NEXT_POST_LINK%', '%PREV_POST_LINK%' ), array( $next_post_link . $previous_post_link, $next_post_link, $previous_post_link ), $args['wrap'] );

	if ( $args['echo'] ) {
		echo $output;
	}

	return $output;
}

endif; // presscore_post_navigation
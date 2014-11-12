<?php

if ( ! function_exists( 'presscore_post_navigation_controller' ) ) :

	/**
	 * Post pagination controller.
	 */
function presscore_post_navigation_controller() {

	if ( !in_the_loop() ) {
		return;
	}

	$show_navigation = presscore_is_post_navigation_enabled();

		// show navigation
	if ( $show_navigation ) {
		presscore_post_navigation();
	}

}


endif;
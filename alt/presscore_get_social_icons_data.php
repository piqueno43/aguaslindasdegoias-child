<?php
if ( ! function_exists( 'presscore_get_social_icons_data' ) ) :

	/**
	 * Return social icons array( 'class', 'title' ).
	 *
	 */
	function presscore_get_social_icons_data() {
		return array(
			'facebook'		=> __('Facebook', LANGUAGE_ZONE),
			'twitter'		=> __('Twitter', LANGUAGE_ZONE),
			'google'		=> __('Google+', LANGUAGE_ZONE),			
			'you-tube'		=> __('YouTube', LANGUAGE_ZONE),
			'rss'			=> __('Rss', LANGUAGE_ZONE),			
			'mail'			=> __('Mail', LANGUAGE_ZONE),
			'website'		=> __('Website', LANGUAGE_ZONE),
			
		);
	}

endif; // presscore_get_social_icons_data
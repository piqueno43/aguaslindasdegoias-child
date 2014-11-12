<?php
if ( ! function_exists( 'presscore_get_posts_small_list' ) ) :

	/**
	 * Description here.
	 *
	 * Some sort of images list with some description and post title and date ... eah
	 *
	 * @return array Array of items or empty array.
	 */
function presscore_get_posts_small_list( $attachments_data, $options = array() ) {
	if ( empty( $attachments_data ) ) {
		return array();
	}

	global $post;
	$default_options = array(
		'links_rel'		=> '',
		'show_images'	=> true
		);
	$options = wp_parse_args( $options, $default_options );

	if(is_home() || is_front_page()):
		$image_args = array(
			'img_class' => '',
			'class'		=> 'alignleft ',
			'custom'	=> $options['links_rel'],
			'options'	=> array( 'w' => 150, 'h' => 150, 'z' => true ),
			'echo'		=> false,
			);
	else:
		$image_args = array(
			'img_class' => '',
			'class'		=> 'alignleft post-rollover',
			'custom'	=> $options['links_rel'],
			'options'	=> array( 'w' => 60, 'h' => 60, 'z' => true ),
			'echo'		=> false,
			);
	endif;

	$articles = array();
	$class = '';
	$post_was_changed = false;
	$post_backup = $post;

	foreach ( $attachments_data as $data ) {

		$new_post = null;

		if ( isset( $data['parent_id'] ) ) {

			$post_was_changed = true;
			$new_post = get_post( $data['parent_id'] );

			if ( $new_post ) {
				$post = $new_post;
				setup_postdata( $post );
			}
		}

		$permalink = esc_url($data['permalink']);

		$attachment_args = array(
			'href'		=> $permalink,
			'img_meta' 	=> array( $data['full'], $data['width'], $data['height'] ),
			'img_id'	=> empty($data['ID']) ? 0 : $data['ID'],
			'echo'		=> false,
			'wrap'		=> '<a %CLASS% %HREF% %CUSTOM%><img %IMG_CLASS% %SRC% %SIZE% %ALT% /></a>',
			);

			// show something if there is no title
		if ( empty($data['title']) ) {
			$data['title'] = _x('No title', 'blog small list', LANGUAGE_ZONE);
		}

		if ( !empty( $data['parent_id'] ) ) {
			$class = 'post-' . presscore_get_post_format_class( get_post_format( $data['parent_id'] ) );

			if ( empty($data['ID']) ) {
				$attachment_args['wrap'] = '<a %HREF% %CLASS% %TITLE%></a>';
				$attachment_args['class'] = $image_args['class'] . ' no-avatar';
				$attachment_args['img_meta'] = array('', 0, 0);
				$attachment_args['options'] = false;
			}
		}

		

		if(is_home() || is_front_page()):
			$article = sprintf(
				'<article class="%s"><div class="thumb_noticia  blog-media wf-td">%s</div><div class="post-content post-content-home bloco_noticias">%s%s</div></article>',
				$class,
				$options['show_images'] ? dt_get_thumb_img( array_merge($image_args, $attachment_args) ) : '',
				'<h4><a href="' . $permalink . '">' . esc_html($data['title']) . '</a></h4><br />',
				'<p>'.limita_caracteres(get_the_content(),240, false).'</p>'
				);
		
		else:
			$article = sprintf(
				'<article class="%s"><div class="wf-td">%s</div><div class="post-content">%s%s</div></article>',
				$class,
				$options['show_images'] ? dt_get_thumb_img( array_merge($image_args, $attachment_args) ) : '',
				'<a href="' . $permalink . '">' . esc_html($data['title']) . '</a><br />',
				'<time class="text-secondary" datetime="' . get_the_date('c') . '">' . get_the_date(get_option('date_format')) . '</time>'
				);
		endif;

		$articles[] = $article;
	}

	if ( $post_was_changed ) {
		$post = $post_backup;
		setup_postdata( $post );
	}

	return $articles;
}

endif; // presscore_get_posts_small_list
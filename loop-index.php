<?php
/**
 * @package presscore
 * @since presscore 0.1
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php do_action('presscore_before_post_content'); ?>

	<?php if ( !post_password_required() ) : ?>

		<?php
		if(!categorias_filhas('licitacoes')):
			echo mostrar_licitacoes(true);
		else:
		$post_meta = ' ';
		$share_buttons = presscore_display_share_buttons('post', array('echo' => false));
		$share_buttons = str_replace('class="entry-share', 'class="entry-share wf-td', $share_buttons);

		if ( $share_buttons || $post_meta ) {
			printf(
				'<div class="post-meta wf-table wf-mobile-collapsed">%s%s</div>',
				$post_meta ? $post_meta : '',
				$share_buttons ? $share_buttons : ''
				);
		}
		?>
		<h2><?php the_title(); ?></h2>
		<?php the_content(); ?>
	<?php endif; ?>
<?php endif; // !post_password_required ?>


<?php do_action('presscore_after_post_content'); ?>

</article><!-- #post-<?php the_ID(); ?> -->
<?php remove_filter( 'presscore_post_navigation-args', 'presscore_show_navigation_next_prev_posts_titles', 15 ); ?>

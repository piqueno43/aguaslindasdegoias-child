<?php
// load child theme textdomain
function presscore_load_text_domain() {
	load_child_theme_textdomain( 'presscore', get_stylesheet_directory() . '/languages' );
	add_image_size( 'home-thumb', 790, 360, true );
}
add_action( 'wp_enqueue_scripts', 'load_my_child_styles', 20 );
function load_my_child_styles() {
	wp_enqueue_style( 'child-theme', get_stylesheet_directory_uri().'/aguaslindas.css');
}
add_image_size( 'homepage-thumb', 980, 365, true); // (cropped)
function apenas_administrador(){
	$admins = array('Xequemate');
	$current_user = wp_get_current_user();
	if( !in_array( $current_user->user_login, $admins ) ):
		remove_action('admin_menu', 'optionsframework_add_page');
	remove_action('wp_before_admin_bar_render', 'optionsframework_adminbar');
	add_action( 'wp_before_admin_bar_render', 'remover_admin_bar',9999);
	add_action( 'admin_init', 'remove_dashboard_meta' );
	add_action( 'admin_menu', 'remove_menus',1000);
	add_action('admin_menu','wp_hide_update');
	add_action('admin_init', 'bloqueio_alt_tema',1100);
	add_filter('screen_options_show_screen', 'remover_opcoes_tela');
	add_filter( 'update_footer', 'change_footer_version', 9999 );

	endif;

}

add_action( 'init', 'apenas_administrador', 3000 );

function remove_child_setup()
{
	remove_filter('init', 'presscore_register_post_types');
	remove_filter( 'tgmpa_register', 'presscore_register_required_plugins');
	add_filter('init','new_presscore_register_post_types',100);


}
add_action('after_setup_theme', 'remove_child_setup',1000);
if(! function_exists('new_presscore_register_post_types')):
	function new_presscore_register_post_types()
{
	//Presscore_Inc_Portfolio_Post_Type::register();
}
endif;
function remove_menus()
{

	remove_menu_page('index.php');
	remove_menu_page( 'wpcf7' );
	remove_menu_page( 'admin.php?page=options-framework' );
	remove_menu_page( 'plugins.php' );
	remove_menu_page( 'tools.php');
	remove_menu_page( 'options-permalink.php');
	remove_menu_page('edit.php?post_type=acf');
	remove_menu_page('w3tc_dashboard');
	remove_menu_page('birchschedule_help');
	remove_menu_page('codepress');
	remove_submenu_page('themes.php', 'theme-editor.php' );
	remove_submenu_page('themes.php', 'customize.php');
	remove_submenu_page('admin.php', 'help');
	remove_submenu_page( 'options-general.php', 'options-writing.php' );
	remove_submenu_page( 'options-general.php', 'options-discussion.php' );
	remove_submenu_page( 'options-general.php', 'options-reading.php' );
	remove_submenu_page( 'options-general.php', 'options-discussion.php' );
	remove_submenu_page( 'options-general.php', 'options-media.php' );
	remove_submenu_page( 'options-general.php', 'options-permalink.php' );
	remove_submenu_page( 'options-general.php', 'vc_settings' );
}

function wp_hide_update() {
	remove_action('admin_notices', 'update_nag', 3);
}

function remove_dashboard_meta() {
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
}

function remover_admin_bar()
{
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wp-logo');
	$wp_admin_bar->remove_menu('about');
	$wp_admin_bar->remove_menu('wporg');
	$wp_admin_bar->remove_menu('documentation');
	$wp_admin_bar->remove_menu('edit');
	$wp_admin_bar->remove_menu('updates');
	$wp_admin_bar->remove_menu('comments');
	$wp_admin_bar->remove_menu('new-content');
	$wp_admin_bar->remove_menu('search');
	$wp_admin_bar->remove_menu('customize');
	$wp_admin_bar->remove_menu('themes');
}
function bloqueio_alt_tema()
{
	global $submenu, $userdata;
	unset($submenu['themes.php'][5]);
	unset($submenu['customize.php'][6]);
	//unset($submenu['theme-editor.php'][15]);
	return $userdata;
}

function change_footer_version()
{
	return '';
}

function remover_opcoes_tela()
{
	return false;
}

function reescrever_wp_admin_footer ()
{
	echo "Mantido por: <a href='http://xequematecomunicacao.com.br' target='_blank' title='Xequemate Comunicação'>Xequemate Comunicação</a>";
}
add_filter('admin_footer_text', 'reescrever_wp_admin_footer');

add_filter( 'contextual_help', 'remove_help_tab', 999, 3 );
function remove_help_tab($old_help, $screen_id, $screen){
	$screen->remove_help_tabs();
	return $old_help;
}

function limita_caracteres($texto, $limite, $quebra = true)
{
	$tamanho = strlen($texto);
	if ($tamanho <= $limite)
	{
		$novo_texto = $texto;
	}
	else
	{
		if ($quebra == true)
		{
			$novo_texto = trim(substr($texto, 0, $limite)).'...';
		}
		else
		{
			$ultimo_espaco = strrpos(substr($texto, 0, $limite), ' ');
			$novo_texto = trim(substr($texto, 0, $ultimo_espaco)).'...';
		}
	}
	return $novo_texto;
}
// desativa sistema de comentários
function _comments_close( $open, $post_id ) {
	return false;
}
add_filter( 'comments_open', '_comments_close', 10, 2 );

// esconde comentários anteriores
function _empty_comments_array( $open, $post_id ) {
	return array();
}
add_filter( 'comments_array', '_empty_comments_array', 10, 2 );

// remove opção no menu de administrador em /wp-admin/
function _remove_admin_menus() {
	remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_menu', '_remove_admin_menus' );

// remove opção da barra de administração
function _admin_bar_render() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('comments');
}
add_action( 'wp_before_admin_bar_render', '_admin_bar_render' );

foreach (glob(__DIR__ . '/alt/*.php') as $arquivos_incluidos) {

  // Exclude files whose names contain -sample
	if (!strpos($arquivos_incluidos, '-sample') ) {
		include_once $arquivos_incluidos;
	}

}

add_action('print_media_templates', function(){

  // define your backbone template;
  // the "tmpl-" prefix is required,
  // and your input field should have a data-setting attribute
  // matching the shortcode name
	?>
	<script type="text/html" id="tmpl-custom-gallery-setting-x">
		<label class="setting">
			<span> <?php _e('Modo da Galeria'); ?> </span>
			<select data-setting="mode">
				<option value=""> Nenhum </option>
				<option value="metro"> Metro </option>
				<option value="slideshow"> Slideshow </option>
			</select>
		</label>
	</script>

	<script>

		jQuery(document).ready(function(){

      // add your shortcode attribute and its default value to the
      // gallery settings list; $.extend should work as well...
      _.extend(wp.media.gallery.defaults, {
      	mode: ''
      });

      // merge default gallery settings template with yours
      wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
      	template: function(view){
      		return wp.media.template('gallery-settings')(view)
      		+ wp.media.template('custom-gallery-setting-x')(view);
      	}
      });

  });

</script>
<?php

});


function categorias_filhas($categorias){

	$categorias = array();
	$categoria = array();

	foreach((get_the_category()) as $childcat)
	{
		if (cat_is_ancestor_of(array($categorias), $childcat))
		{
			return $childcat->cat_ID;
		}
	}
	if(in_category( array($childcat->cat_ID) ))
	{
		return $categoria;
	}
}

function filter_exclude_category( $filters ) {
	$filters[] = array( 'category__not_in' =>
		array( 'term' => array( 'category.slug' => 'dogs' ) )
		);
	return $filters;
}
add_filter( 'presscore_post_navigation', 'filter_exclude_category' );

function mostrar_licitacoes($title = true, $excerpt = true){
	$status = get_field('status');
	$numero = get_field('numero');
	$data = get_field('data');
	$arquivos = get_field('arquivos');

	switch ($status) {
		case 'Em Andamento':
		$status = $status.' <i class="fa fa-exclamation-triangle fa-lg"></i>';
		break;
		case 'Em Aberto':
		$status = $status.' <i class="fa fa-folder-open-o fa-lg"></i>';
		break;
		case 'Finalizado':
		$status = $status.' <i class="fa fa-folder-o fa-lg"></i>';
		break;

		default:
			# code...
		break;
	}

	$html =  '<div class="wpb_wrapper">';
	$html .= '<ul class="image-arrow">';
	if($title){
		$html .=  '<li>';
		$html .=  '<div class="wf-table">';
		$html .=  '<h2 class="entry-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h2>';
		$html .=  '<div class="gap-30"></div>';
		$html .=  '</div>';
		$html .=  '</li>';
	}


	if($status || $numero || $data || $arquivos ):
		if(!empty($status))
		{
			$html .=  '<li>';
			$html .=  '<div class="wf-table">';
			$html .=  ' <div class="wpb_alert-error"><i class="fa fa-info  fa-lg"></i> <strong>Status:  </strong> ' .$status .'</div>';
			$html .=  '</div>';
			$html .=  '</li>';
		}
		if(!empty($numero))
		{
			$html .=  '<li>';
			$html .=  '<div class="wf-table">';
			$html .=  ' <div class="wpb_alert-info"><i class="fa fa-sort-numeric-asc fa-lg"></i> <strong>Número: </strong> ' .$numero .'</div>';
			$html .=  '</div>';
			$html .=  '</li>';
		}
		if(!empty($data))
		{
			$html .=  '<li>';
			$html .=  '<div class="wf-table">';
			$html .=  '<div class="wpb_alert-success"><i class="fa fa-clock-o  fa-lg"></i> <strong>Data: </strong>' . $data. '</div>';
			$html .=  '</div>';
			$html .=  '</li>';
		}
		if($excerpt){
			if(!empty($arquivos))
			{
				$html .=  '<li>';
				$html .=  '<div>';
				$html .=  '<div class="wpb_alert"><i class="fa fa-download  fa-lg"></i> <strong>Arquivo(s): </strong> </div><div class="arquivos_donwload">' .$arquivos.' </div>' ;
				$html .=  '</div>';
				$html .=  '</li>';
			}
		}else{
			$html .=  '<li>';
			$html .=  '<div class="wf-table">';
			$html .= '<a href="'.get_permalink().'" class="details more-link" target="_self">'. _x( 'Details', 'details button', LANGUAGE_ZONE ).' </a>';
			$html .=  '</div>';
			$html .=  '</li>';
		}
		$html .= '</ul>	';
		$html .= '</div>	';
		else:
			$html =  "Nada Encontrado";
		endif;

		return $html;

	}
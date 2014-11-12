<?php
if ( ! function_exists('licitacoes_post_type') ) {

// Register Custom Post Type
	function licitacoes_post_type() {

		$labels = array(
			'name'                => _x( 'Licitações', 'Post Type General Name', 'LANGUAGE_ZONE' ),
			'singular_name'       => _x( 'Licitação', 'Post Type Singular Name', 'LANGUAGE_ZONE' ),
			'menu_name'           => __( 'Licitações', 'LANGUAGE_ZONE' ),
			'parent_item_colon'   => __( 'Parente', 'LANGUAGE_ZONE' ),
			'all_items'           => __( 'Todas', 'LANGUAGE_ZONE' ),
			'view_item'           => __( 'Ver', 'LANGUAGE_ZONE' ),
			'add_new_item'        => __( 'Adicionar', 'LANGUAGE_ZONE' ),
			'add_new'             => __( 'Nova', 'LANGUAGE_ZONE' ),
			'edit_item'           => __( 'Editar', 'LANGUAGE_ZONE' ),
			'update_item'         => __( 'Atualizar', 'LANGUAGE_ZONE' ),
			'search_items'        => __( 'Buscar', 'LANGUAGE_ZONE' ),
			'not_found'           => __( 'Nada Encontrado', 'LANGUAGE_ZONE' ),
			'not_found_in_trash'  => __( 'Nada Encontrado na Lixeira', 'LANGUAGE_ZONE' ),
			);
		$args = array(
			'label'               => __( 'licitacoes', 'LANGUAGE_ZONE' ),
			'description'         => __( 'Post Type Description', 'LANGUAGE_ZONE' ),
			'labels'              => $labels,
			'supports'            => array( 'title', ),
			'taxonomies'          => array( 'lic_category' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'rewrite'             => false,
			'capability_type'     => 'page',
			);
		register_post_type( 'licitacoes', $args );

	}

// Hook into the 'init' action
	add_action( 'init', 'licitacoes_post_type', 0 );

}
if ( ! function_exists( 'lic_taxonomie' ) ) {

// Register Custom Taxonomy
function lic_taxonomie() {

	$labels = array(
		'name'                       => _x( 'Categorias', 'Taxonomy General Name', 'LANGUAGE_ZONE' ),
		'singular_name'              => _x( 'Categoria', 'Taxonomy Singular Name', 'LANGUAGE_ZONE' ),
		'menu_name'                  => __( 'Categoria', 'LANGUAGE_ZONE' ),
		'all_items'                  => __( 'Todas', 'LANGUAGE_ZONE' ),
		'parent_item'                => __( 'Parente', 'LANGUAGE_ZONE' ),
		'parent_item_colon'          => __( 'Patente Item:', 'LANGUAGE_ZONE' ),
		'new_item_name'              => __( 'Nova', 'LANGUAGE_ZONE' ),
		'add_new_item'               => __( 'Adicionar', 'LANGUAGE_ZONE' ),
		'edit_item'                  => __( 'Editar', 'LANGUAGE_ZONE' ),
		'update_item'                => __( 'Atualizar', 'LANGUAGE_ZONE' ),
		'separate_items_with_commas' => __( 'Separar por Virgula', 'LANGUAGE_ZONE' ),
		'search_items'               => __( 'Buscar', 'LANGUAGE_ZONE' ),
		'add_or_remove_items'        => __( 'Adicionar ou Remover', 'LANGUAGE_ZONE' ),
		'choose_from_most_used'      => __( 'Escolha as Categorias', 'LANGUAGE_ZONE' ),
		'not_found'                  => __( 'Nada Encontrado', 'LANGUAGE_ZONE' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'lic_category', array( 'licitacoes' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'lic_taxonomie', 0 );

}
<?php


/**
 * Função que registra o post_type Contato
 */
function registra_contatos() {

	$labels = array(
			'name' => __('Contatos'),
			'singular_name' => __('Contato'),
			'add_new' => __('Adicionar novo Contato'),
			'add_new_item' => __('Adicionar novo Contato'),
			'edit_item' => __('Editar Contato'),
			'new_item' => __('Novo Contato'),
			'view_item' => __('Ver Contato'),
			'search_items' => __('Buscar Contatos'),
			'not_found' =>  __('Nenhum Contato encontrado'),
			'not_found_in_trash' => __('Nada encontrado na Lixeira'),
			'parent_item_colon' => ''
	);

	$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position'=>9,
			'supports'=>array('title', 'editor'),
			'register_meta_box_cb'=> 'boxs_contato',

	);


	register_post_type( 'contatos' , $args );

}

function boxs_contato(){

	add_meta_box("arquivos_contato", "Arquivos", "arquivos_contato", "contatos", "normal", "low");

}

function arquivos_contato(){
	$arquivos = get_post_custom($post->ID);
	echo $arquivos['arquivos'][0];
	
}

add_action('init', 'registra_contatos');
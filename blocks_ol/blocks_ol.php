<?php
/*
Plugin Name: blocks_ol
Description: Краткое описание плагина.
Version: 1.0
Author: Olha Tkachiv
*/
add_action( 'init', 'true_register_products' ); // Использовать функцию только внутри хука init

function true_register_products() {
	$labels = array(
		'name' => 'Blocks',
		'singular_name' => 'Block',
		'add_new' => 'Create',
		'add_new_item' => 'Create block',
		'edit_item' => 'edit block',
		'new_item' => 'New block',
		'all_items' => 'List blocks',
		'view_item' => 'View blocks on the site',
		'search_items' => 'Search blocks',
		'not_found' =>  'Blocks not found.',
		'not_found_in_trash' => 'There are no blocks in the basket.',
		'menu_name' => 'Blocks'
	);
	$args = array(
		'labels' => $labels,
		'public' => true, // false не дає доступ до цієї сторінки, тобто вона закрита стає
//publicly_queryable, capability_type, capabilities
    'menu_icon' => 'dashicons-align-wide',
		'menu_position' => 5,
    'hierarchical' => true,
    //'has_archive' => true,
		'supports' => array( 'title', 'editor') //custom-fields, 'thumbnail'
	);
	register_post_type('product',$args);
}
?>

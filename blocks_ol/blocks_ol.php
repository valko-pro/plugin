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
		'public' => false,
    'show_ui' => true,
    'show_ui_naw_menus' => true,
//publicly_queryable, capability_type, capabilities
    'menu_icon' => 'dashicons-align-wide',
		'menu_position' => 5,
    'hierarchical' => true,
    //'has_archive' => true,
		'supports' => array( 'title', 'editor') //custom-fields, 'thumbnail'
	);
	register_post_type( 'blocks_ol',$args);
}

//підключаємо функцію активації мета блоку
add_action('add_meta_boxes', 'my_extra_fields', 1);

function my_extra_fields() {
	add_meta_box( 'extra_fields', 'Status', 'extra_fields_box_func', 'blocks_ol', 'normal', 'high'  );
}

// код блоку
function extra_fields_box_func( $post ){
?>


	<p> <?php $mark_v = get_post_meta($post->ID, 'block_status', 1); ?>
		<label><input type="radio" name="extra[block_status]" value="1" <?php checked( $mark_v, '1' ); ?> />on  </label>
		<label><input type="radio" name="extra[block_status]" value="2" <?php checked( $mark_v, '2' ); ?> />off  </label>
	</p>
	<input type="hidden" name="extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
<?php
//на 1 все окей, а на нулю пропадає взагалі з бд
}

// включаем обновление полей при сохранении
add_action('save_post', 'my_extra_fields_update', 0);

/* Сохраняем данные, при сохранении поста */
function my_extra_fields_update( $post_id ){
	// базовая проверка
	if (
		   empty( $_POST['extra'] )
		|| ! wp_verify_nonce( $_POST['extra_fields_nonce'], __FILE__ )
		|| wp_is_post_autosave( $post_id )
		|| wp_is_post_revision( $post_id )
	)
		return false;

	// Все ОК! Теперь, нужно сохранить/удалить данные
	$_POST['extra'] = array_map( 'sanitize_text_field', $_POST['extra'] );
	foreach( $_POST['extra'] as $key => $value ){
		if( empty($value) ){
			delete_post_meta( $post_id, $key ); // удаляем поле если значение пустое
			continue;
		}

		update_post_meta( $post_id, $key, $value ); // add_post_meta() работает автоматически
	}

	return $post_id;
}

?>

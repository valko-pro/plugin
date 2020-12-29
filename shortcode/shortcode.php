<?php
/*
Plugin Name: shortcode
Description: Краткое описание плагина.
Version: 1.0
Author: Olha Tkachiv

Copyright 2020 OLHA_TKACHIV (email: olyatkachiv@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//вивід пункта основного меню
function shortcode_register_custom_menu_page() {
    add_menu_page(
        'Custom Menu Title',
        'Blocks',
        //'capability', //недоступна
        'manage_options',
        'blocks-options',
        'shortcode_show_blocks',
        'dashicons-align-wide',
        21
    );
    add_submenu_page(
      'blocks-options',
      'My Custom Page',
      'List blocks',
      'manage_options',
      'list-blocks',
      'shortcode_show_list'
    );
    add_submenu_page(
      'blocks-options',
      'My Custom Page',
      'Create',
      'manage_options',
      'create-block',
      'shortcode_show_create'
    );
}
add_action( 'admin_menu', 'shortcode_register_custom_menu_page' );

//функція сторінки блоків, закрита яка
function shortcode_show_blocks(){
  echo 'Hello';
}

//тіло сторінки списку існуючих блоків
function shortcode_show_list(){
  require_once 'list-blocks.php';
}

//тіло сторінки створення блоків
function shortcode_show_create(){
  require_once 'create-block.php';
}

//реєстрація скриптів
function shortcode_register_assets()
{
  wp_register_style('shortcode_styles',plugins_url('assets/css/list.css', __FILE__));
  wp_register_script('shortcode_scripts',plugins_url('assets/js/list.js', __FILE__));
}
add_action('admin_enqueue_scripts','shortcode_register_assets');

//підключення сприптів та стилів
function shortcode_load_assets($hook){
  if($hook != 'toplevel_page_blocks-options'){
    return;
  }
  wp_enqueue_style('shortcode_styles');
  wp_enqueue_script('shortcode_scripts');
}
add_action('admin_enqueue_scripts','shortcode_load_assets');
?>

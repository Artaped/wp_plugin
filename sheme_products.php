<?php
/*
Plugin Name: Sheme_products
Description: Надо написать плагин для WordPress, с помощью которого можно будет реализовывать схему Product (см. ссылки по теме) для страниц и постов WordPress.
Version:  1.0
Author: Dmitro Troitskyy
*/

//подключение  js
function dima_load_scripts_admin() {

    wp_enqueue_script('meta-box-image');
    wp_enqueue_media();

}
add_action( 'admin_enqueue_scripts', 'dima_load_scripts_admin' );

//Получаем данные страницы
$meta_value = get_post_meta( get_the_ID());

// Создаем виджет
require_once( plugin_dir_path( __FILE__ ) . 'dima-sheme-widget.php' );


/**
 * Adds a meta box to the post editing screen
 */
//Создаем метабокс

add_action('add_meta_boxes', 'myplugin_add_custom_box');
require_once( plugin_dir_path( __FILE__ ) . 'dima-sheme-metabox.php' );

/**
 * Loads the image management javascript
 */
//JS для загрузки картинки
function prfx_image_enqueue() {
    global $typenow;
    if( $typenow == 'post' or $typenow == 'page' ) {
        wp_enqueue_media();

        // Registers and enqueues the required javascript.
        wp_register_script( 'meta-box-image', plugin_dir_url( __FILE__ ) . 'meta-box-image.js', array( 'jquery' ) );
        wp_localize_script( 'meta-box-image', 'meta_image',
            array(
                'title' => __( 'Изменить или загрузить файл', 'prfx-textdomain' ),
                'button' => __( 'Загрузить картинку', 'prfx-textdomain' ),
            )
        );
        wp_enqueue_script( 'meta-box-image' );
    }
}
add_action( 'admin_enqueue_scripts', 'prfx_image_enqueue' );
//-----------------шорт код --------------------------------------//
/**
 * @return string
 */
//Создание шорткода
require_once( plugin_dir_path( __FILE__ ) . 'dima-sheme-shortcode.php' );

?>
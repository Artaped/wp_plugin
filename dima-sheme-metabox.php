<?php
add_action('add_meta_boxes', 'myplugin_add_custom_box');
function myplugin_add_custom_box(){
    $screens = array( 'post', 'page' );
    add_meta_box( 'myplugin_sectionid', 'Тестовое для Back-End разработчика', 'prfx_meta_callback', $screens ,'side');
}

/**
 * Outputs the content of the meta box
 */
function prfx_meta_callback( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'prfx_nonce' );
    $prfx_stored_meta = get_post_meta( $post->ID );
    ?>

    <p>
        <label for="meta-name" class="prfx-row-title"><?php _e( 'Название Товара', 'prfx-textdomain' )?></label>
        <input type="text" name="meta-name" id="meta-name" value="<?php if ( isset ( $prfx_stored_meta['meta-name'] ) ) echo $prfx_stored_meta['meta-name'][0]; ?>" />
    </p>
    <p>
        <label for="meta-description" class="prfx-row-title"><?php _e( 'Описание Товара', 'prfx-textdomain' )?></label>
        <input type="text" name="meta-description" id="meta-description" value="<?php if ( isset ( $prfx_stored_meta['meta-description'] ) ) echo $prfx_stored_meta['meta-description'][0]; ?>" />
    </p>
    <p>
        <label for="meta-image" class="prfx-row-title"><?php _e( 'Изображение', 'prfx-textdomain' )?></label>
        <input type="text" name="meta-image" id="meta-image" value="<?php if ( isset ( $prfx_stored_meta['meta-image'] ) ) echo $prfx_stored_meta['meta-image'][0]; ?>" />
        <img src="<?php echo isset ( $prfx_stored_meta['meta-image'] )?  $prfx_stored_meta['meta-image'][0] : ''; ?>" />
        <input type="button" id="meta-image-button" class="button" value="<?php _e( 'Загрузить картинку', 'prfx-textdomain' )?>" />
    </p>
    <p>
        <label for="meta-price" class="prfx-row-title"><?php _e( 'Стоимость Товара', 'prfx-textdomain' )?></label>
        <input type="text" name="meta-price" id="meta-price" value="<?php if ( isset ( $prfx_stored_meta['meta-price'] ) ) echo $prfx_stored_meta['meta-price'][0]; ?>" />
    </p>
    <p>
        <label for="meta-priceCurrency" class="prfx-row-title"><?php _e( 'Используемая Валюта', 'prfx-textdomain' )?></label>
        <input type="text" name="meta-priceCurrency" id="meta-priceCurrency" value="<?php if ( isset ( $prfx_stored_meta['meta-priceCurrency'] ) ) echo $prfx_stored_meta['meta-priceCurrency'][0]; ?>" />
    </p>
    <?php

}
/**
 * Saves the custom meta input
 */
function prfx_meta_save( $post_id ) {

    // Checks save status
    $is_autosave = wp_is_post_autosave( $post_id );
    $is_revision = wp_is_post_revision( $post_id );
    $is_valid_nonce = ( isset( $_POST[ 'prfx_nonce' ] ) && wp_verify_nonce( $_POST[ 'prfx_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

    // Exits script depending on save status
    if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
        return;
    }
    if( isset( $_POST[ 'meta-image' ] ) ) {
        update_post_meta( $post_id, 'meta-image', $_POST[ 'meta-image' ] );
    }

    // Checks for input and sanitizes/saves if needed
    if( isset( $_POST[ 'meta-name' ] ) ) {
        update_post_meta( $post_id, 'meta-name', sanitize_text_field( $_POST[ 'meta-name' ] ) );
    }
    if( isset( $_POST[ 'meta-description' ] ) ) {
        update_post_meta( $post_id, 'meta-description', sanitize_text_field( $_POST[ 'meta-description' ] ) );
    }
    if( isset( $_POST[ 'meta-price' ] ) ) {
        update_post_meta( $post_id, 'meta-price', sanitize_text_field( $_POST[ 'meta-price' ] ) );
    }
    if( isset( $_POST[ 'meta-priceCurrency' ] ) ) {
        update_post_meta( $post_id, 'meta-priceCurrency', sanitize_text_field( $_POST[ 'meta-priceCurrency' ] ) );
    }

}
add_action( 'save_post', 'prfx_meta_save' );
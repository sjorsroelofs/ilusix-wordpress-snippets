<?php

$myMetaBoxActionId   = 'ilusix_my_custom_meta_box';
$myMetaBoxNonceId    = 'ilusix_my_custom_meta_box_nonce';
$myMetaBoxValueId    = '_ilusix_my_custom_meta_box_value';


/**
 * Create a custom meta box
 */
function ilusix_my_custom_meta_box() {
    add_meta_box(
        'my_custom_meta_box_identifier',
        'Meta box title',
        'ilusix_my_custom_meta_box_callback',
        'post',
        'normal',
        'default'
    );
}
add_action( 'admin_init', 'ilusix_my_custom_meta_box' );


/**
 * Add custom scripts to the admin
 */
function ilusix_my_custom_meta_box_add_scripts() {
    if(get_post_type() === 'page_frame') {
        wp_register_style( 'my_meta_box_css', get_template_directory_uri() . '/assets/css/meta-box-style.css', false, '1.0.0' );
        wp_enqueue_style( 'my_meta_box_css' );

        wp_enqueue_script( 'my_meta_box_script', get_template_directory_uri() . '/assets/js/my-meta-box-script.js', array( 'jquery' ) );
    }
}
add_action( 'admin_enqueue_scripts', 'ilusix_my_custom_meta_box_add_scripts' );


/**
 * Callback after creating the meta box
 */
function ilusix_my_custom_meta_box_callback( $post ) {
    global $myMetaBoxActionId;
    global $myMetaBoxNonceId;

    // Set a nonce
    wp_nonce_field( $myMetaBoxActionId, $myMetaBoxNonceId );

    $metaBoxContent = ilusix_get_my_meta_box_content( $post->ID );

    // Output
    include_once('my_meta_box_html.php');
}


/**
 * Get the meta box content
 */
function ilusix_get_my_meta_box_content( $postId ) {
    global $myMetaBoxValueId;

    $result              = array();
    $frameFieldContent   = unserialize( get_post_meta( $postId, $myMetaBoxValueId, true ) );
    $result['value-1']   = isset( $frameFieldContent['value-1'] ) ? $frameFieldContent['value-1'] : '';
    $result['value-2']   = isset( $frameFieldContent['value-2'] ) ? $frameFieldContent['value-2'] : '';

    return $result;
}


/**
 * Save the data
 */
function ilusix_my_custom_meta_box_save( $postId ) {
    global $myMetaBoxNonceId;
    global $myMetaBoxActionId;
    global $myMetaBoxValueId;

    // Check if there is a nonce and if it is valid
    if( !isset( $_POST[$myMetaBoxNonceId] ) ) return;
    if( !wp_verify_nonce( $_POST[$myMetaBoxNonceId], $myMetaBoxActionId ) ) return;

    // Do nothing on autosave
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

    // Check if the user is allowed to edit
    if( isset( $_POST['post_type'] ) && $_POST['post_type'] == 'post' ) {
        if( !current_user_can( 'edit_page', $postId ) ) return;
    }

    $newData['value-1'] = sanitize_text_field( $_POST['value-1'] );
    $newData['value-2'] = sanitize_text_field( $_POST['value-2'] );

    // Update the meta field in the database
    update_post_meta( $postId, $myMetaBoxValueId, serialize( $newData ) );
}
add_action( 'save_post', 'ilusix_my_custom_meta_box_save' );
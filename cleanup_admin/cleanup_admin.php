<?php

/**
 * Add the code below to your themes function.php file
 */


// Remove unused dashboard widgets
function ilusix_remove_dashboard_widgets() {
    remove_action( 'welcome_panel', 'wp_welcome_panel' );
    remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
    remove_meta_box( 'authordiv', 'page', 'None' );
    remove_meta_box( 'slugdiv', 'page', 'None' );
    remove_meta_box( 'commentsdiv', 'page', 'None' );
    remove_meta_box( 'commentstatusdiv', 'page', 'None' );
    remove_meta_box( 'revisionsdiv', 'page', 'None' );
    remove_meta_box( 'pageparentdiv', 'page', 'None' );
    remove_meta_box( 'postcustom', 'page', 'None' );
}
add_action( 'admin_init', 'ilusix_remove_dashboard_widgets' );


// Remove unused menu items
function ilusix_remove_backend_menu_items() {
    remove_menu_page( 'edit.php' );
    remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_menu', 'ilusix_remove_backend_menu_items' );


// Remove unused columns from the page post type
function ilusix_remove_page_columns( $columns ) {
    unset($columns['author']);
    unset($columns['comments']);
    unset($columns['date']);

    return $columns;
}
add_filter('manage_pages_columns', 'ilusix_remove_page_columns');


// Remove unused columns from the MY_CUSTOM post type
function ilusix_remove_MY_CUSTOM_columns( $columns ) {
    unset($columns['date']);

    return $columns;
}
add_filter('manage_MY_CUSTOM_posts_columns', 'ilusix_remove_MY_CUSTOM_columns');
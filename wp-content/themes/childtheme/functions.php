<?php

/* Custom Post Type Start */

function create_posttype() {

    register_post_type( 'location',
    array(
    'labels' => array(
    'name' => __( 'locations' ),
    'singular_name' => __( 'locations' )
    ),  
    'public' => true,
    'has_archive' => false,
    'rewrite' => array('slug' => 'locations'),
    ));
}
add_action( 'init', 'create_posttype' );


function create_location_taxonomy() {
    $labels = array(
        'name'              => _x('Location Categories', 'taxonomy general name'),
        'singular_name'     => _x('Location Category', 'taxonomy singular name'),
        'search_items'      => __('Search Location Categories'),
        'all_items'         => __('All Location Categories'),
        'parent_item'       => __('Parent Location Category'),
        'parent_item_colon' => __('Parent Location Category:'),
        'edit_item'         => __('Edit Location Category'),
        'update_item'       => __('Update Location Category'),
        'add_new_item'      => __('Add New Location Category'),
        'new_item_name'     => __('New Location Category Name'),
        'menu_name'         => __('Location Categories'),
    );

    $args = array(
        'hierarchical'      => true, 
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'location-category'),
    );

    register_taxonomy('location_category', array('location'), $args);
}
add_action('init', 'create_location_taxonomy');



function childtheme_enqueue_styles() {
    wp_enqueue_style('custom-map-style', get_stylesheet_directory_uri() . '/map.css');
}
add_action('wp_enqueue_scripts', 'childtheme_enqueue_styles');

function enqueue_custom_scripts() {
    wp_enqueue_script('custom-map-script', get_stylesheet_directory_uri() . '/map-script.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');


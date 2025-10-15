<?php
add_action('after_setup_theme', 'setup_theme');

function setup_theme()
{
    add_theme_support('post-thumbnails');
    add_post_type_support('page', 'excerpt');

    register_nav_menus(array(
        'principal' => __('Menu principal', 'general'),
        'topbar-menu' => __('Menu Topbar', 'churchill'),
        'footer_1' => __('Footer 1', 'general'),
        'footer_2' => __('Footer 2', 'general'),
        'footer_3' => __('Footer 3', 'general'),
        'copyright' => __('copyright', 'general'),
    ));

    add_image_size('rectangle_650_366', 650, 366, true);
    add_image_size('rectangle_398_224', 398, 224, true);
    add_image_size('rectangle_536_317', 536, 317, true);

}

add_action('init', function(){
    register_taxonomy('post_tag', []);
});
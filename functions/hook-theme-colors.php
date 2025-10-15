<?php
add_theme_support('editor-color-palette', array(
    array(
        'name'  => 'Noir',
        'slug'  => 'theme-black',
        'color' => '#1f1f1e',
        'font' => '#ffffff'
    ),
    array(
        'name'  => 'Gris',
        'slug'  => 'theme-grey',
        'color' => '#3c3c3b',
        'font' => '#ffffff'
    ),
    array(
        'name'  => 'Blanc',
        'slug'  => 'theme-white',
        'color' => '#ffffff',
        'font' => '#1F1F1E'
    ),
));

function set_tiny_mce_colors($init){

    $custom_colors = '
          "1f1f1e", "Noir",
          "3c3c3b", "Gris",
          "d6b54c", "Jaune",
      ';
    $init['textcolor_map'] = '[' . $custom_colors . ']';

    $init['textcolor_rows'] = 1;

    return $init;
}
add_filter('tiny_mce_before_init', 'set_tiny_mce_colors');
<?php
add_action('wp_enqueue_scripts', 'adding_js');

function adding_js(){
    wp_register_script('theme-js', get_template_directory_uri() . "/assets/js/theme.min.js", array('jquery'), '1.1', true);
    wp_enqueue_script('theme-js');
}

add_action( 'admin_enqueue_scripts', 'adding_backend_js' );

function adding_backend_js() {
    $php_vars = array();
    wp_enqueue_script( 'backoffice', get_template_directory_uri() . "/assets/js/backoffice.min.js", array(), '1.0' );

    if($tables = get_posts(array("post_type"=>"tableau","posts_per_page"=>-1))){
        $tables_ids =array();
        foreach ($tables as $table){
            $tables_ids[]=array("text"=>$table->post_title,"value"=>$table->ID);
        }
    }
    $php_vars['tables'] = $tables_ids;

    if($icons = json_decode(file_get_contents(STYLESHEETPATH.'/functions/json/bootstap-icons-list.json'))){
        $icons_array =array();
        foreach ($icons as $icon){
            $icons_array[]=array("text"=>$icon,"value"=>$icon);
        }
    }

    $php_vars['icons'] = $icons_array;

    if($materiaux = get_posts(array("post_type"=>"materiaux","posts_per_page"=>-1))){
        $materiaux_ids =array();
        foreach ($materiaux as $materiau){
            $materiaux_ids[]=array("text"=>$materiau->post_title,"value"=>$materiau->ID);
        }
    }
    $php_vars['materiaux'] = $materiaux_ids;
    wp_localize_script( 'backoffice', 'php_vars', $php_vars );
}

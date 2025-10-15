<?php
add_action('wp_enqueue_scripts', 'adding_front_end_css');

function adding_front_end_css()
{
    wp_register_style('theme', get_template_directory_uri() . "/assets/css/theme.min.css");
    wp_enqueue_style('theme');
}

add_action( 'admin_enqueue_scripts', 'adding_backend_css' );

function adding_backend_css() {
    wp_register_style( 'builder', get_template_directory_uri() . '/assets/css/bo-render.css' );
    wp_enqueue_style( 'builder' );
}

add_action( 'admin_head', 'custom_admin_css' );

function custom_admin_css(){
    echo "<style type='text/css'>.splide{visibility: visible !important;}</style>";
    /*
    global $pagenow;
    if($colors = get_theme_support("editor-color-palette")){
        $colors_array = array();
        foreach ($colors[0] as $color){

            $colors_array[$color["color"]]=$color["font"];
        }
    }


     if ('post.php' === $pagenow && isset($_GET['post']) && 'page' === get_post_type( $_GET['post'] ) ){
        if(!get_page_template_slug($_GET['post'])){
            if($sections_object = get_field_object("sections",2)){
                if($sections = $sections_object["value"]){

                    echo "<style type='text/css'>";
                    $i=0;
                    foreach ($sections as $section){
                        echo '.acf-row[data-id="row-'.$i.'"] .acfe-flexible-placeholder,.acf-row[data-id="row-'.$i.'"] .acfe-flexible-placeholder{background-color:'.$section["couleur_de_fond"].';}';
                        echo '.acf-row[data-id="row-'.$i.'"] .acfe-flexible-placeholder *,.acf-row[data-id="row-'.$i.'"] .acfe-flexible-placeholder *{ color:'.$colors_array[$section["couleur_de_fond"]].'}';
                        echo '.acf-row[data-id="row-'.$i.'"] .acfe-flexible-placeholder a,.acf-row[data-id="row-'.$i.'"] .acfe-flexible-placeholder a.btn{ color:#000}';
                        if($colones = $section["colones"]){
                            $c = 0;
                            foreach ($colones as $colone){
                                echo '.acf-row[data-id="row-'.$i.'"] .acfe-flexible-placeholder,.acf-row[data-id="row-'.$i.'"] .layout[data-id="row-'.$c.'"]  .acfe-flexible-placeholder{background-color:'.$colone["couleur_de_fond"].';}';
                                echo '.acf-row[data-id="row-'.$i.'"] .acfe-flexible-placeholder *,.acf-row[data-id="row-'.$i.'"] .layout[data-id="row-'.$c.'"]  .acfe-flexible-placeholder *{color:'.$colors_array[$colone["couleur_de_fond"]].'}';
                                echo '.acf-row[data-id="row-'.$i.'"] .acfe-flexible-placeholder a.btn,.acf-row[data-id="row-'.$i.'"] .layout[data-id="row-'.$c.'"]  .acfe-flexible-placeholder a.btn{color:#000}';
                                $c++;
                            }
                        }
                        $i++;
                    }
                    echo "</style>";
                }
            }

        }
    } */
}
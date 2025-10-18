<?php
/**
 * Custom Post Type : Missions
 *
 * @package churchill
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

add_action('init', 'register_cpt_mission');

function register_cpt_mission() {
    
    $labels = array(
        'name'                  => 'Missions',
        'singular_name'         => 'Mission',
        'menu_name'             => 'Missions',
        'name_admin_bar'        => 'Mission',
        'add_new'               => 'Ajouter',
        'add_new_item'          => 'Ajouter une mission',
        'new_item'              => 'Nouvelle mission',
        'edit_item'             => 'Modifier la mission',
        'view_item'             => 'Voir la mission',
        'all_items'             => 'Toutes les missions',
        'search_items'          => 'Rechercher',
        'parent_item_colon'     => 'Mission parente:',
        'not_found'             => 'Aucune mission trouvée',
        'not_found_in_trash'    => 'Aucune mission dans la corbeille',
    );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'query_var'             => true,
        'rewrite'               => array('slug' => 'missions'),
        'capability_type'       => 'post',
        'has_archive'           => true,
        'hierarchical'          => false,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-clipboard',
        'supports'              => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'show_in_rest'          => true,
    );

    register_post_type('mission', $args);
    
    // Taxonomie : Catégorie Mission
    register_taxonomy(
        'categorie_mission',
        'mission',
        array(
            'label'                 => 'Catégories Mission',
            'labels'                => array(
                'name'              => 'Catégories',
                'singular_name'     => 'Catégorie',
                'search_items'      => 'Rechercher',
                'all_items'         => 'Toutes les catégories',
                'parent_item'       => 'Catégorie parente',
                'parent_item_colon' => 'Catégorie parente:',
                'edit_item'         => 'Modifier',
                'update_item'       => 'Mettre à jour',
                'add_new_item'      => 'Ajouter une catégorie',
                'new_item_name'     => 'Nouvelle catégorie',
                'menu_name'         => 'Catégories',
            ),
            'rewrite'               => array('slug' => 'categorie-mission'),
            'hierarchical'          => true,
            'show_ui'               => true,
            'show_admin_column'     => true,
            'query_var'             => true,
            'show_in_rest'          => true,
        )
    );
}
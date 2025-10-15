<?php
/**
 * Custom Post Type : Réalisation
 *
 * @package churchill
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

add_action('init', 'register_cpt_realisation');

function register_cpt_realisation() {
    
    $labels = array(
        'name'                  => 'Réalisations',
        'singular_name'         => 'Réalisation',
        'menu_name'             => 'Réalisations',
        'name_admin_bar'        => 'Réalisation',
        'add_new'               => 'Ajouter',
        'add_new_item'          => 'Ajouter une réalisation',
        'new_item'              => 'Nouvelle réalisation',
        'edit_item'             => 'Modifier la réalisation',
        'view_item'             => 'Voir la réalisation',
        'all_items'             => 'Toutes les réalisations',
        'search_items'          => 'Rechercher',
        'parent_item_colon'     => 'Réalisation parente:',
        'not_found'             => 'Aucune réalisation trouvée',
        'not_found_in_trash'    => 'Aucune réalisation dans la corbeille',
    );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'query_var'             => true,
        'rewrite'               => array('slug' => 'realisations'),
        'capability_type'       => 'post',
        'has_archive'           => true,
        'hierarchical'          => false,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-portfolio',
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest'          => true,
    );

    register_post_type('realisation', $args);
    
    // Taxonomie : Catégorie de réalisation
    register_taxonomy(
        'categorie_realisation',
        'realisation',
        array(
            'label'                 => 'Catégories',
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
            'rewrite'               => array('slug' => 'categorie-realisation'),
            'hierarchical'          => true,
            'show_ui'               => true,
            'show_admin_column'     => true,
            'query_var'             => true,
            'show_in_rest'          => true,
        )
    );
}
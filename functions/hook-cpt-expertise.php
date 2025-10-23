<?php

/**
 * Custom Post Type : Expertise
 *
 * @package churchill
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

add_action('init', 'register_cpt_expertise');

function register_cpt_expertise()
{
    $labels = array(
        'name'                  => 'Expertises',
        'singular_name'         => 'Expertise',
        'menu_name'             => 'Expertises',
        'name_admin_bar'        => 'Expertise',
        'add_new'               => 'Ajouter',
        'add_new_item'          => 'Ajouter une expertise',
        'new_item'              => 'Nouvelle expertise',
        'edit_item'             => 'Modifier l\'expertise',
        'view_item'             => 'Voir l\'expertise',
        'all_items'             => 'Toutes les expertises',
        'search_items'          => 'Rechercher',
        'parent_item_colon'     => 'Expertise parente:',
        'not_found'             => 'Aucune expertise trouvée',
        'not_found_in_trash'    => 'Aucune expertise dans la corbeille',
    );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'query_var'             => true,
        'rewrite'               => array('slug' => 'expertises'),
        'capability_type'       => 'post',
        'has_archive'           => true,
        'hierarchical'          => false,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-awards',
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest'          => true,

    );

    register_post_type('expertise', $args);

    register_taxonomy(
        'categorie_expertise',
        'expertise',
        array(
            'label'                 => 'Catégories Expertise',
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
            'rewrite'               => array('slug' => 'categorie-expertise'),
            'hierarchical'          => true,
            'show_ui'               => true,
            'show_admin_column'     => true,
            'query_var'             => true,
            'show_in_rest'          => true,
        )
    );
}

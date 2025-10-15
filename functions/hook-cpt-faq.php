<?php
/**
 * Custom Post Type : FAQ
 *
 * @package churchill
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

add_action('init', 'register_cpt_faq');

function register_cpt_faq() {
    
    $labels = array(
        'name'                  => 'FAQ',
        'singular_name'         => 'Question',
        'menu_name'             => 'FAQ',
        'name_admin_bar'        => 'FAQ',
        'add_new'               => 'Ajouter',
        'add_new_item'          => 'Ajouter une question',
        'new_item'              => 'Nouvelle question',
        'edit_item'             => 'Modifier la question',
        'view_item'             => 'Voir la question',
        'all_items'             => 'Toutes les questions',
        'search_items'          => 'Rechercher',
        'parent_item_colon'     => 'Question parente:',
        'not_found'             => 'Aucune question trouvée',
        'not_found_in_trash'    => 'Aucune question dans la corbeille',
    );

    $args = array(
        'labels'                => $labels,
        'public'                => false,
        'publicly_queryable'    => false,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'query_var'             => true,
        'rewrite'               => false,
        'capability_type'       => 'post',
        'has_archive'           => false,
        'hierarchical'          => false,
        'menu_position'         => 6,
        'menu_icon'             => 'dashicons-editor-help',
        'supports'              => array('title'),
        'show_in_rest'          => false,
    );

    register_post_type('faq', $args);
    
    // Taxonomie : Catégorie FAQ
    register_taxonomy(
        'categorie_faq',
        'faq',
        array(
            'label'                 => 'Catégories FAQ',
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
            'rewrite'               => false,
            'hierarchical'          => true,
            'show_ui'               => true,
            'show_admin_column'     => true,
            'query_var'             => true,
            'show_in_rest'          => false,
        )
    );
}
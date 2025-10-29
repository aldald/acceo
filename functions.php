<?php
require_once 'functions/hook-theme-setup.php';
require_once 'functions/hook-enqueue-scripts.php';
require_once 'functions/hook-enqueue-styles.php';
require_once 'functions/hook-tinymce-shortcodes.php';
require_once 'functions/hook-load-acf-builder-fields.php';
require_once 'functions/hook-load-contact-informations.php';
require_once 'functions/hook-load-acf-buttons-menu-fields.php';
require_once 'functions/hook-theme-colors.php';
require_once 'functions/hook-table-module.php';
require_once 'functions/hook-custom-wysiwyg-tools.php';
require_once 'functions/function-bootstrap5-pagination.php';
require_once 'functions/function-bootstrap5-yoast-breadcrumb.php';
require_once 'functions/function-custom-excerpt.php';
require_once 'functions/function-encode-email.php';
require_once 'functions/function-get-image-alt.php';
require_once 'functions/function-get-primary-category.php';
require_once 'functions/function-phone-format.php';
require_once 'functions/function-the-summary.php';
require_once 'functions/function-get-reading-time.php';
require_once 'functions/class-bootstrap5-nav-walker.php';
require_once 'functions/hook-topbar-menu-icons.php';
require_once 'functions/function-parse-colored-text.php';
require_once 'functions/hook-cpt-realisation.php';
require_once 'functions/hook-cpt-faq.php';
require_once 'functions/hook-cpt-mission.php';
require_once 'functions/function-render-blog-card.php';
require_once 'functions/function-render-actualite-card.php';
require_once 'functions/class-bootstrap5-megamenu-walker.php';
require_once 'functions/function-render-button.php';
require_once 'functions/function-render-category-badge.php';
require_once 'functions/function-acf-icon-picker.php';
require_once 'functions/hook-cpt-expertise.php';
require_once 'functions/function-get-inline-svg.php';

add_action('admin_enqueue_scripts', function ($hook) {
    if (isset($_GET['page']) && (($_GET['page'] === 'blog_composant') || ($_GET['page'] === 'blog_category_composant'))) {
        wp_enqueue_editor();
        wp_enqueue_media();
        add_editor_style();
    }
});


/**
 * Activer la duplication des posts avec leurs champs ACF
 */
add_filter('acfe/modules/post_types/args', 'churchill_enable_post_duplication', 10, 2);
function churchill_enable_post_duplication($args, $post_type)
{
    // Liste des CPT pour lesquels activer la duplication
    $allowed_cpts = array('realisation', 'mission', 'expertise', 'faq');

    if (in_array($post_type, $allowed_cpts)) {
        $args['supports'][] = 'custom-fields';
    }

    return $args;
}



/**
 * Ajouter un lien "Dupliquer" pour les catégories d'expertise
 */
add_filter('categorie_expertise_row_actions', 'add_duplicate_link_categorie_expertise', 10, 2);

function add_duplicate_link_categorie_expertise($actions, $term)
{
    $duplicate_link = admin_url('admin.php?action=duplicate_categorie_expertise&term_id=' . $term->term_id);
    $actions['duplicate'] = '<a href="' . wp_nonce_url($duplicate_link, 'duplicate_categorie_expertise_' . $term->term_id) . '">Dupliquer</a>';

    return $actions;
}

/**
 * Gérer la duplication de la catégorie
 */
add_action('admin_action_duplicate_categorie_expertise', 'duplicate_categorie_expertise_action');

function duplicate_categorie_expertise_action()
{
    if (!isset($_GET['term_id'])) {
        wp_die('Aucun terme à dupliquer.');
    }

    $term_id = absint($_GET['term_id']);

    // Vérifier le nonce
    check_admin_referer('duplicate_categorie_expertise_' . $term_id);

    // Récupérer le terme original
    $term = get_term($term_id, 'categorie_expertise');

    if (is_wp_error($term)) {
        wp_die('Terme invalide.');
    }

    // Créer le nouveau terme
    $new_term = wp_insert_term(
        $term->name . ' (Copie)',
        'categorie_expertise',
        array(
            'description' => $term->description,
            'slug' => $term->slug . '-copie-' . time(),
            'parent' => $term->parent
        )
    );

    if (is_wp_error($new_term)) {
        wp_die('Erreur lors de la duplication : ' . $new_term->get_error_message());
    }

    // Dupliquer les meta données (si vous en avez avec ACF par exemple)
    $term_meta = get_term_meta($term_id);
    if (!empty($term_meta)) {
        foreach ($term_meta as $meta_key => $meta_values) {
            foreach ($meta_values as $meta_value) {
                add_term_meta($new_term['term_id'], $meta_key, maybe_unserialize($meta_value));
            }
        }
    }

    // Rediriger vers la page d'édition du nouveau terme
    wp_redirect(admin_url('term.php?taxonomy=categorie_expertise&tag_ID=' . $new_term['term_id'] . '&post_type=expertise'));
    exit;
}



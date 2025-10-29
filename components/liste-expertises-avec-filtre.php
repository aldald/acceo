<?php

/**
 * Composant : Liste Expertises avec filtre
 * Affiche toutes les expertises avec filtres par catégorie (Layout 4/8)
 *
 * @package churchill
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Récupérer les champs ACF du composant
$chapo = get_sub_field('chapo');
$titre = get_sub_field('titre');

// Récupérer TOUTES les expertises
$expertises_args = array(
    'post_type' => 'expertise',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'orderby' => 'title',
    'order' => 'ASC'
);

$expertises_query = new WP_Query($expertises_args);
$expertises_ids = array();

if ($expertises_query->have_posts()) {
    while ($expertises_query->have_posts()) {
        $expertises_query->the_post();
        $expertises_ids[] = get_the_ID();
    }
    wp_reset_postdata();
}

// Si aucune expertise trouvée, ne rien afficher
if (empty($expertises_ids)) {
    return;
}

/**
 * Récupérer les catégories d'expertise (pour les filtres)
 */
$categories_expertise = array();

foreach ($expertises_ids as $expertise_id) {
    $terms = get_the_terms($expertise_id, 'categorie_expertise');

    if ($terms && !is_wp_error($terms)) {
        foreach ($terms as $term) {
            if (!isset($categories_expertise[$term->term_id])) {
                $categories_expertise[$term->term_id] = $term;
            }
        }
    }
}
?>

<div class="liste-expertises-avec-filtre">
    <div class="container">
        <!-- Layout Bootstrap : 4 colonnes filtres + 8 colonnes grille -->
        <div class="row">

            <!-- Colonne Filtres - 4 colonnes -->
            <div class="col-lg-4 col-md-12">
                <!-- Header -->
                <div class="title-heading">
                    <?php if ($chapo): ?>
                        <p class="expertises-chapo"><?php echo esc_html($chapo); ?></p>
                    <?php endif; ?>

                    <?php if ($titre): ?>
                        <h2><?php echo display_colored_title($titre); ?></h2>
                    <?php endif; ?>
                </div>

                <div class="expertises-filters-sidebar">
                    <?php foreach ($categories_expertise as $cat):
                        $cat_icon = get_field('icon_categorie', $cat);
                    ?>
                        <button class="filter-btn" data-filter="cat-<?php echo esc_attr($cat->term_id); ?>">
                            <?php if ($cat_icon && !empty($cat_icon)): ?>
                                <?php if ($cat_icon['mime_type'] === 'image/svg+xml'): ?>
                                    <?php get_inline_svg($cat_icon, $cat->name); ?>
                                <?php else: ?>
                                    <img src="<?php echo esc_url($cat_icon['url']); ?>"
                                        alt="<?php echo esc_attr($cat->name); ?>"
                                        loading="lazy">
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php echo esc_html($cat->name); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Colonne Grille Expertises - 8 colonnes -->
            <div class="col-lg-8 col-md-12">
                <div class="expertises-grid row">
                    <?php foreach ($expertises_ids as $expertise_id):
                        // Récupérer les catégories de cette expertise
                        $expertise_categories = get_the_terms($expertise_id, 'categorie_expertise');
                        $cat_classes = '';

                        if ($expertise_categories && !is_wp_error($expertise_categories)) {
                            foreach ($expertise_categories as $cat) {
                                $cat_classes .= ' cat-' . $cat->term_id;
                            }
                        }

                        // Récupérer les données de l'expertise
                        $titre_expertise = get_field('titre_expertise', $expertise_id);
                        $lien_expertise = get_permalink($expertise_id);
                    ?>
                        <div class="col-lg-6 col-md-6 col-12 expertise-item<?php echo esc_attr($cat_classes); ?>">
                            <article class="expertise-category-card">

                                <!-- Contenu de la carte -->
                                <div class="expertise-category-content">

                                    <!-- Titre avec lien -->
                                    <h5 class="expertise-category-title">
                                        <a href="<?php echo esc_url($lien_expertise); ?>">
                                            <?php echo esc_html($titre_expertise); ?>
                                        </a>
                                    </h5>

                                    <!-- Bouton CTA -->
                                    <?php
                                    echo render_button(array(
                                        'type'   => 'short',
                                        'url'    => esc_url($lien_expertise),
                                        'text'   => esc_attr($titre_expertise),
                                        'target' => '',
                                    ));
                                    ?>

                                </div>

                            </article>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>

    </div>
</div>
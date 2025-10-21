<?php

/**
 * Composant : Liste Réalisations avec filtre
 * Affiche toutes les réalisations avec filtres par catégorie (Layout 4/8)
 *
 * @package churchill
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Récupérer les champs ACF du composant
$chapo = get_sub_field('chapo');
$titre = get_sub_field('titre');

// Récupérer TOUTES les réalisations
$realisations_args = array(
    'post_type' => 'realisation',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'orderby' => 'title',
    'order' => 'ASC'
);

$realisations_query = new WP_Query($realisations_args);
$realisations_ids = array();

if ($realisations_query->have_posts()) {
    while ($realisations_query->have_posts()) {
        $realisations_query->the_post();
        $realisations_ids[] = get_the_ID();
    }
    wp_reset_postdata();
}

// Si aucune réalisation trouvée, ne rien afficher
if (empty($realisations_ids)) {
    return;
}

/**
 * Récupérer les catégories de réalisation (pour les filtres)
 */
$categories_realisation = array();

foreach ($realisations_ids as $realisation_id) {
    $terms = get_the_terms($realisation_id, 'categorie_realisation');

    if ($terms && !is_wp_error($terms)) {
        foreach ($terms as $term) {
            if (!isset($categories_realisation[$term->term_id])) {
                $categories_realisation[$term->term_id] = $term;
            }
        }
    }
}
?>

<div class="liste-realisations-avec-filtre">
    <div class="container">
        <!-- Layout Bootstrap : 4 colonnes filtres + 8 colonnes grille -->
        <div class="row">

            <!-- Colonne Filtres - 4 colonnes -->
            <div class="col-lg-4 col-md-12">
                <!-- Header -->
                <div class="title-heading">
                    <?php if ($chapo): ?>
                        <p class="realisations-chapo"><?php echo esc_html($chapo); ?></p>
                    <?php endif; ?>

                    <?php if ($titre): ?>
                        <h2><?php echo display_colored_title($titre); ?></h2>
                    <?php endif; ?>
                </div>

                <div class="realisations-filters-sidebar">
                    <?php foreach ($categories_realisation as $cat):
                        $cat_icon = get_field('icon_categorie', $cat);
                    ?>
                        <button class="filter-btn" data-filter="cat-<?php echo esc_attr($cat->term_id); ?>">
                            <?php if ($cat_icon): ?>
                                <?php the_icon($cat_icon); ?>
                            <?php endif; ?>
                            <?php echo esc_html($cat->name); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Colonne Grille Réalisations - 8 colonnes -->
            <div class="col-lg-8 col-md-12">
                <div class="realisations-grid row">
                    <?php foreach ($realisations_ids as $realisation_id):
                        // Récupérer les catégories de cette réalisation
                        $realisation_categories = get_the_terms($realisation_id, 'categorie_realisation');
                        $cat_classes = '';

                        if ($realisation_categories && !is_wp_error($realisation_categories)) {
                            foreach ($realisation_categories as $cat) {
                                $cat_classes .= ' cat-' . $cat->term_id;
                            }
                        }

                        // Récupérer les données de la réalisation
                        $titre_realisation = get_field('titre_realisation',$realisation_id);
                        $lien_realisation = get_permalink($realisation_id);
                        $logo_realisation = get_field('image_logo_realisation',$realisation_id);
                    ?>
                        <div class="col-lg-6 col-md-6 col-12 realisation-item<?php echo esc_attr($cat_classes); ?>">
                            <article class="realisation-category-card">
                                    <div class="logo-realisation">
                                        <img src="<?php echo esc_url($logo_realisation['url']) ?>" />
                                    </div>

                                <!-- Contenu de la carte -->
                                <div class="realisation-category-content">

                                    <!-- Titre avec lien -->
                                    <h5 class="realisation-category-title">
                                        <a href="<?php echo esc_url($lien_realisation); ?>">
                                            <?php echo esc_html($titre_realisation); ?>
                                        </a>
                                    </h5>

                                    <!-- Bouton CTA -->
                                    <?php
                                    echo render_button(array(
                                        'type'   => 'short',
                                        'url'    => esc_url($lien_realisation),
                                        'text'   => esc_attr($titre_realisation),
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
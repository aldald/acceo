<?php

/**
 * Composant : Liste catégorie - Expertises
 * Affiche les catégories d'expertise sélectionnées sous forme de cartes cliquables
 *
 * @package churchill
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Récupérer les champs ACF
$chapo = get_sub_field('chapo_composant');
$titre = get_sub_field('titre_composant');
$categories_ids = get_sub_field('categories_expertise');

// Si aucune catégorie sélectionnée, ne rien afficher
if (empty($categories_ids) || !is_array($categories_ids)) {
    return;
}

/**
 * Construire le tableau des catégories avec leurs données
 */
$categories = array();

foreach ($categories_ids as $cat_id) {
    $cat_term = get_term($cat_id, 'categorie_expertise');

    if (!$cat_term || is_wp_error($cat_term)) {
        continue;
    }

    // Récupérer l'icône de la catégorie
    $cat_icon = get_field('icon_categorie', 'categorie_expertise_' . $cat_id);

    // Récupérer l'image de la catégorie
    $cat_image = get_field('image_categorie', 'categorie_expertise_' . $cat_id);

    // Si l'image de la catégorie existe, l'utiliser
    $categorie_image = '';
    if (!empty($cat_image) && isset($cat_image['url'])) {
        $categorie_image = $cat_image['url'];
    } else {
        // Sinon, récupérer une expertise exemple pour l'image de fond (fallback)
        $exemple_expertise_query = new WP_Query(array(
            'post_type' => 'expertise',
            'posts_per_page' => 1,
            'post_status' => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => 'categorie_expertise',
                    'field' => 'term_id',
                    'terms' => $cat_id,
                ),
            ),
            'orderby' => 'menu_order',
            'order' => 'ASC'
        ));

        if ($exemple_expertise_query->have_posts()) {
            $exemple_expertise_query->the_post();
            $categorie_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
            wp_reset_postdata();
        }
    }

    // Construire l'URL de la catégorie (page d'archive)
    $cat_link = get_term_link($cat_term);

    if (is_wp_error($cat_link)) {
        $cat_link = '#';
    }

    $categories[] = array(
        'id' => $cat_id,
        'nom' => $cat_term->name,
        'description' => $cat_term->description,
        'icon' => $cat_icon,
        'image' => $categorie_image,
        'lien' => $cat_link,
        'count' => $cat_term->count
    );
}

// Si aucune catégorie valide, ne rien afficher
if (empty($categories)) {
    return;
}
?>

<div class="liste-categorie-expertises">
    <div class="container">

        <!-- Header avec titre et chapô -->
        <div class="title-heading">
            <?php if ($chapo): ?>
                <p class="expertises-chapo"><?php echo esc_html($chapo); ?></p>
            <?php endif; ?>

            <?php if ($titre): ?>
                <h2><?php echo display_colored_title($titre); ?></h2>
            <?php endif; ?>
        </div>

        <!-- Grille de catégories (Bootstrap Grid - 4 colonnes) -->
        <div class="row g-4 expertises-grid">
            <?php foreach ($categories as $categorie): ?>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="expertise-card" data-href="<?php echo esc_url($categorie['lien']); ?>">

                        <!-- Image de fond -->
                        <?php if ($categorie['image']): ?>
                            <div class="expertise-card-image">
                                <img src="<?php echo esc_url($categorie['image']); ?>"
                                    alt="<?php echo esc_attr($categorie['nom']); ?>"
                                    loading="lazy">
                            </div>
                        <?php endif; ?>

                        <!-- Overlay avec gradient -->
                        <div class="expertise-card-overlay"></div>

                        <!-- Icône catégorie (coin supérieur gauche) -->
                        <?php if (!empty($categorie['icon'])): ?>
                            <div class="expertise-icon-wrapper">
                                <?php
                                // Récupérer le chemin du fichier SVG
                                $svg_path = get_attached_file($categorie['icon']['ID']);

                                // Vérifier que le fichier existe et est un SVG
                                if ($svg_path && file_exists($svg_path) && pathinfo($svg_path, PATHINFO_EXTENSION) === 'svg') {
                                    // Lire et afficher le contenu SVG inline
                                    $svg_content = file_get_contents($svg_path);

                                    // Ajouter une classe pour le styling
                                    $svg_content = str_replace('<svg', '<svg class="expertise-icon"', $svg_content);

                                    echo $svg_content;
                                } else {
                                    // Fallback sur balise img si problème
                                    echo '<img src="' . esc_url($categorie['icon']['url']) . '" alt="' . esc_attr($categorie['nom']) . '" class="expertise-icon">';
                                }
                                ?>
                            </div>
                        <?php endif; ?>

                        <!-- Contenu (nom catégorie + bouton) -->
                        <div class="expertise-card-content">
                            <h4 class="expertise-titre"><?php echo esc_html($categorie['nom']); ?></h4>

                            <?php
                            echo render_button(array(
                                'type'   => 'short',
                                'url'    => $categorie['lien'],
                                'text'   => '',
                                'target' => '_self',
                            ));
                            ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>

<script>
// Rendre les cartes cliquables
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.expertise-card[data-href]');
    
    cards.forEach(card => {
        card.style.cursor = 'pointer';
        
        card.addEventListener('click', function(e) {
            // Ne pas déclencher si on clique directement sur le bouton
            if (!e.target.closest('.btn-short')) {
                window.location.href = this.getAttribute('data-href');
            }
        });
    });
});
</script>
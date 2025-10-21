<?php
/**
 * Composant : Mission Categories
 *
 * @package churchill
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Récupérer les champs
$titre = get_sub_field('titre');
$categories_ids = get_sub_field('categories_missions');

if (!$categories_ids || empty($categories_ids)) return;
?>

<div class="missions-categories-section">
    <div class="container">

        <!-- Header -->
        <div class="row">
            <div class="col-12">
                <div class="title-heading">

                    <?php if ($titre): ?>
                        <h2><?php echo display_colored_title($titre); ?></h2>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Grille des catégories - 3 colonnes pleine largeur -->
        <div class="row g-4">
            
            <?php foreach ($categories_ids as $cat_id):
                $category = get_term($cat_id, 'categorie_mission');
                if (!$category || is_wp_error($category)) continue;

                $cat_name = $category->name;
                $cat_description = $category->description;
                
                // CORRECTION : Vérifier si get_term_link retourne une erreur
                $cat_link = get_term_link($category);
                if (is_wp_error($cat_link)) {
                    continue; // Skip cette catégorie si le lien est invalide
                }
                
                // Récupérer l'image de la catégorie (champ ACF)
                $cat_image = get_field('image_categorie', 'categorie_mission_' . $cat_id);
                
                // Fallback : image de la première mission de cette catégorie
                if (!$cat_image) {
                    $missions_in_cat = get_posts(array(
                        'post_type' => 'mission',
                        'posts_per_page' => 1,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'categorie_mission',
                                'field' => 'term_id',
                                'terms' => $cat_id,
                            ),
                        ),
                    ));
                    
                    if (!empty($missions_in_cat)) {
                        $cat_image = get_field('image_mission', $missions_in_cat[0]->ID);
                    }
                }
            ?>
                
                <!-- Chaque catégorie sur 4 colonnes (3 par ligne) -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <article class="mission-category-card">
                        
                        <!-- Image de la catégorie (sans lien) -->
                        <?php if ($cat_image): ?>
                            <div class="mission-category-image">
                                <img src="<?php echo esc_url(is_array($cat_image) ? $cat_image['url'] : $cat_image); ?>" 
                                     alt="<?php echo esc_attr($cat_name); ?>"
                                     loading="lazy">
                            </div>
                        <?php endif; ?>

                        <!-- Contenu de la carte -->
                        <div class="mission-category-content">
                            
                            <!-- Titre avec lien -->
                            <h4 class="mission-category-title">
                                <a href="<?php echo esc_url($cat_link); ?>">
                                    <?php echo esc_html($cat_name); ?>
                                </a>
                            </h4>

                            <!-- Description (optionnelle) -->
                            <?php if ($cat_description): ?>
                                <p class="mission-category-description">
                                    <?php echo esc_html($cat_description); ?>
                                </p>
                            <?php endif; ?>

                            <!-- Bouton CTA -->
                            <?php
                            echo render_button(array(
                                'type'   => 'short',
                                'url'    => esc_url($cat_link),
                                'text'   => esc_attr($cat_name),
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
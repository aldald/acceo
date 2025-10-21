<?php
/**
 * Composant : Liste Expertise
 * Affiche une grille d'expertises sélectionnées (4 colonnes)
 *
 * @package churchill
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Récupérer les champs ACF
$chapo = get_sub_field('chapo');
$titre = get_sub_field('titre');
$expertises_ids = get_sub_field('selecteur_expertises');

// Si pas d'expertises sélectionnées, ne rien afficher
if (empty($expertises_ids)) {
    return;
}
?>

<div class="liste-expertise-composant">
    <div class="container">

        <!-- Header -->
        <div class="title-heading">
            <?php if ($chapo): ?>
                <p class="expertise-chapo"><?php echo esc_html($chapo); ?></p>
            <?php endif; ?>

            <?php if ($titre): ?>
                <h2><?php echo display_colored_title($titre); ?></h2>
            <?php endif; ?>
        </div>

        <!-- Grille des expertises -->
        <div class="expertises-grid row">
            <?php foreach ($expertises_ids as $expertise_id):
                // Récupérer les données de l'expertise
                $titre_expertise = get_the_title($expertise_id);
                $lien_expertise = get_permalink($expertise_id);
            ?>
                <div class="col-lg-4 col-md-6 col-12 expertise-item">
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
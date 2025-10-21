<?php

/**
 * Composant : Hero Accueil
 *
 * @package churchill
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Récupérer les champs
$titre = get_sub_field('titre');
$description = get_sub_field('description');
$bouton = get_sub_field('bouton');
$image = get_sub_field('image');
$background = get_sub_field('background');

$image_url = $image ? wp_get_attachment_image_url($image, 'full') : '';
$background_url = $background ?: '';

?>

<div class="hero-accueil-wrapper" <?php if ($background_url): ?>style="background-image: url(<?php echo esc_url($background_url); ?>);"<?php endif; ?>>
    
    <div class="container">
        <div class="row align-items-center">
            
            <!-- Colonne Contenu (Texte + CTA) - 6 colonnes -->
            <div class="col-lg-6 col-md-12">
                <div class="hero-accueil-content">
                    
                    <?php if ($titre): ?>
                        <h1 class="hero-accueil-title">
                            <?php echo display_colored_title($titre); ?>
                        </h1>
                    <?php endif; ?>

                    <?php if ($description): ?>
                        <p class="hero-accueil-description">
                            <?php echo nl2br(esc_html($description)); ?>
                        </p>
                    <?php endif; ?>

                    <?php if ($bouton && !empty($bouton['url'])): ?>
                        <div class="hero-accueil-cta">
                            <?php
                            echo render_button(array(
                                'type'   => 'primary',
                                'url'    => esc_url($bouton['url']),
                                'text'   => $bouton['title'] ?: 'En savoir plus',
                                'target' => !empty($bouton['target']) ? $bouton['target'] : '',
                            ));
                            ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>

    <!-- Image d'illustration en background collée à droite -->
    <?php if ($image_url): ?>
        <div class="hero-accueil-bg-image" style="background-image: url(<?php echo esc_url($image_url); ?>);"></div>
    <?php endif; ?>

</div>
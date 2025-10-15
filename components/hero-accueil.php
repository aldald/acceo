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

<section class="hero-section-modern" <?php if ($background_url): ?>style="background-image: url(<?php echo esc_url($background_url); ?>);" <?php endif; ?>>
    <div class="container">
        <div class="hero-content-modern">

            <!-- Colonne de gauche : Contenu -->
            <div class="hero-text-modern">
                <?php if ($titre): ?>
                    <h1 class="hero-title-modern">
                        <?php echo display_colored_title($titre); ?>
                    </h1>
                <?php endif; ?>

                <?php if ($description): ?>
                    <p class="hero-description-modern">
                        <?php echo nl2br(esc_html($description)); ?>
                    </p>
                <?php endif; ?>

                <?php if ($bouton && !empty($bouton['url'])): ?>
                    <div class="hero-cta-modern">
                        <?php
                        echo render_button(array(
                            'type'   => 'primary',
                            'url'    => $bouton['url'],
                            'text'   => $bouton['title'] ?: 'En savoir plus',
                            'target' => !empty($bouton['target']) ? $bouton['target'] : '',
                        ));
                        ?>


                    </div>
                <?php endif; ?>
            </div>


        </div>
    </div>
    <?php if ($image_url): ?>
        <div class="bg-hero-img" style="background-image: url(<?php echo esc_url($image_url); ?>);">
        </div>
    <?php endif; ?>


</section>
<?php

/**
 * Composant : Vidéo / Texte
 *
 * @package churchill
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Récupérer les champs
$titre = get_sub_field('titre');
$description = get_sub_field('description');
$cta = get_sub_field('cta');
$video = get_sub_field('video');

if (!$video || empty($video['miniature'])) return;
?>

<div class="video-texte-wrapper">
    <div class="container-fluid">
        <div class="row g-0 align-items-stretch">

            <!-- Colonne Vidéo - 8 colonnes -->
            <div class="col-lg-8 col-md-12">
                <div class="video-texte-media">
                    <?php
                    // Utiliser le shortcode modal_video du thème
                    if (!empty($video['url']) && !empty($video['miniature']['url'])) {
                        echo do_shortcode('[modal_video url="' . esc_url($video['url']) . '" image="' . esc_url($video['miniature']['url']) . '"]');
                    }
                    ?>
                </div>
            </div>

            <!-- Colonne Texte - 4 colonnes -->
            <div class="col-lg-4 col-md-12">
                <div class="video-texte-card">

                    <?php if ($titre): ?>
                        <h2 class="video-texte-title">
                            <?php echo display_colored_title($titre); ?>
                        </h2>
                    <?php endif; ?>

                    <?php if ($description): ?>
                        <div class="video-texte-text">
                            <?php echo wp_kses_post($description); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($cta && !empty($cta['texte']) && !empty($cta['lien'])): ?>
                        <div class="video-texte-cta">
                            <?php
                            echo render_button(array(
                                'type'   => 'primary',
                                'url'    => esc_url($cta['lien']),
                                'text'   => esc_html($cta['texte']) ?: '',
                                'target' => '',
                            ));
                            ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>
</div>
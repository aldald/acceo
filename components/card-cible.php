<?php

/**
 * Composant : Card Cible
 *
 * @package churchill
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Récupérer les champs
$titre = get_sub_field('titre') ?: 'Vous êtes';
$cartes = get_sub_field('cartes');

// Générer un ID unique pour ce carrousel
$carousel_id = 'carousel-' . uniqid();

if (!$cartes || empty($cartes)) return;
?>

<section class="vous-etes-section">
    <div class="container">

        <div class="title-heading">
            <h2><?php echo display_colored_title($titre); ?></h2>

            <!-- Navigation carrousel -->
            <div class="carrousel-navigation">
                <button class="carrousel-btn carrousel-prev" data-carousel="<?php echo esc_attr($carousel_id); ?>" aria-label="Précédent">
                    <?php
                    $svg_path = get_template_directory() . '/assets/img/acf/icon-left.svg';

                    if (file_exists($svg_path)) :
                    ?>
                        <div class="box-icon">
                            <?php echo file_get_contents($svg_path); ?>
                        </div>
                    <?php
                    endif; ?>

                </button>

                <button class="carrousel-btn carrousel-next" data-carousel="<?php echo esc_attr($carousel_id); ?>" aria-label="Suivant">

                    <?php
                    $svg_path = get_template_directory() . '/assets/img/acf/icon-right.svg';

                    if (file_exists($svg_path)) :
                    ?>
                        <div class="box-icon">
                            <?php echo file_get_contents($svg_path); ?>
                        </div>
                    <?php
                    endif; ?>

                </button>
            </div>
        </div>

    </div>

    <div class="carrousel-container">
        <div class="carrousel-track"
            id="<?php echo esc_attr($carousel_id); ?>"
            data-total-slides="<?php echo count($cartes); ?>">

            <?php foreach ($cartes as $index => $carte):
                $image = $carte['image'];
                $bouton = $carte['bouton'];
            ?>
                <div class="vous-etes-carte" data-slide="<?php echo $index; ?>">



                    <div class="carte-content-wrapper">

                        <?php if ($carte['titre']): ?>
                            <h3 class="carte-titre-modern">
                                <?php echo esc_html($carte['titre']); ?>
                            </h3>
                        <?php endif; ?>

                        <?php if ($bouton && !empty($bouton['url'])): ?>
                            <?php
                            echo render_button(array(
                                'type'   => 'secondary',
                                'url'    => $bouton['url'],
                                'text'   => $bouton['title'] ?: 'En savoir plus',
                                'target' => !empty($bouton['target']) ? $bouton['target'] : '',
                            ));
                            ?>
                        <?php endif; ?>

                    </div>

                    <?php if ($image): ?>
                        <div class="carte-image-wrapper">
                            <?php echo wp_get_attachment_image($image, 'medium', false, array(
                                'alt' => $carte['titre'] ?: ''
                            )); ?>
                        </div>
                    <?php endif; ?>

                </div>
            <?php endforeach; ?>

        </div>
    </div>
</section>
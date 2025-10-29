<?php

/**
 * Composant : Frise chronologique
 *
 * @package churchill
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Récupérer les champs
$titre_composant = get_sub_field('frise_titre_composant');
$elements = get_sub_field('frise_elements');

if (!$elements || empty($elements)) return;
?>

<!-- Section FRISE CHRONOLOGIQUE -->
<div class="frise-chronologique-section">
    <div class="container">

        <!-- Titre -->
        <?php if ($titre_composant): ?>
            <div class="title-heading">
                <h2><?php echo display_colored_title($titre_composant); ?></h2>
            </div>
        <?php endif; ?>

        <!-- Timeline Points (années) -->
        <div class="frise-timeline">
            <?php foreach ($elements as $index => $element): ?>
                <div class="timeline-point <?php echo $index === 0 ? 'active' : ''; ?>" data-slide="<?php echo $index; ?>">
                    <span class="timeline-year"><?php echo esc_html($element['date_element']); ?></span>
                </div>
            <?php endforeach; ?>
        </div>

    </div>

    <!-- Carrousel -->
    <div class="frise-carrousel-container">
        <div class="frise-carrousel-track" data-total-slides="<?php echo count($elements); ?>">

            <?php foreach ($elements as $index => $element):
                $date = $element['date_element'];
                $titre = $element['titre_element'];
                $image = $element['image_element'];
                $texte = $element['texte_element'];
            ?>

                <div class="frise-carte" data-slide="<?php echo $index; ?>">
                    <div class="container">
                        <div class="row">

                            <!-- Image (Gauche) : offset-1 + 4 colonnes -->
                            <div class="col-lg-4 offset-lg-1 col-md-12">
                                <div class="frise-carte-left">
                                    <div class="frise-date-grande"><?php echo esc_html($date); ?></div>

                                    <?php if ($image): ?>
                                        <div class="frise-image">
                                            <img src="<?php echo esc_url($image['url']); ?>"
                                                alt="<?php echo esc_attr($image['alt'] ?: $titre); ?>"
                                                loading="lazy">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Texte (Droite) : 5 colonnes + offset-1 -->
                            <div class="col-lg-5 offset-lg-1 col-md-12">
                                <div class="frise-carte-right">
                                    <h4 class="frise-titre-element"><?php echo display_colored_title($titre); ?></h4>
                                    <div class="frise-texte">
                                        <p><?php echo nl2br(esc_html($texte)); ?></p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            <?php endforeach; ?>

        </div>
    </div>

    <!-- Navigation -->
    <div class="container">
        <div class="frise-navigation">
            <button class="carrousel-btn carrousel-prev-frise" aria-label="Précédent">
                <?php
                $svg_path = get_template_directory() . '/assets/img/acf/icon-left.svg';
                if (file_exists($svg_path)):
                ?>
                    <div class="box-icon">
                        <?php echo file_get_contents($svg_path); ?>
                    </div>
                <?php endif; ?>
            </button>
            <button class="carrousel-btn carrousel-next-frise" aria-label="Suivant">
                <?php
                $svg_path = get_template_directory() . '/assets/img/acf/icon-right.svg';
                if (file_exists($svg_path)):
                ?>
                    <div class="box-icon">
                        <?php echo file_get_contents($svg_path); ?>
                    </div>
                <?php endif; ?>
            </button>
        </div>
    </div>

</div>
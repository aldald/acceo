<?php

/**
 * Composant : Listing Process
 * Affiche un slider de process cards numérotées
 *
 * @package churchill
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Récupérer les champs ACF
$titre = get_sub_field('titre');
$chapo = get_sub_field('chapo');
$process_items = get_sub_field('process_items');

// Si pas d'items, ne rien afficher
if (empty($process_items)) {
    return;
}
?>

<div class="listing-process-section">
    <div class="container">

        <div class="title-heading">
            <div>
                <?php if ($titre): ?>
                    <h2><?php echo display_colored_title($titre); ?></h2>
                <?php endif; ?>

                <?php if ($chapo): ?>
                    <p class="process-chapo"><?php echo nl2br(esc_html($chapo)); ?></p>
                <?php endif; ?>
            </div>
            <!-- Navigation carrousel -->
            <div class="carrousel-navigation">
                <button class="carrousel-btn carrousel-prev-process" aria-label="Précédent">
                    <?php
                    $svg_path = get_template_directory() . '/assets/img/acf/icon-left.svg';
                    if (file_exists($svg_path)):
                    ?>
                        <div class="box-icon">
                            <?php echo file_get_contents($svg_path); ?>
                        </div>
                    <?php endif; ?>
                </button>
                <button class="carrousel-btn carrousel-next-process" aria-label="Suivant">
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

    <!-- Carrousel -->
    <div class="carrousel-container">
        <div class="carrousel-track-process" data-total-slides="<?php echo count($process_items); ?>">

            <?php
            $process_count = 1;
            foreach ($process_items as $item):
                $image = $item['image'];
                $titre_etape = $item['titre'];
                $texte_etape = $item['texte'];
            ?>

                <div class="process-carte" data-slide="<?php echo $process_count - 1; ?>">

                    <!-- Image -->
                    <?php if ($image): ?>
                        <div class="process-image">
                            <img src="<?php echo esc_url($image['url']); ?>"
                                alt="<?php echo esc_attr($image['alt'] ?: $titre_etape); ?>"
                                loading="lazy">
                        </div>
                    <?php endif; ?>

                    <div class="process-content">

                        <div class="process-content-top">
                            <!-- Numéro -->
                            <div class="process-numero">
                                <?php echo $process_count; ?>
                            </div>

                            <!-- Titre -->
                            <h4 class="process-titre"><?php echo esc_html($titre_etape); ?></h4>
                        </div>
                        <!-- Texte -->
                        <div class="process-texte">
                            <p><?php echo nl2br(esc_html($texte_etape)); ?></p>
                        </div>
                    </div>
                </div>

            <?php
                $process_count++;
            endforeach;
            ?>

        </div>
    </div>

</div>
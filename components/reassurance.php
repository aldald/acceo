<?php

/**
 * Composant : Réassurance
 *
 * @package churchill
 */

defined('ABSPATH') || exit;

$titre = get_sub_field('titre');
$contenu = get_sub_field('contenu');
$background = get_sub_field('background');
$boxes = get_sub_field('boxes');

if (!$boxes || empty($boxes)) return;
?>

<section class="reassurance-section" <?php if ($background): ?>style="background-image: url(<?php echo esc_url($background); ?>);" <?php endif; ?>>
    <div class="container">
        <div class="reassurance-wrapper">
            <div class="reassurance-grid">

                <!-- Colonne gauche : Titre + Contenu -->
                <div class="title-heading">

                    <?php if ($titre): ?>
                        <h2><?php echo display_colored_title($titre); ?></h2>
                    <?php endif; ?>

                    <?php if ($contenu): ?>
                        <div class="reassurance-texte">
                            <?php echo wp_kses_post($contenu); ?>
                        </div>
                    <?php endif; ?>


                </div>

                <!-- Colonne droite : Grille de boxes -->
                <div class="reassurance-boxes-grid">

                    <?php foreach ($boxes as $index => $box): ?>

                        <?php if ($box['type'] === 'chiffre'): ?>

                            <!-- BOX TYPE : Chiffre clé -->
                            <div class="reassurance-box reassurance-box-chiffre" data-box-index="<?php echo $index; ?>">

                                <?php if (!empty($box['icone'])): ?>
                                    <div class="box-icon">
                                        <?php the_icon($box['icone']); ?>
                                    </div>
                                <?php endif; ?>

                                <div class="box-chiffre"
                                    data-target="<?php echo esc_attr($box['chiffre']); ?>"
                                    data-counter>
                                    0
                                </div>

                                <?php if (!empty($box['label'])): ?>
                                    <div class="box-label">
                                        <?php echo esc_html($box['label']); ?>
                                    </div>
                                <?php endif; ?>

                            </div>

                        <?php elseif ($box['type'] === 'image' && !empty($box['image'])): ?>

                            <!-- BOX TYPE : Image seule -->
                            <div class="reassurance-box reassurance-box-image" data-box-index="<?php echo $index; ?>">
                                <div class="box-image-wrapper">
                                    <?php echo wp_get_attachment_image($box['image'], 'medium', false, array(
                                        'loading' => 'lazy'
                                    )); ?>
                                </div>
                            </div>

                        <?php endif; ?>

                    <?php endforeach; ?>

                </div>

            </div>
        </div>
    </div>
</section>
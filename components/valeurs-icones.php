<?php

/**
 * Composant : Valeurs Icônes
 *
 * @package churchill
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Récupérer les champs
$titre_composant = get_sub_field('valeurs_titre_composant');
$texte = get_sub_field('valeurs_texte_element');
$image_fond = get_sub_field('valeurs_image_composant');
$cta = get_sub_field('valeurs_cta_composant');
$valeurs = get_sub_field('valeurs_icones_elements');

if (!$valeurs || empty($valeurs)) return;

// Positions des cartes (aux 4 coins)
$positions = ['top-left', 'top-right', 'bottom-left', 'bottom-right'];
?>

<!-- Section VALEURS ICÔNES -->
<div class="valeurs-icones-section">
    <div class="container">
        <div class="row">

            <!-- GAUCHE : 6 colonnes - Image + Cartes aux coins -->
            <div class="col-lg-6 col-md-12">
                <div class="valeurs-left-wrapper">

                    <!-- Image de fond (centrée) -->
                    <?php if ($image_fond): ?>
                        <div class="valeurs-background-image">
                            <img src="<?php echo esc_url($image_fond['url']); ?>"
                                alt="<?php echo esc_attr($image_fond['alt'] ?: 'Nos valeurs'); ?>"
                                loading="lazy">
                        </div>
                    <?php endif; ?>

                    <!-- Cartes Valeurs positionnées aux 4 coins -->
                    <?php foreach ($valeurs as $index => $valeur):
                        $icone = $valeur['icone_element'];
                        $titre = $valeur['titre_element'];
                        $position = isset($positions[$index]) ? $positions[$index] : '';
                    ?>
                        <div class="valeur-card valeur-card-<?php echo $position; ?>" data-index="<?php echo $index; ?>">
                            <?php if ($icone): ?>
                                <div class="valeur-icone">
                                    <?php if ($icone['mime_type'] === 'image/svg+xml'): ?>
                                        <?php echo file_get_contents($icone['url']); ?>
                                    <?php else: ?>
                                        <img src="<?php echo esc_url($icone['url']); ?>"
                                            alt="<?php echo esc_attr($titre); ?>"
                                            loading="lazy">
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <h5 class="valeur-titre"><?php echo esc_html($titre); ?></h5>
                        </div>
                    <?php endforeach; ?>

                </div>
            </div>

            <!-- DROITE : 4 colonnes avec offset 1 - Contenu texte -->
            <div class="col-lg-4 offset-lg-1 col-md-12">
                <div class="valeurs-content">
                    <?php if ($titre_composant): ?>
                        <div class="title-heading">
                            <h2>
                                <?php echo display_colored_title($titre_composant); ?>
                            </h2>
                        </div>
                    <?php endif; ?>

                    <?php if ($texte): ?>
                        <div class="valeurs-texte">
                            <?php echo wp_kses_post(wpautop($texte)); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($cta && !empty($cta['texte']) && !empty($cta['lien'])): ?>
                        <div class="valeurs-cta">
                            <?php echo render_button(array(
                                'type' => 'primary',
                                'url'  => $cta['lien'],
                                'text' => $cta['texte']
                            )); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>
<?php

/**
 * Composant : Onglet Accordéon
 *
 * @package churchill
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Récupérer les champs
$image = get_sub_field('onglet_image');
$onglets = get_sub_field('onglet_elements');

if (!$onglets || empty($onglets)) return;
?>

<!-- Section ONGLET ACCORDÉON -->
<div class="onglet-accordion-section">
    <div class="container">
        <div class="row">

            <!-- Gauche : Image - 4 colonnes -->
            <div class="col-lg-4 col-md-12">
                <?php if ($image): ?>
                    <div class="onglet-image-wrapper">
                        <img src="<?php echo esc_url($image['url']); ?>"
                             alt="<?php echo esc_attr($image['alt'] ?: 'Image'); ?>"
                             loading="lazy"
                             class="onglet-image">
                    </div>
                <?php endif; ?>
            </div>

            <!-- Droite : Accordéons - 7 colonnes avec offset 1 -->
            <div class="col-lg-7 offset-lg-1 col-md-12">
                <div class="onglet-accordion-wrapper">

                    <?php foreach ($onglets as $index => $onglet): 
                        $titre = $onglet['titre_element'];
                        $texte = $onglet['texte_element'];
                        $is_first = ($index === 0);
                    ?>

                        <div class="onglet-item" data-onglet-item="<?php echo $index; ?>">

                            <!-- Bouton accordéon -->
                            <button class="onglet-toggle"
                                data-onglet-toggle="<?php echo $index; ?>"
                                aria-expanded="<?php echo $is_first ? 'true' : 'false'; ?>"
                                aria-controls="onglet-content-<?php echo $index; ?>">

                                <span class="onglet-titre"><?php echo esc_html($titre); ?></span>

                                <!-- Icône +/- -->
                                <span class="onglet-icon" aria-hidden="true">
                                    <svg class="onglet-icon-plus" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <svg class="onglet-icon-minus" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>

                            </button>

                            <!-- Contenu accordéon -->
                            <div class="onglet-content"
                                id="onglet-content-<?php echo $index; ?>"
                                aria-hidden="<?php echo $is_first ? 'false' : 'true'; ?>"
                                style="<?php echo $is_first ? 'display: block;' : 'display: none;'; ?>">
                                <div class="onglet-content-inner">
                                    <?php echo wp_kses_post($texte); ?>
                                </div>
                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>
            </div>

        </div>
    </div>
</div>
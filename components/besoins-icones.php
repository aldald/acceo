<?php
/**
 * Composant : Besoins icônes
 * Listing des besoins avec icônes dans des cards
 *
 * @package churchill
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Récupérer les champs
$titre_composant = get_sub_field('titre_composant');
$texte_composant = get_sub_field('texte_composant');
$image_composant = get_sub_field('image_composant');
$besoins_icones = get_sub_field('besoins_icones');

// Vérifier qu'il y a des besoins
if (!$besoins_icones || empty($besoins_icones)) return;
?>

<div class="besoins-icones-section">
    <div class="container">
        <div class="row">

            <!-- Colonne Gauche : Contenu texte + Image qui déborde (6 colonnes) -->
            <div class="col-lg-6 col-md-12">
                <div class="besoins-icones-left">
                    
                    <div class="besoins-icones-content">
                        <?php if ($titre_composant): ?>
                            <h2 class="besoins-icones-title">
                                <?php echo display_colored_title($titre_composant); ?>
                            </h2>
                        <?php endif; ?>

                        <?php if ($texte_composant): ?>
                            <div class="besoins-icones-text">
                                <?php echo wp_kses_post($texte_composant); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Image qui déborde -->
                    <?php if ($image_composant): ?>
                        <div class="besoins-icones-image">
                            <img src="<?php echo esc_url($image_composant['url']); ?>"
                                 alt="<?php echo esc_attr($image_composant['alt'] ?: 'Image'); ?>"
                                 loading="lazy">
                        </div>
                    <?php endif; ?>

                </div>
            </div>

            <!-- Colonne Droite : Liste des besoins (6 colonnes) -->
            <div class="col-lg-6 col-md-12">
                <div class="besoins-icones-list">

                    <?php foreach ($besoins_icones as $besoin): 
                        $icone = $besoin['icone_element'];
                        $titre = $besoin['titre_element'];
                        $texte = $besoin['texte_composant'];
                    ?>

                        <div class="besoin-card">
                            
                            <!-- Icône -->
                            <div class="besoin-icon">
                                <?php 
                                if ($icone) {
                                    the_icon($icone, array(
                                        'class' => 'icon-svg',
                                        'width' => 48,
                                        'height' => 48
                                    ));
                                }
                                ?>
                            </div>

                            <!-- Contenu -->
                            <div class="besoin-content">
                                <h5 class="besoin-title"><?php echo esc_html($titre); ?></h5>
                                <p class="besoin-text"><?php echo nl2br(esc_html($texte)); ?></p>
                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>
            </div>

        </div>
    </div>
</div>
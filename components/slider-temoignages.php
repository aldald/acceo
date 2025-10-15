<?php

/**
 * Composant : Slider Témoignages
 *
 * @package churchill
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Récupérer les champs
$slider_titre = get_sub_field('slider_temoignages_titre');
$slider_cta = get_sub_field('slider_temoignages_cta');
$realisations_ids = get_sub_field('slider_temoignages_selecteur');

if (!$realisations_ids || empty($realisations_ids)) return;

$realisations_avec_temoignage = array_filter($realisations_ids, function ($id) {
    return !empty(get_field('temoignage', $id));
});

if (empty($realisations_avec_temoignage)) return;
?>

<!-- Section SLIDER TÉMOIGNAGES -->
<section class="temoignages-section">
    <div class="container">

        <div class="title-heading">
            <?php if ($slider_titre): ?>
                <h2><?php echo display_colored_title($slider_titre); ?></h2>
            <?php endif; ?>

            <!-- Navigation carrousel -->
            <div class="carrousel-navigation">
                <button class="carrousel-btn carrousel-prev-temoignages" aria-label="Précédent">
                    <?php
                    $svg_path = get_template_directory() . '/assets/img/acf/icon-left.svg';
                    if (file_exists($svg_path)):
                    ?>
                        <div class="box-icon">
                            <?php echo file_get_contents($svg_path); ?>
                        </div>
                    <?php endif; ?>
                </button>
                <button class="carrousel-btn carrousel-next-temoignages" aria-label="Suivant">
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
        <div class="carrousel-track-temoignages" data-total-slides="<?php echo count($realisations_avec_temoignage); ?>">

            <?php
            $temoignage_count = 0;
            foreach ($realisations_avec_temoignage as $realisation_id):
                // Récupérer les champs
                $temoignage_texte = get_field('temoignage', $realisation_id);
                $logo = get_field('image_logo_realisation', $realisation_id);
                $titre_realisation = get_field('titre_realisation', $realisation_id) ?: get_the_title($realisation_id);

                // Récupérer la catégorie
                $categories = get_the_terms($realisation_id, 'categorie_realisation');
                $categorie = null;

                if ($categories && !is_wp_error($categories)) {
                    $categorie = reset($categories);
                }
            ?>

                <div class="temoignage-carte" data-slide="<?php echo $temoignage_count; ?>">

                    <div class="header-temoignage">
                        <?php if ($logo): ?>
                            <div class="temoignage-logo">
                                <img src="<?php echo esc_url($logo['url']); ?>"
                                    alt="<?php echo esc_attr($logo['alt'] ?: $titre_realisation); ?>"
                                    loading="lazy">
                            </div>
                        <?php endif; ?>

                        <?php if ($categorie): ?>
                            <div class="temoignage-badge">
                                <?php echo render_term_badge($categorie, 'categorie_realisation'); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Citation -->
                    <div class="temoignage-citation">
                        <p><?php echo nl2br(esc_html($temoignage_texte)); ?></p>
                    </div>

                    <div class="footer-temoignage">
                        <div class="info-temoignage"></div>

                        <div>
                            <?php echo render_button(array(
                                'type' => 'primary',
                                'url'  => get_permalink($realisation_id),
                                'text' => 'Voir la réalisation'
                            )); ?>
                        </div>
                    </div>

                </div>

            <?php
                $temoignage_count++;
            endforeach;
            ?>

        </div>
    </div>

    <!-- CTA Global -->
    <?php if ($slider_cta && !empty($slider_cta['texte']) && !empty($slider_cta['lien'])): ?>
        <div class="container">
            <div class="temoignages-cta-global">
                <?php echo render_button(array(
                    'type' => 'ghost',
                    'url'  => $slider_cta['lien'],
                    'text' => $slider_cta['texte']
                )); ?>
            </div>
        </div>
    <?php endif; ?>

</section>
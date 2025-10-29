<?php

/**
 * Composant : Mission List
 *
 * @package churchill
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Récupérer les champs
$chapo = get_sub_field('chapo');
$titre = get_sub_field('titre');
$background = get_sub_field('background');
$missions_ids = get_sub_field('missions');

if (!$missions_ids || empty($missions_ids)) return;
?>

<div class="missions-section missions-section--liste"
    <?php if ($background): ?>style="background-image: url(<?php echo esc_url($background); ?>);" <?php endif; ?>>
    <div class="container">
        <div class="row">

            <!-- Colonne Titre et Chapô -->
            <div class="col-12">
                <div class="title-heading">
                    <?php if ($chapo): ?>
                        <p class="missions-chapo"><?php echo esc_html($chapo); ?></p>
                    <?php endif; ?>

                    <?php if ($titre): ?>
                        <h2><?php echo display_colored_title($titre); ?></h2>
                    <?php endif; ?>
                </div>

                <!-- Image mobile uniquement (visible < 1200px) -->
                <?php if ($background): ?>
                    <div class="mission-image-mobile">
                        <img src="<?php echo esc_url($background); ?>" alt="<?php echo esc_attr($titre ?: 'Missions'); ?>">
                    </div>
                <?php endif; ?>
            </div>

            <!-- Grille de missions - 8 colonnes, 2 par ligne -->
            <div class="col-lg-8 col-md-12">
                <div class="row g-4">

                    <?php foreach ($missions_ids as $mission_id):
                        $titre_mission = get_field('titre_mission', $mission_id);
                        $description_mission = get_field('description_mission', $mission_id);
                        $lien_mission = get_field('lien_mission', $mission_id);
                        $image_mission = get_field('image_mission', $mission_id);

                        if (empty($titre_mission)) {
                            $titre_mission = get_the_title($mission_id);
                        }

                        if (empty($lien_mission) || (is_array($lien_mission) && empty($lien_mission['url']))) {
                            $lien_url = get_permalink($mission_id);
                            $lien_target = '';
                        } else {
                            $lien_url = is_array($lien_mission) ? $lien_mission['url'] : $lien_mission;
                            $lien_target = is_array($lien_mission) && !empty($lien_mission['target']) ? $lien_mission['target'] : '';
                        }
                    ?>

                        <div class="col-md-6 col-sm-12">
                            <article class="mission-card">
                                <div class="mission-header">
                                    <?php
                                    $icon_mission = get_field('icon_mission', $mission_id);
                                    if ($icon_mission):
                                    ?>
                                        <div class="mission-icon-circle">
                                            <?php if ($icon_mission['mime_type'] === 'image/svg+xml'): ?>

                                                <?php get_inline_svg($icon_mission, $titre_mission); ?>
                                            <?php else: ?>
                                                <img src="<?php echo esc_url($icon_mission['url']); ?>"
                                                    alt="<?php echo esc_attr($titre_mission); ?>"
                                                    loading="lazy">
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($titre_mission): ?>
                                        <h3 class="mission-titre"><?php echo esc_html($titre_mission); ?></h3>
                                    <?php endif; ?>
                                </div>

                                <div class="mission-body">
                                    <?php if ($description_mission): ?>
                                        <p class="mission-description">
                                            <?php echo nl2br(esc_html($description_mission)); ?>
                                        </p>
                                    <?php endif; ?>

                                    <?php if ($lien_url):
                                        echo render_button(array(
                                            'type'   => 'short',
                                            'url'    => esc_url($lien_url),
                                            'text'   => esc_attr($titre_mission) ?: '',
                                            'target' => !empty(esc_attr($lien_target)) ? esc_attr($lien_target) : '',
                                        ));
                                    endif; ?>
                                </div>
                            </article>
                        </div>

                    <?php endforeach; ?>

                </div>
            </div>

        </div>
    </div>
</div>
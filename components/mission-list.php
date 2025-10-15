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

<section class="missions-section" <?php if ($background): ?>style="background-image: url(<?php echo esc_url($background); ?>);" <?php endif; ?>>
    <div class="container">
        <div class="content-mission">

            <!-- Titre et Chapô -->
            <div class="title-heading">
                <?php if ($chapo): ?>
                    <p class="missions-chapo"><?php echo esc_html($chapo); ?></p>
                <?php endif; ?>

                <?php if ($titre): ?>
                    <h2 class="missions-titre">
                        <?php echo display_colored_title($titre); ?>
                    </h2>
                <?php endif; ?>
            </div>

            <!-- Image mobile uniquement (visible < 1200px) -->
            <?php if ($background): ?>
                <div class="mission-image-mobile">
                    <img src="<?php echo esc_url($background); ?>" alt="<?php echo esc_attr($titre ?: 'Missions'); ?>">
                </div>
            <?php endif; ?>

            <!-- Grille de missions -->
            <div class="missions-grid">
                <?php foreach ($missions_ids as $mission_id):
                    // Récupérer les champs ACF de la mission
                    $titre_mission = get_field('titre_mission', $mission_id);
                    $description_mission = get_field('description_mission', $mission_id);
                    $icon_mission = get_field('icon_mission', $mission_id);
                    $lien_mission = get_field('lien_mission', $mission_id);

                    // Fallback titre
                    if (empty($titre_mission)) {
                        $titre_mission = get_the_title($mission_id);
                    }

                    // Fallback lien
                    if (empty($lien_mission) || (is_array($lien_mission) && empty($lien_mission['url']))) {
                        $lien_url = get_permalink($mission_id);
                        $lien_target = '';
                    } else {
                        $lien_url = is_array($lien_mission) ? $lien_mission['url'] : $lien_mission;
                        $lien_target = is_array($lien_mission) && !empty($lien_mission['target']) ? $lien_mission['target'] : '';
                    }
                ?>
                    <article class="mission-card">
                        <div class="mission-header">
                            <!-- Icône dans un cercle -->
                            <div class="mission-icon-circle">
                                <?php if (!empty($icon_mission)): ?>
                                    <?php
                                    // Utiliser votre fonction helper
                                    if (function_exists('the_icon')) {
                                        the_icon($icon_mission);
                                    } else {
                                        // Fallback si la fonction n'existe pas
                                        echo '<i class="bi bi-check-circle"></i>';
                                    }
                                    ?>
                                <?php else: ?>
                                    <!-- Icône par défaut -->
                                    <i class="bi bi-check-circle"></i>
                                <?php endif; ?>
                            </div>

                            <!-- Titre -->
                            <?php if ($titre_mission): ?>
                                <h3 class="mission-titre"><?php echo esc_html($titre_mission); ?></h3>
                            <?php endif; ?>
                        </div>

                        <div class="mission-body">
                            <!-- Description -->
                            <?php if ($description_mission): ?>
                                <p class="mission-description">
                                    <?php echo esc_html($description_mission); ?>
                                </p>
                            <?php endif; ?>

                            <!-- Bouton CTA -->
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
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</section>
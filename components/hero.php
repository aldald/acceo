<?php

/**
 * Composant : Hero
 *
 * @package churchill
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Récupérer les champs
$titre_composant = get_sub_field('titre_composant');
$texte_composant = get_sub_field('texte_composant');
$cta = get_sub_field('cta_composant');
$image_video_illustration = get_sub_field('image_video_dillustration');
$image_video_fond = get_sub_field('image_video_de_fond');

// Préparer le style inline pour le background
$background_style = '';
if ($image_video_fond && !empty($image_video_fond['type'])) {
    if ($image_video_fond['type'] === 'image' && !empty($image_video_fond['image'])) {
        $background_style = 'style="background-image: url(\'' . esc_url($image_video_fond['image']['url']) . '\');"';
    }
}

?>

<!-- Hero Component -->
<div class="hero-wrapper" <?php echo $background_style; ?>>
    
    <?php if ($image_video_fond && $image_video_fond['type'] === 'video' && !empty($image_video_fond['video'])): ?>
        <div class="hero-background-video">
            <video class="hero-bg-video" autoplay muted loop playsinline>
                <source src="<?php echo esc_url($image_video_fond['video']['url']); ?>" type="video/mp4">
            </video>
        </div>
    <?php endif; ?>

    <div class="container">
        <div class="row">
            
            <!-- Colonne Contenu (Texte + CTA) - 5 colonnes -->
            <div class="col-lg-5 col-md-12">
                <div class="hero-content">
                    
                    <?php if ($titre_composant): ?>
                        <h1 class="hero-title">
                            <?php echo display_colored_title($titre_composant); ?>
                        </h1>
                    <?php endif; ?>

                    <?php if ($texte_composant): ?>
                        <div class="hero-text">
                            <?php echo wp_kses_post(wpautop($texte_composant)); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($cta && !empty($cta['url'])): ?>
                        <div class="hero-cta">
                            <?php
                            echo render_button(array(
                                'type'   => 'primary',
                                'url'    => esc_url($cta['url']),
                                'text'   => esc_html($cta['title']),
                                'target' => !empty($cta['target']) ? $cta['target'] : '',
                            ));
                            ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

            <!-- Colonne Image/Vidéo d'illustration - 6 colonnes avec offset de 1 -->
            <div class="col-lg-6 offset-lg-1 col-md-12">
                <div class="hero-media">
                    
                    <?php if ($image_video_illustration && !empty($image_video_illustration['type'])): ?>
                        
                        <?php if ($image_video_illustration['type'] === 'image' && !empty($image_video_illustration['image'])): ?>
                            <div class="hero-image-wrapper">
                                <img src="<?php echo esc_url($image_video_illustration['image']['url']); ?>" 
                                     alt="<?php echo esc_attr($image_video_illustration['image']['alt']); ?>" 
                                     class="hero-illustration">
                            </div>
                        
                        <?php elseif ($image_video_illustration['type'] === 'video' && !empty($image_video_illustration['video'])): ?>
                            <div class="hero-video-wrapper">
                                <?php
                                // Utiliser le shortcode modal_video si miniature disponible
                                if (!empty($image_video_illustration['video']['url']) && !empty($image_video_illustration['miniature']['url'])) {
                                    echo do_shortcode('[modal_video url="' . esc_url($image_video_illustration['video']['url']) . '" image="' . esc_url($image_video_illustration['miniature']['url']) . '"]');
                                } else {
                                    // Vidéo inline si pas de miniature
                                    ?>
                                    <video class="hero-video" controls>
                                        <source src="<?php echo esc_url($image_video_illustration['video']['url']); ?>" type="video/mp4">
                                    </video>
                                    <?php
                                }
                                ?>
                            </div>
                        
                        <?php endif; ?>
                        
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>

</div>
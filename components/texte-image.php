<?php
/**
 * Composant : Texte / Image
 *
 * @package churchill
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Récupérer les champs
$titre = get_sub_field('titre');
$texte_element = get_sub_field('texte_element');
$image_element = get_sub_field('image_element');
$position_image = get_sub_field('position_image') ?: 'droite';

// Vérifier que l'image existe
if (!$image_element) return;

// Classes conditionnelles selon la position
if ($position_image === 'gauche') {
    // Image à gauche : Image (1) → Offset (2) → Texte (3)
    $order_image = 'order-lg-1';
    $order_offset = 'order-lg-2';
    $order_text = 'order-lg-3';
} else {
    // Image à droite : Texte (1) → Offset (2) → Image (3)
    $order_text = 'order-lg-1';
    $order_offset = 'order-lg-2';
    $order_image = 'order-lg-3';
}
?>

<div class="texte-image-wrapper texte-image--<?php echo esc_attr($position_image); ?>">
    <div class="container">
        <div class="row align-items-center">

            <!-- Colonne Texte - 5 colonnes -->
            <div class="col-lg-5 col-md-12 <?php echo esc_attr($order_text); ?>">
                <div class="texte-image-content">

                    <?php if ($titre): ?>
                        <div class="title-heading">
                            <h2><?php echo display_colored_title($titre); ?></h2>
                        </div>
                    <?php endif; ?>

                    <?php if ($texte_element): ?>
                        <div class="texte-image-texte">
                            <?php echo wp_kses_post($texte_element); ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

            <!-- Offset - 1 colonne (toujours entre texte et image) -->
            <div class="col-lg-1 d-none d-lg-block <?php echo esc_attr($order_offset); ?>"></div>

            <!-- Colonne Image - 6 colonnes -->
            <div class="col-lg-6 col-md-12 <?php echo esc_attr($order_image); ?>">
                <div class="texte-image-media">
                    <img src="<?php echo esc_url($image_element['url']); ?>"
                         alt="<?php echo esc_attr($image_element['alt'] ?: strip_tags($titre)); ?>"
                         loading="lazy">
                </div>
            </div>

        </div>
    </div>
</div>
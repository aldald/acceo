<?php

/**
 * Composant Bandeau Contact
 * 
 * Affiche un bandeau avec titre, texte, CTA et grille d'images 3x2
 *
 * @package churchill
 */
defined('ABSPATH') || exit;

$titre_composant = get_sub_field('titre_composant');
$texte_element = get_sub_field('texte_element');
$cta_element = get_sub_field('cta_element');
$images_element = get_sub_field('images_element');

// Vérifier qu'on a au moins le titre ou du contenu
if (!$titre_composant && !$texte_element) {
    return;
}
?>

<section class="bandeau-contact">
    <div class="container">
        <div class="bandeau-contact-wrapper">

            <!-- Colonne gauche : Contenu -->
            <div class="bandeau-contact-content">

                <?php if ($titre_composant) : ?>
                    <h2 class="bandeau-contact-title">
                        <?php echo display_colored_title($titre_composant); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($texte_element) : ?>
                    <p class="bandeau-contact-text">
                        <?php echo nl2br(esc_html($texte_element)); ?>
                    </p>
                <?php endif; ?>

                <?php if ($cta_element && !empty($cta_element['url'])) :
                    echo render_button(array(
                        'type'   => 'primary',
                        'url'    => esc_url($cta_element['url']),
                        'text'   => esc_html($cta_element['title'] ?: 'Nous contacter'),
                        'target' => '',
                    ));
                endif; ?>

            </div>

            <!-- Colonne droite : Grille d'images 3x2 -->
            <?php if ($images_element && count($images_element) >= 6) : ?>
                <div class="bandeau-contact-images">
                    <div class="image-grid">
                        <?php foreach (array_slice($images_element, 0, 6) as $index => $image) : ?>
                            <div class="image-item image-item-<?php echo $index + 1; ?>">
                                <img src="<?php echo esc_url($image['url']); ?>"
                                    alt="<?php echo esc_attr($image['alt'] ?: 'Image contact'); ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>
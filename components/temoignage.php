<?php

/**
 * Composant : Témoignage
 * Affiche un témoignage avec photo (Layout offset gauche + colonnes décalées)
 *
 * @package churchill
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Récupérer les champs ACF
$titre = get_sub_field('titre');
$nom = get_sub_field('nom');
$fonction = get_sub_field('fonction');
$contenu = get_sub_field('contenu');
$image = get_sub_field('image');

// Si pas de contenu, ne rien afficher
if (empty($nom) || empty($contenu) || empty($image)) {
    return;
}
?>

<div class="temoignage-composant">
    <div class="container">
        <div class="row align-items-center">

            <div class="col-lg-5 offset-lg-1 col-md-12">
                <div class="temoignage-content">
                    <div class="title-heading">
                        <?php if ($titre): ?>

                            <h2><?php echo display_colored_title($titre); ?></h2>
                        <?php endif; ?>
                    </div>

                    <div class="temoignage-auteur">
                        <h5 class="auteur-nom"><?php echo esc_html($nom); ?></h5>
                        <?php if ($fonction): ?>
                            <p class="auteur-fonction"><?php echo esc_html($fonction); ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="temoignage-texte">
                        <?php echo wp_kses_post($contenu); ?>
                    </div>

                </div>
            </div>

            <div class="offset-lg-1 col-lg-4 col-md-12">
                <div class="temoignage-image">
                    <img src="<?php echo esc_url($image['url']); ?>"
                        alt="<?php echo esc_attr($image['alt'] ?: $nom); ?>"
                        loading="lazy">
                </div>
            </div>

        </div>
    </div>
</div>
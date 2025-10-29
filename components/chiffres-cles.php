<?php

/**
 * Composant : Chiffres Clés
 *
 * @package churchill
 */

defined('ABSPATH') || exit;

$titre = get_sub_field('titre');
$contenu = get_sub_field('contenu');
$cards = get_sub_field('cards');

if (!$cards || empty($cards)) return;
?>

<div class="chiffres-cles-section">
    <div class="container">
        <div class="row align-items-start">

            <!-- Colonne gauche : Titre + Contenu - 3 colonnes -->
            <div class="col-lg-3 col-md-12">
                <div class="chiffres-content">

                    <?php if ($titre): ?>
                        <div class="title-heading">
                            <h2><?php echo display_colored_title($titre); ?></h2>
                        </div>
                    <?php endif; ?>

                    <?php if ($contenu): ?>
                        <div class="chiffres-texte">
                            <?php echo wp_kses_post($contenu); ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

            <!-- Colonne droite : Grille de cards - 8 colonnes avec offset de 1 -->
            <div class="col-lg-8 offset-lg-1 col-md-12">
                <div class="chiffres-cards-grid">
                    <div class="row">

                        <?php foreach ($cards as $index => $card): ?>

                            <!-- CARD : Chiffre clé - 6 colonnes -->
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="chiffres-card chiffres-card-chiffre" data-card-index="<?php echo $index; ?>">

                                    <?php if (!empty($card['icone'])):
                                        $icone = $card['icone'];
                                    ?>
                                        <div class="card-icon">
                                            <?php if ($icone['mime_type'] === 'image/svg+xml'): ?>
                                                <?php get_inline_svg($icone, $card['label']); ?>
                                            <?php else: ?>
                                                <img src="<?php echo esc_url($icone['url']); ?>"
                                                    alt="<?php echo esc_attr($card['label']); ?>"
                                                    loading="lazy">
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>

                                    <div class="number-text">
                                        <div class="card-chiffre"
                                            data-target="<?php echo esc_attr($card['chiffre']); ?>"
                                            data-counter>
                                            0
                                        </div>

                                        <?php if (!empty($card['label'])): ?>
                                            <div class="card-label">
                                                <?php echo esc_html($card['label']); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
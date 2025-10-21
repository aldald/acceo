<?php
/**
 * Composant : FAQ
 *
 * @package churchill
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Récupérer les champs
$faq_titre = get_sub_field('faq_titre') ?: 'Questions [blue]fréquentes[/blue]';
$faq_description = get_sub_field('faq_description');
$faq_image = get_sub_field('faq_image');
$faq_background_image = get_sub_field('faq_background_image');
$faq_bouton = get_sub_field('faq_bouton');
$faq_questions_ids = get_sub_field('faq_questions');

// Si pas de questions, ne rien afficher
if (!$faq_questions_ids || empty($faq_questions_ids)) return;
?>

<!-- Section FAQ -->
<section class="faq-section-modern" style="background-image: url('<?php echo esc_url($faq_background_image['url']) ?>'),url('<?php echo esc_url($faq_image['url']) ?>');">
    <div class="container">
        <div class="row align-items-start">

            <!-- Colonne de gauche : Infos - 4 colonnes -->
            <div class="col-lg-4 col-md-12">
                <div class="title-heading">

                    <h2 class="">
                        <?php echo display_colored_title($faq_titre); ?>
                    </h2>

                    <?php if ($faq_description): ?>
                        <div class="faq-description-modern">
                            <?php echo nl2br(esc_html($faq_description)); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($faq_bouton && $faq_bouton['texte'] && $faq_bouton['url']): ?>
                        <div class="faq-cta-modern">
                            <?php echo render_button(array(
                                'type' => 'primary',
                                'url'  => $faq_bouton['url'],
                                'text' => $faq_bouton['texte']
                            )); ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

            <!-- Colonne de droite : Questions - 7 colonnes avec offset de 1 -->
            <div class="col-lg-7 offset-lg-1 col-md-12">
                <div class="faq-questions-modern">

                    <div class="faq-accordion-modern">
                        <?php foreach ($faq_questions_ids as $index => $faq_id):
                            // Récupérer les données de la question
                            $question = get_field('question', $faq_id);
                            $reponse = get_field('reponse', $faq_id);

                            // Récupérer la catégorie
                            $categories = get_the_terms($faq_id, 'categorie_faq');
                            $categorie = null;

                            if ($categories && !is_wp_error($categories)) {
                                $categorie = reset($categories);
                            }
                        ?>

                            <div class="faq-item-modern" data-faq-item="<?php echo $index; ?>">

                                <button class="faq-question-modern"
                                    data-faq-toggle="<?php echo $index; ?>"
                                    aria-expanded="false"
                                    aria-controls="faq-answer-<?php echo $index; ?>">

                                    <div class="faq-question-content">
                                        <!-- Badge catégorie (centralisé) -->
                                        <?php if ($categorie): ?>
                                            <div class="temoignage-badge">
                                                <?php echo render_term_badge($categorie, 'categorie_faq'); ?>
                                            </div>
                                        <?php endif; ?>

                                        <div class="faq-question-text-modern"><?php echo esc_html($question); ?></div>
                                    </div>

                                    <span class="faq-toggle-icon-modern">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <path class="faq-plus-horizontal" d="M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                            <path class="faq-plus-vertical" d="M12 5V19" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                        </svg>
                                    </span>

                                </button>

                                <div class="faq-answer-modern"
                                    id="faq-answer-<?php echo $index; ?>"
                                    aria-labelledby="faq-question-<?php echo $index; ?>">
                                    <div class="faq-answer-content-modern">
                                        <?php echo nl2br(esc_html($reponse)); ?>
                                    </div>
                                </div>

                            </div>

                        <?php endforeach; ?>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
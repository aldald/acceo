<?php

/**
 * Render Actualité Cards
 * Génère le HTML des cartes actualités (hero et card)
 *
 * @package churchill
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Render Article Hero (grand article)
 *
 * @param int $post_id ID de l'article
 * @return string HTML de la carte hero
 */
function render_actualite_hero($post_id)
{
    if (!$post_id) return '';

    $post = get_post($post_id);
    if (!$post) return '';

    $primary_category = get_post_primary_category($post_id, 'category');
    $reading_time = get_reading_time($post);
    $author_id = $post->post_author;

    ob_start();
?>
    <article class="actualite-hero">
        <div class="row g-0 align-items-stretch">

            <!-- Image - 6 colonnes -->
            <?php if (has_post_thumbnail($post_id)): ?>
                <div class="col-lg-6 col-md-12">
                    <div class="actualite-hero-image">
                        <a href="<?php echo get_permalink($post_id); ?>">
                            <?php echo get_the_post_thumbnail($post_id, 'large'); ?>
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Contenu - 6 colonnes -->
            <div class="col-lg-6 col-md-12">
                <div class="actualite-hero-content">

                    <div class="blog-card-badge-wrapper">
                        <!-- Badge catégorie (centralisé) -->
                        <?php if ($primary_category && isset($primary_category['primary_category'])): ?>
                            <div class="blog-card-badge">
                                <?php echo render_term_badge($primary_category['primary_category']); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Temps de lecture -->
                        <div class="blog-reading-time">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <polyline points="12 6 12 12 16 14" />
                            </svg>
                            <?php printf(__('%d min de lecture', 'churchill'), $reading_time); ?>
                        </div>
                    </div>

                    <!-- Titre -->
                    <h2 class="actualite-hero-title">
                        <a href="<?php echo get_permalink($post_id); ?>">
                            <?php echo get_the_title($post_id); ?>
                        </a>
                    </h2>

                    <!-- Extrait -->
                    <div class="actualite-hero-excerpt">
                        <?php echo excerpt(30, $post_id); ?>
                    </div>

                    <!-- Auteur -->
                    <div class="blog-card-meta">
                        <div class="blog-card-author">
                            <?php echo get_avatar($author_id, 40); ?>

                            <div class="blog-author-info">
                                <span class="blog-author-name"><?php echo get_the_author_meta('display_name', $author_id); ?></span>
                                <span class="blog-author-date"><?php echo get_the_date('d F Y', $post_id); ?></span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </article>
<?php
    return ob_get_clean();
}

/**
 * Render Article Card (petite card)
 *
 * @param int $post_id ID de l'article
 * @return string HTML de la carte
 */
function render_actualite_card($post_id)
{
    if (!$post_id) return '';

    $post = get_post($post_id);
    if (!$post) return '';

    $primary_category = get_post_primary_category($post_id, 'category');
    $reading_time = get_reading_time($post);

    ob_start();
?>
    <article class="blog-card">

        <!-- Image -->
        <?php if (has_post_thumbnail($post_id)): ?>
            <div class="blog-card-image">
                <a href="<?php echo get_permalink($post_id); ?>">
                    <?php echo get_the_post_thumbnail($post_id, 'rectangle_398_224'); ?>
                </a>
            </div>
        <?php endif; ?>

        <!-- Contenu -->
        <div class="blog-card-content">

            <div class="blog-card-badge-wrapper">
                <!-- Badge catégorie (centralisé) -->
                <?php if ($primary_category && isset($primary_category['primary_category'])): ?>
                    <div class="blog-card-badge">
                        <?php echo render_term_badge($primary_category['primary_category']); ?>
                    </div>
                <?php endif; ?>

                <!-- Temps de lecture -->
                <div class="blog-reading-time">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                    <?php printf(__('%d min de lecture', 'churchill'), $reading_time); ?>
                </div>
            </div>

            <!-- Titre -->
            <h3 class="blog-card-title">
                <a href="<?php echo get_permalink($post_id); ?>">
                    <?php echo get_the_title($post_id); ?>
                </a>
            </h3>

        </div>
    </article>
<?php
    return ob_get_clean();
}

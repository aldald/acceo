<?php
/**
 * Template for single post (article)
 *
 * @package churchill
 */
defined('ABSPATH') || exit;

get_header();

// Récupérer les infos de l'article
$post_id = get_the_ID();
$primary_category = get_post_primary_category($post_id, 'category');
$reading_time = get_reading_time($post);
?>

<main id="main-content" class="single-actualite-page">

    <?php while (have_posts()) : the_post(); ?>

        <!-- Section Header Article -->
        <article class="single-article-header">
            <div class="container">

                <!-- Breadcrumb -->
                <?php if (function_exists('wps_yoast_breadcrumb_bootstrap')): ?>
                    <div class="breadcrumb-wrapper">
                        <?php wps_yoast_breadcrumb_bootstrap(); ?>
                    </div>
                <?php endif; ?>

                <!-- Badge catégorie + Titre -->
                <div class="single-article-title-wrapper">
                    
                    <!-- Badge catégorie -->
                    <?php if ($primary_category && isset($primary_category['primary_category'])): ?>
                        <div class="blog-card-badge">
                            <?php echo render_term_badge($primary_category['primary_category']); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Titre de l'article -->
                    <h1 class="single-article-title">
                        <?php the_title(); ?>
                    </h1>

                </div>

                <!-- Meta : Auteur + Date + Temps de lecture -->
                <div class="single-article-meta">
                    <div class="blog-card-author">
                        <?php echo get_avatar(get_the_author_meta('ID'), 40); ?>

                        <div class="blog-author-info">
                            <span class="blog-author-name"><?php echo get_the_author(); ?></span>
                            <span class="blog-author-date"><?php echo get_the_date('d F Y'); ?></span>
                        </div>
                    </div>

                    <!-- Temps de lecture -->
                    <div class="blog-reading-time">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <polyline points="12 6 12 12 16 14" />
                        </svg>
                        <?php printf(__('%d min de lecture', 'churchill'), $reading_time); ?>
                    </div>
                </div>

            </div>

            <!-- Image à la une (Hero) -->
            <?php if (has_post_thumbnail()): ?>
                <div class="single-article-featured-image">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>

        </article>

        <!-- Section Contenu Article -->
        <article class="single-article-content">
            <div class="container">
                <div class="content-wrapper">
                    
                    <!-- Contenu principal de l'article -->
                    <div class="article-body">
                        <?php the_content(); ?>
                    </div>

                    <!-- Tags de l'article -->
                    <?php if (has_tag()): ?>
                        <div class="article-tags">
                            <?php the_tags('<span class="tags-label">Tags :</span> ', ', '); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Partage social (optionnel) -->
                    <div class="article-share">
                        <!-- Vos boutons de partage si vous en avez -->
                    </div>

                </div>
            </div>
        </article>

        <!-- Section Articles suggérés -->
        <?php
        // Récupérer 3 articles similaires de la même catégorie
        $related_args = array(
            'post_type' => 'post',
            'posts_per_page' => 3,
            'post__not_in' => array($post_id),
            'orderby' => 'rand'
        );

        if ($primary_category && isset($primary_category['primary_category'])) {
            $related_args['cat'] = $primary_category['primary_category']->term_id;
        }

        $related_posts = get_posts($related_args);

        if ($related_posts):
        ?>
            <section class="related-articles-section">
                <div class="container">
                    
                    <h2 class="related-title">
                        <?php echo display_colored_title("D'autres sujets qui pourraient vous [blue]intéresser[/blue]"); ?>
                    </h2>

                    <div class="actualites-grid">
                        <?php foreach ($related_posts as $related_post): ?>
                            <div class="actualites-grid-item">
                                <?php echo render_actualite_card($related_post->ID); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Lien "Voir tous les articles" -->
                    <div class="related-cta">
                        <?php
                        echo render_button(array(
                            'type' => 'ghost',
                            'url'  => get_permalink(get_option('page_for_posts')), // Page blog
                            'text' => 'Voir tous nos conseils'
                        ));
                        ?>
                    </div>

                </div>
            </section>
        <?php endif; ?>

    <?php endwhile; ?>

</main>

<?php
get_footer();
?>
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
    <div class="container">
        <!-- Breadcrumb -->
        <?php if (function_exists('wps_yoast_breadcrumb_bootstrap')): ?>
            <div class="breadcrumb-wrapper">
                <?php wps_yoast_breadcrumb_bootstrap(); ?>
            </div>
        <?php endif; ?>

        <?php while (have_posts()) : the_post(); ?>

            <!-- Section Header Article -->
            <div class="actualites-hero-wrapper">

                <?php echo render_actualite_hero($post_id); ?>


            </div>
    </div>

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
    <?php
            get_template_part('template-parts/builder', '', array(
                'context' => 'blog_composant'
            ));
    ?>
<?php endwhile; ?>

</main>

<?php
get_footer();
?>
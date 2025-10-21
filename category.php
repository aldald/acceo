<?php

/**
 * Template for Category Archive
 * Design identique à template-actualites-liste.php
 *
 * @package churchill
 */
defined('ABSPATH') || exit;

get_header();

// Récupérer la catégorie courante
$queried_object = get_queried_object();
$current_category = $queried_object->term_id;
?>

<main id="main-content" class="actualites-page">

    <section class="actualites-section">
        <div class="container">

            <!-- Header -->
            <div class="title-heading">
                <?php if (function_exists('wps_yoast_breadcrumb_bootstrap')): ?>
                    <div class="breadcrumb-wrapper">
                        <?php wps_yoast_breadcrumb_bootstrap(); ?>
                    </div>
                <?php endif; ?>

                <!-- Titre de la page avec support des couleurs -->
                <?php
                // Si un titre coloré est défini dans ACF, l'utiliser, sinon utiliser le titre de la catégorie
                $titre_colore = get_field('titre_page_colore', 'category_' . $current_category);
                if ($titre_colore) {
                    echo '<h1>' . display_colored_title($titre_colore) . '</h1>';
                } else {
                    echo '<h1>' . single_cat_title('', false) . '</h1>';
                }
                ?>

                <?php if (category_description()): ?>
                    <div class="actualites-chapo">
                        <?php echo category_description(); ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php
            // Récupérer toutes les catégories
            $categories = get_categories(array(
                'taxonomy' => 'category',
                'hide_empty' => true,
                'orderby' => 'name',
                'order' => 'ASC'
            ));

            // Arguments de la requête
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $args = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => 9, // 1 hero + 8 dans la grille
                'paged' => $paged,
                'orderby' => 'date',
                'order' => 'DESC',
                'cat' => $current_category // Toujours filtré par la catégorie courante
            );

            $actualites_query = new WP_Query($args);
            ?>

            <?php if ($actualites_query->have_posts()): ?>

                <!-- Grid : 1 article hero + grille d'articles -->
                <?php
                $article_index = 0;
                $hero_article_id = null;
                $grid_articles = array();

                // Séparer le premier article (hero) des autres
                while ($actualites_query->have_posts()):
                    $actualites_query->the_post();

                    if ($article_index === 0 && $paged === 1) {
                        // Premier article = Hero (seulement sur la première page)
                        $hero_article_id = get_the_ID();
                    } else {
                        // Autres articles = Grille
                        $grid_articles[] = get_the_ID();
                    }

                    $article_index++;
                endwhile;
                wp_reset_postdata();
                ?>

                <!-- Article Hero (première page uniquement) -->
                <?php if ($hero_article_id && $paged === 1): ?>
                    <div class="actualites-hero-wrapper">
                        <?php echo render_actualite_hero($hero_article_id); ?>
                    </div>
                <?php endif; ?>

                <!-- Filtres par catégorie -->
                <?php if ($categories && count($categories) > 1): ?>
                    <div class="actualites-filters">
                        <div class="filters-title">
                            <!-- Titre avec couleurs -->
                            <h2><?php echo display_colored_title('Rechercher par [blue]thématique[/blue]'); ?></h2>
                        </div>
                        <div class="filters-wrapper">
                            <a href="<?php echo get_post_type_archive_link('post'); ?>"
                                class="filter-btn <?php echo ($current_category === 0) ? 'active' : ''; ?>">
                                <?php _e('Tous les sujets', 'churchill'); ?>
                            </a>
                            <?php foreach ($categories as $category): ?>
                                <a href="<?php echo get_term_link($category->term_id); ?>"
                                    class="filter-btn <?php echo ($current_category === $category->term_id) ? 'active' : ''; ?>">
                                    <?php echo esc_html($category->name); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Grille d'articles (Bootstrap Grid) -->
                <?php if (!empty($grid_articles)): ?>
                    <div class="row g-4">
                        <?php foreach ($grid_articles as $article_id): ?>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="actualites-grid-item">
                                    <?php echo render_actualite_card($article_id); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Pagination -->
                <?php if ($actualites_query->max_num_pages > 1): ?>
                    <div class="actualites-pagination">
                        <?php pagination($actualites_query->max_num_pages); ?>
                    </div>
                <?php endif; ?>

            <?php else: ?>

                <!-- Message si aucun article -->
                <div class="actualites-no-results">
                    <p><?php _e('Aucune actualité pour le moment.', 'churchill'); ?></p>
                </div>

            <?php endif; ?>

        </div>
    </section>
    <?php
    get_template_part('template-parts/builder', '', array(
        'context' => 'blog_category_composant'
    ));
    ?>
</main>



<?php
get_footer();
?>
<?php
/**
 * Default search resuts template
 *
 * @package churchill
 */
// Exit if accessed directly.
defined('ABSPATH') || exit;
?>
<?php
get_header();
?>
    <section id="blog-header" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1 d-flex text-center text-md-start justify-content-center justify-content-md-start align-items-center">
                    <div>
                        <?php wps_yoast_breadcrumb_bootstrap()?>
                        <h1 class="m-md-0">
                            <?php _e("Résultat de la recherche pour :")?> <span class="text-primary"><?php echo get_search_query();?></span>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="blog-posts">
        <div class="container">
            <div>
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="row">
                            <?php if(have_posts()):?>
                                <?php while(have_posts()):?>
                                    <?php the_post();?>
                                    <div class="col-md-4">
                                        <article class="position-relative mb-5">
                                            <div class="thumbnail-container">
                                                <?php the_post_thumbnail("rectangle_398_224")?>
                                            </div>
                                            <h2>
                                                <?php the_title()?>
                                            </h2>
                                            <?php echo excerpt(20);?>
                                            <a href="<?php the_permalink()?>" class="stretched-link">
                                                <?php _e("Lire l’article")?>
                                                <i class="bi bi-arrow-right-short"></i>
                                            </a>
                                        </article>
                                    </div>
                                <?php endwhile;?>
                                <?php else:?>
                                    <h2 class="text-center">
                                        <?php _e("Aucun résultat ne correspond à votre recherche")?>
                                    </h2>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="pagination" class="py-5">
        <div class="container d-flex justify-content-center">
            <?php pagination();?>
        </div>
    </section>
<?php get_footer(); ?>
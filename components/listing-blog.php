<?php
/**
 * Composant Listing Blog
 *
 * @package churchill
 */
defined('ABSPATH') || exit;

$blog_titre = get_sub_field('blog_titre');
$blog_chapo = get_sub_field('blog_chapo');
$blog_mode = get_sub_field('blog_mode_selection') ?: 'auto';
$blog_cta = get_sub_field('blog_cta');

if ($blog_mode === 'manuel') {
    $articles_ids = get_sub_field('blog_selecteur_articles');
} else {
    $recent_posts = get_posts(array(
        'numberposts' => 3,
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC'
    ));
    $articles_ids = wp_list_pluck($recent_posts, 'ID');
}

if ($articles_ids && count($articles_ids) >= 3) :
?>

    <section class="blog-section">
        <div class="container">

            <!-- Header -->
            <div class="title-heading">
                <?php if ($blog_titre) : ?>
                    <h2>
                        <?php echo display_colored_title($blog_titre); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($blog_chapo) : ?>
                    <p class="blog-chapo"><?php echo esc_html($blog_chapo); ?></p>
                <?php endif; ?>
            </div>
            
            <div class="blog-grid">

                <div class="blog-article-main">
                    <?php echo render_blog_card($articles_ids[0]); ?>
                </div>

                <div class="blog-articles-secondary">
                    <?php echo render_blog_card($articles_ids[1]); ?>
                    <?php echo render_blog_card($articles_ids[2]); ?>
                </div>

            </div>

            <!-- CTA Global -->
            <?php if ($blog_cta && !empty($blog_cta['texte']) && !empty($blog_cta['lien'])) : ?>
                <div class="blog-cta-global">

                    <?php
                        echo render_button(array(
                            'type'   => 'ghost',
                            'url'    => esc_url($blog_cta['lien']),
                            'text'   => esc_html($blog_cta['texte']) ?: '',
                            'target' => '',
                        ));
                        ?>

                    
                </div>
            <?php endif; ?>

        </div>
    </section>

<?php
endif;
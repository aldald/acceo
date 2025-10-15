<?php
/**
 * Render Blog Card
 * Génère le HTML d'une carte article de blog
 *
 * @package churchill
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Render une carte article de blog
 *
 * @param int $post_id ID de l'article
 * @return string HTML de la carte
 */
function render_blog_card($post_id)
{
    if (!$post_id) return '';

    $post = get_post($post_id);
    if (!$post) return '';

    // Données de l'article
    $thumbnail = get_the_post_thumbnail_url($post_id, 'large');
    $categories = get_the_category($post_id);
    $author_id = $post->post_author;
    $author_name = get_the_author_meta('display_name', $author_id);
    $author_avatar = get_avatar_url($author_id, array('size' => 80));
    $post_date = get_the_date('d M Y', $post_id);
    $reading_time = get_reading_time($post_id);

    // Récupérer la première catégorie
    $primary_category = null;
    if (!empty($categories)) {
        $primary_category = $categories[0];
    }

    ob_start();
?>

    <article class="blog-card">

        <!-- Image -->
        <div class="blog-card-image">
            <?php if ($thumbnail) : ?>
                <img src="<?php echo esc_url($thumbnail); ?>"
                    alt="<?php echo esc_attr($post->post_title); ?>"
                    loading="lazy">
            <?php else : ?>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/placeholder-blog.jpg"
                    alt="<?php echo esc_attr($post->post_title); ?>">
            <?php endif; ?>
        </div>

        <!-- Contenu -->
        <div class="blog-card-content">

            <div class="top-content">
                <!-- Badge catégorie (centralisé) -->
                <?php if ($primary_category) : ?>
                    <div class="blog-card-badge">
                        <?php echo render_term_badge($primary_category); ?>
                    </div>
                <?php endif; ?>

                <!-- Temps de lecture -->
                <div class="blog-reading-time">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" />
                        <path d="M12 6v6l4 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                    <span><?php echo esc_html($reading_time); ?> min de lecture</span>
                </div>
            </div>

            <!-- Titre -->
            <h3 class="blog-card-title">
                <a href="<?php echo esc_url(get_permalink($post_id)); ?>">
                    <?php echo esc_html($post->post_title); ?>
                </a>
            </h3>

            <!-- Meta : Auteur -->
            <div class="blog-card-meta">
                <div class="blog-card-author">
                    <img src="<?php echo esc_url($author_avatar); ?>"
                        alt="<?php echo esc_attr($author_name); ?>"
                        class="blog-author-avatar">

                    <div class="blog-author-info">
                        <span class="blog-author-name"><?php echo esc_html($author_name); ?></span>
                        <span class="blog-author-date"><?php echo esc_html($post_date); ?></span>
                    </div>
                </div>
            </div>

        </div>

    </article>

<?php
    return ob_get_clean();
}
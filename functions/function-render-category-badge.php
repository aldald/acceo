<?php
/**
 * Render Category Badge Helper
 * Fonction helper pour générer des badges de catégories unifiés
 *
 * @package churchill
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Render un badge de catégorie unifié
 *
 * @param array $args {
 *     Arguments du badge
 *
 *     @type string $text   Texte du badge (nom de la catégorie). Required.
 *     @type string $color  Couleur du badge en hexadécimal. Default '#2E76B8'.
 *     @type string $class  Classes CSS additionnelles. Default ''.
 *     @type bool   $icon   Afficher l'icône triangle. Default true.
 * }
 * @return string HTML du badge
 */
function render_category_badge($args = array())
{
    // Arguments par défaut
    $defaults = array(
        'text'  => '',
        'color' => '#2E76B8',
        'class' => '',
        'icon'  => true,
    );

    $args = wp_parse_args($args, $defaults);

    // Si pas de texte, ne rien afficher
    if (empty($args['text'])) {
        return '';
    }

    // Nettoyer les attributs
    $text = esc_html($args['text']);
    $color = esc_attr($args['color']);
    $extra_class = $args['class'] ? ' ' . sanitize_html_class($args['class']) : '';
    $show_icon = (bool) $args['icon'];

    // Construction du HTML
    ob_start();
?>
    <span class="amo-span<?php echo $extra_class; ?>" style="background: <?php echo $color; ?>; border: 1px solid <?php echo $color; ?>;">
        <?php if ($show_icon) : ?>
            <div class="icon-container">
                <svg class="triangle-icon" style="fill: <?php echo $color; ?>;" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.96265 -9.53674e-07V3.58634L9.31288 10.5271H10.9999L5.96265 -9.53674e-07Z" fill="<?php echo $color; ?>"></path>
                    <path d="M5.73077 3.58639V4.19617e-05L0 11.8137L2.45274 10.3601L5.73077 3.58639Z" fill="<?php echo $color; ?>"></path>
                    <path d="M2.5946 10.541L0.132812 12L5.84751 11.9999L6.77442 11.2705L5.84751 10.541H2.5946Z" fill="<?php echo $color; ?>"></path>
                </svg>
            </div>
        <?php endif; ?>
        <span class="span-text"><?php echo $text; ?></span>
    </span>
<?php
    return ob_get_clean();
}

/**
 * Affiche directement un badge
 *
 * @param array $args Arguments du badge (voir render_category_badge)
 */
function the_category_badge($args = array())
{
    echo render_category_badge($args);
}

/**
 * Récupère et affiche un badge depuis un term (catégorie)
 *
 * @param int|WP_Term $term Term ID ou objet WP_Term
 * @param string $taxonomy Nom de la taxonomie (pour récupérer la couleur)
 * @return string HTML du badge
 */
function render_term_badge($term, $taxonomy = '')
{
    // Si c'est un ID, récupérer l'objet term
    if (is_numeric($term)) {
        $term = get_term($term, $taxonomy);
    }

    if (!$term || is_wp_error($term)) {
        return '';
    }

    // Récupérer la couleur personnalisée (champ ACF 'couleur')
    $color = get_field('couleur', $term->taxonomy . '_' . $term->term_id);
    
    // Couleur par défaut si non définie
    if (!$color) {
        $color = '#2E76B8';
    }

    return render_category_badge(array(
        'text'  => $term->name,
        'color' => $color,
    ));
}

/**
 * Affiche directement un badge depuis un term
 *
 * @param int|WP_Term $term Term ID ou objet WP_Term
 * @param string $taxonomy Nom de la taxonomie
 */
function the_term_badge($term, $taxonomy = '')
{
    echo render_term_badge($term, $taxonomy);
}
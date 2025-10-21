<?php

/**
 * Render Button Helper
 * Fonction helper pour générer des boutons unifiés
 *
 * @package churchill
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Render un bouton unifié
 *
 * @param array $args {
 *     Arguments du bouton
 *
 *     @type string $type   Type de bouton : 'primary', 'secondary', 'ghost', 'short'. Default 'primary'.
 *     @type string $url    URL du lien. Default '#'.
 *     @type string $text   Texte du bouton. Default 'En savoir plus'.
 *     @type string $target Target du lien : '_blank' ou ''. Default ''.
 *     @type bool   $icon   Afficher l'icône. Default true.
 *     @type string $class  Classes CSS additionnelles. Default ''.
 * }
 * @return string HTML du bouton
 */
function render_button($args = array())
{
    // Arguments par défaut
    $defaults = array(
        'type'   => 'primary',
        'url'    => '#',
        'text'   => 'En savoir plus',
        'target' => '',
        'icon'   => true,
        'class'  => '',
    );

    $args = wp_parse_args($args, $defaults);

    // Nettoyer les attributs
    $type = sanitize_text_field($args['type']);
    $url = esc_url($args['url']);
    $text = esc_html($args['text']);
    $target = $args['target'] === '_blank' ? ' target="_blank" rel="noopener noreferrer"' : '';
    $show_icon = (bool) $args['icon'];
    $extra_class = $args['class'] ? ' ' . sanitize_html_class($args['class']) : '';

    // Mapper les types vers les classes CSS
    $btn_class_map = array(
        'primary'   => 'btn-primary',
        'secondary' => 'btn-secondary',
        'ghost'     => 'btn-ghost',
        'short'     => 'btn-short',
        'primary-footer'     => 'btn-primary-footer',
        'secondary-footer'     => 'btn-secondary-footer',

    );

    $btn_class = isset($btn_class_map[$type]) ? $btn_class_map[$type] : 'btn-primary';

    // Couleur du SVG selon le type
    $svg_color_map = array(
        'primary'   => '#ffffff',
        'secondary' => '#2E76B8',
        'ghost'     => 'currentColor',
        'short'     => '#ffffff',
        'primary-footer'     => '#2E76B8',
        'secondary-footer'     => '#2E76B8',
    );

    $svg_color = isset($svg_color_map[$type]) ? $svg_color_map[$type] : '#ffffff';

    // Construction du HTML
    ob_start();
?>
    <a href="<?php echo $url; ?>" class="<?php echo $btn_class . $extra_class; ?>" <?php echo $target; ?>>
        <?php if ($type !== 'short' && $text) : ?>
            <span class="btn-text"><?php echo $text; ?></span>
        <?php endif; ?>

        <?php if ($show_icon) : ?>
            <span class="btn-icon">
                <svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21.7063 10.7704L0.15858 0.499998L2.73144 4.73919L15.3983 10.7616L21.7063 10.7704Z" fill="<?php echo $svg_color; ?>" />
                    <path d="M5.24749 18.5003L21.7063 10.7637L15.3953 10.7637L5.24791 15.5739" fill="<?php echo $svg_color; ?>" />
                    <path d="M2.73022 4.74502L0.161789 0.500183L0.161894 10.7648L1.44611 12.3671L2.73022 10.7648L2.73022 4.74502Z" fill="<?php echo $svg_color; ?>" />
                </svg>
            </span>
        <?php endif; ?>
    </a>
<?php
    return ob_get_clean();
}

/**
 * Affiche directement un bouton
 *
 * @param array $args Arguments du bouton (voir render_button)
 */
function the_button($args = array())
{
    echo render_button($args);
}

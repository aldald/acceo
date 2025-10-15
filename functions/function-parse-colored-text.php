<?php
/**
 * Parse Colored Text
 * Permet d'ajouter des couleurs dans les textes avec des balises personnalisées
 * Usage: [blue]Texte[/blue], [orange]Texte[/orange], etc.
 *
 * @package churchill
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Parse le texte avec des marqueurs de couleur et retourne du HTML coloré
 *
 * @param string $text Texte avec marqueurs [blue]texte[/blue]
 * @return string HTML avec spans colorés
 */
function parse_colored_text($text)
{
    if (!$text) return '';

    // Définir les couleurs disponibles (utilise les variables SCSS)
    $colors = array(
        'blue'   => '#2E76B8',  // $bleu-secondaire
        'orange' => '#FC8E14',  // $orange-elevation / $jaune-accessibilite
        'dark'   => '#05354E',  // $bleu-principal
        'green'  => '#A1C635',  // $vert-energie
        'ciel'   => '#5EC4E8',  // $vert-ascenseur / $bleu-environnement
        'bleu'   => '#2E76B8',  // Alias français
        'vert'   => '#A1C635',  // Alias français
    );

    // Remplacer les marqueurs par des spans colorés
    foreach ($colors as $color => $hex) {
        $text = preg_replace(
            '/\[' . $color . '\](.*?)\[\/' . $color . '\]/i',
            '<span style="color: ' . $hex . ';">$1</span>',
            $text
        );
    }

    return $text;
}

/**
 * Fonction helper pour affichage sécurisé avec wp_kses_post
 *
 * @param string $text Texte avec marqueurs de couleur
 * @return string HTML sécurisé et coloré
 */
function display_colored_title($text)
{
    if (!$text) return '';

    return wp_kses_post(parse_colored_text($text));
}

/**
 * Shortcode pour utiliser dans l'éditeur WordPress
 * Usage: [colored_text color="blue"]Mon texte[/colored_text]
 *
 * @param array $atts Attributs du shortcode
 * @param string $content Contenu entre les balises
 * @return string HTML coloré
 */
function colored_text_shortcode($atts, $content = null)
{
    $atts = shortcode_atts(array(
        'color' => 'blue',
    ), $atts);

    $colors = array(
        'blue'   => '#2E76B8',
        'orange' => '#FC8E14',
        'dark'   => '#05354E',
        'green'  => '#A1C635',
        'ciel'   => '#5EC4E8',
        'bleu'   => '#2E76B8',
        'vert'   => '#A1C635',
    );

    $color_hex = isset($colors[$atts['color']]) ? $colors[$atts['color']] : $colors['blue'];

    return '<span style="color: ' . esc_attr($color_hex) . ';">' . do_shortcode($content) . '</span>';
}
add_shortcode('colored_text', 'colored_text_shortcode');
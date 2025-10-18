<?php
/**
 * ACF Icon Picker - Configuration
 * Pointe vers assets/img/acf/ où sont stockées les icônes
 * 
 * @package Churchill
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Suffix du chemin (relatif au thème)
 */
add_filter('acf_icon_path_suffix', 'churchill_acf_icon_path_suffix');
function churchill_acf_icon_path_suffix($path_suffix) {
    return 'assets/img/acf/';  // ← Changé ici
}

/**
 * Chemin COMPLET serveur (avec trailing slash)
 */
add_filter('acf_icon_path', 'churchill_acf_icon_path');
function churchill_acf_icon_path($path_suffix) {
    $icon_path = get_stylesheet_directory() . '/' . churchill_acf_icon_path_suffix('');
    return trailingslashit($icon_path);
}

/**
 * URL publique (avec trailing slash)
 */
add_filter('acf_icon_url', 'churchill_acf_icon_url');
function churchill_acf_icon_url($path_suffix) {
    $icon_url = get_stylesheet_directory_uri() . '/' . churchill_acf_icon_path_suffix('');
    return trailingslashit($icon_url);
}

/**
 * Afficher une icône (fonction helper)
 * 
 * @param string $icon Nom du fichier (avec ou sans .svg)
 * @param array $args Arguments optionnels {
 *     @type string $class Classes CSS
 *     @type int $width Largeur en pixels
 *     @type int $height Hauteur en pixels
 *     @type string $color Couleur fill
 *     @type string $aria_label Label accessibilité
 * }
 */
function the_icon($icon, $args = array()) {
    if (empty($icon)) {
        return;
    }
    
    // Ajouter .svg si absent
    if (substr($icon, -4) !== '.svg') {
        $icon .= '.svg';
    }
    
    $icon_path = rtrim(churchill_acf_icon_path(''), '/') . '/' . $icon;
    
    // Vérifier si le fichier existe
    if (!file_exists($icon_path)) {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log('Churchill Theme: Icône non trouvée: ' . $icon_path);
        }
        echo churchill_icon_fallback($icon, $args);
        return;
    }
    
    // Lire le SVG
    $svg = file_get_contents($icon_path);
    
    if (empty($svg)) {
        echo churchill_icon_fallback($icon, $args);
        return;
    }
    
    // Appliquer les modifications
    if (!empty($args)) {
        $svg = churchill_modify_svg($svg, $args);
    }
    
    echo $svg;
}

/**
 * Retourner une icône (sans l'afficher)
 */
function get_icon($icon, $args = array()) {
    ob_start();
    the_icon($icon, $args);
    return ob_get_clean();
}

/**
 * Modifier les attributs d'un SVG
 */
function churchill_modify_svg($svg, $args) {
    if (empty($svg)) {
        return $svg;
    }
    
    // Ajouter/modifier la classe
    if (!empty($args['class'])) {
        if (strpos($svg, 'class="') !== false) {
            $svg = preg_replace('/class="([^"]*)"/', 'class="$1 ' . esc_attr($args['class']) . '"', $svg, 1);
        } else {
            $svg = str_replace('<svg', '<svg class="' . esc_attr($args['class']) . '"', $svg);
        }
    }
    
    // Modifier la largeur
    if (!empty($args['width'])) {
        if (strpos($svg, 'width="') !== false) {
            $svg = preg_replace('/width="[^"]*"/', 'width="' . absint($args['width']) . '"', $svg, 1);
        } else {
            $svg = str_replace('<svg', '<svg width="' . absint($args['width']) . '"', $svg);
        }
    }
    
    // Modifier la hauteur
    if (!empty($args['height'])) {
        if (strpos($svg, 'height="') !== false) {
            $svg = preg_replace('/height="[^"]*"/', 'height="' . absint($args['height']) . '"', $svg, 1);
        } else {
            $svg = str_replace('<svg', '<svg height="' . absint($args['height']) . '"', $svg);
        }
    }
    
    // Modifier la couleur (fill)
    if (!empty($args['color'])) {
        // Remplacer le premier fill trouvé
        if (strpos($svg, 'fill="') !== false) {
            $svg = preg_replace('/fill="[^"]*"/', 'fill="' . esc_attr($args['color']) . '"', $svg, 1);
        } else {
            $svg = str_replace('<svg', '<svg fill="' . esc_attr($args['color']) . '"', $svg);
        }
    }
    
    // Accessibilité
    if (!empty($args['aria_label'])) {
        $svg = str_replace('<svg', '<svg aria-label="' . esc_attr($args['aria_label']) . '" role="img"', $svg);
    } else {
        // Ajouter aria-hidden si pas de label
        if (strpos($svg, 'aria-') === false) {
            $svg = str_replace('<svg', '<svg aria-hidden="true"', $svg);
        }
    }
    
    return $svg;
}

/**
 * SVG de fallback si l'icône n'existe pas
 */
function churchill_icon_fallback($icon, $args = array()) {
    $width = !empty($args['width']) ? absint($args['width']) : 24;
    $height = !empty($args['height']) ? absint($args['height']) : 24;
    $class = !empty($args['class']) ? ' class="' . esc_attr($args['class']) . ' icon-fallback"' : ' class="icon-fallback"';
    
    return sprintf(
        '<svg%s width="%d" height="%d" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <circle cx="12" cy="12" r="10" fill="currentColor" opacity="0.1"/>
            <text x="12" y="16" text-anchor="middle" fill="currentColor" font-size="12" font-weight="bold">?</text>
        </svg>',
        $class,
        $width,
        $height
    );
}

/**
 * Vérifier si une icône existe
 */
function churchill_icon_exists($icon) {
    if (empty($icon)) {
        return false;
    }
    
    if (substr($icon, -4) !== '.svg') {
        $icon .= '.svg';
    }
    
    $icon_path = rtrim(churchill_acf_icon_path(''), '/') . '/' . $icon;
    return file_exists($icon_path);
}

/**
 * Lister toutes les icônes disponibles
 */
function churchill_get_available_icons() {
    $icon_path = rtrim(churchill_acf_icon_path(''), '/');
    
    if (!is_dir($icon_path)) {
        return array();
    }
    
    $icons = glob($icon_path . '/*.svg');
    
    if (!$icons) {
        return array();
    }
    
    return array_map('basename', $icons);
}

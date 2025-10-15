<?php
/**
 * TinyMCE Shortcodes
 * 
 * @package churchill
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// ============================================
// TinyMCE Buttons
// ============================================

function add_tinymce_button($buttons)
{
    array_push($buttons, 'add_mce_shortcode_button');
    array_push($buttons, 'add_mce_shortcode_table');
    array_push($buttons, 'add_mce_shortcode_video');
    array_push($buttons, 'add_mce_shortcode_steps');
    array_push($buttons, 'add_mce_shortcode_title_icon');

    return $buttons;
}

add_filter('mce_buttons', 'add_tinymce_button');


function register_tinymce_js($plugin_array)
{
    $plugin_array['add_mce_shortcode_button'] = get_bloginfo("template_url") . "/assets/js/backoffice.min.js";
    $plugin_array['add_mce_shortcode_table'] = get_bloginfo("template_url") . "/assets/js/backoffice.min.js";
    $plugin_array['add_mce_shortcode_video'] = get_bloginfo("template_url") . "/assets/js/backoffice.min.js";
    $plugin_array['add_mce_shortcode_steps'] = get_bloginfo("template_url") . "/assets/js/backoffice.min.js";
    $plugin_array['add_mce_shortcode_title_icon'] = get_bloginfo("template_url") . "/assets/js/backoffice.min.js";
    return $plugin_array;
}

add_filter('mce_external_plugins', 'register_tinymce_js');

// ============================================
// SHORTCODE : Bouton unifié
// ============================================

/**
 * Shortcode bouton unifié
 * 
 * Usage:
 * [btn type="primary" url="#" text="Cliquez ici"]
 * [btn type="secondary" url="#" text="En savoir plus" target="_blank"]
 * [btn type="ghost" url="#" text="Voir tout"]
 * [btn type="short" url="#"]
 * 
 * @param array $atts Attributs du shortcode
 * @return string HTML du bouton
 */
add_shortcode('btn', 'btn_shortcode');

function btn_shortcode($atts)
{
    // Attributs par défaut
    $atts = shortcode_atts(array(
        'type'   => 'primary',      // primary, secondary, ghost, short
        'url'    => '#',            // URL du lien
        'text'   => 'En savoir plus', // Texte du bouton
        'target' => '',             // _blank pour nouvel onglet
        'icon'   => 'true',         // Afficher l'icône (true/false)
        'class'  => '',             // Classes CSS additionnelles
    ), $atts);

    // Nettoyer les attributs
    $type = sanitize_text_field($atts['type']);
    $url = esc_url($atts['url']);
    $text = esc_html($atts['text']);
    $target = $atts['target'] === '_blank' ? ' target="_blank" rel="noopener noreferrer"' : '';
    $show_icon = $atts['icon'] !== 'false';
    $extra_class = $atts['class'] ? ' ' . sanitize_html_class($atts['class']) : '';

    // Mapper les types vers les classes CSS
    $btn_class_map = array(
        'primary'   => 'btn-primary',
        'secondary' => 'btn-secondary',
        'ghost'     => 'btn-ghost',
        'short'     => 'btn-short',
    );

    // Classe du bouton
    $btn_class = isset($btn_class_map[$type]) ? $btn_class_map[$type] : 'btn-primary';

    // Couleur du SVG selon le type
    $svg_color_map = array(
        'primary'   => '#ffffff',
        'secondary' => '#2E76B8',
        'ghost'     => 'currentColor',
        'short'     => '#ffffff',
    );

    $svg_color = isset($svg_color_map[$type]) ? $svg_color_map[$type] : '#ffffff';

    // Construction du HTML
    $html = '<a href="' . $url . '" class="' . $btn_class . $extra_class . '"' . $target . '>';

    // Texte (sauf pour type "short")
    if ($type !== 'short' && $text) {
        $html .= '<span class="btn-text">' . $text . '</span>';
    }

    // Icône (si activée)
    if ($show_icon) {
        $html .= '<span class="btn-icon">';
        $html .= '<svg width="22" height="20" viewBox="0 0 22 20" fill="none" xmlns="http://www.w3.org/2000/svg">';
        $html .= '<path d="M21.7063 10.7704L0.15858 0.499998L2.73144 4.73919L15.3983 10.7616L21.7063 10.7704Z" fill="' . $svg_color . '" />';
        $html .= '<path d="M5.24749 18.5003L21.7063 10.7637L15.3953 10.7637L5.24791 15.5739" fill="' . $svg_color . '" />';
        $html .= '<path d="M2.73022 4.74502L0.161789 0.500183L0.161894 10.7648L1.44611 12.3671L2.73022 10.7648L2.73022 4.74502Z" fill="' . $svg_color . '" />';
        $html .= '</svg>';
        $html .= '</span>';
    }

    $html .= '</a>';

    return $html;
}

// ============================================
// SHORTCODE : Bouton legacy (pour compatibilité)
// ============================================

/**
 * @deprecated Utiliser [btn] à la place
 */
add_shortcode('button', 'button_shortcode');

function button_shortcode($atts)
{
    $target = '';
    $download = '';

    if (isset($atts["new_tab"]) && $atts["new_tab"] == true) {
        $target = 'target="_blank"';
    }

    if (isset($atts["download"]) && $atts["download"] == true) {
        $download = 'download';
    }

    $text = isset($atts["text"]) ? $atts["text"] : '';
    $href = isset($atts["href"]) ? $atts["href"] : '#';
    $class = isset($atts["class"]) ? $atts["class"] : 'primary';

    return '<a data-label="' . esc_attr($text) . '" href="' . esc_url($href) . '" ' . $target . ' ' . $download . ' class="btn btn-' . esc_attr($class) . ' mt-3 mt-lg-4">' . esc_html($text) . '</a>';
}

// ============================================
// SHORTCODE : Table
// ============================================

add_shortcode('table', 'table_shortcode');

function table_shortcode($atts)
{
    $return = "";
    if (isset($atts["id"]) && $atts["id"]) {
        if ($table = get_field("tableau", $atts["id"])) {
            $return .= '<div class="table-full-responsive pt-5">';
            $return .= '<table class="table table-striped">';

            if ($headers = $table["header"]) {
                $return .= "<thead>";
                $return .= "<tr>";
                $labels = array();

                foreach ($headers as $header) {
                    $labels[] = $header["c"];
                    $return .= '<th scope="col">' . $header["c"] . '</th>';
                }
                $return .= "</tr>";
                $return .= "</thead>";
            }

            if ($rows = $table["body"]) {
                $return .= "<tbody>";
                foreach ($rows as $row) {
                    $return .= "<tr>";
                    if ($cells = $row) {
                        $i = 0;
                        foreach ($cells as $cell) {
                            $return .= '<td data-label="' . $labels[$i++] . '">' . $cell["c"] . '</td>';
                        }
                    }
                    $return .= "</tr>";
                }
                $return .= "</tbody>";
            }
        }

        $return .= '</table>';
        $return .= '</div>';
    }

    return $return;
}

// ============================================
// SHORTCODE : Vidéo modale
// ============================================

add_shortcode('modal_video', 'video_shortcode');

function video_shortcode($atts)
{
    if (isset($atts["url"]) && isset($atts["image"]) && $atts["url"] && $atts["image"]) {
        $html = '<a class="d-block video-shortcode" href="' . esc_url($atts["url"]) . '" data-fancybox="video">';
        $html .= '<img class="img-fluid" src="' . esc_url($atts["image"]) . '" />';
        $html .= '</a>';

        return $html;
    }
    return '';
}

// ============================================
// SHORTCODE : Step
// ============================================

add_shortcode('step', 'step_shortcode');

function step_shortcode($atts)
{
    $title = isset($atts["title"]) ? esc_html($atts["title"]) : '';
    $text = isset($atts["text"]) ? esc_html($atts["text"]) : '';

    return '<div class="step d-flex align-items-center"><div><div class="h3">' . $title . '</div><p>' . $text . '</p></div></div>';
}

// ============================================
// SHORTCODE : Title Icon
// ============================================

add_shortcode('title_icon', 'title_icon_shortcode');

function title_icon_shortcode($atts)
{
    $icon = isset($atts["icon"]) ? esc_attr($atts["icon"]) : 'check-circle';
    $text = isset($atts["text"]) ? esc_html($atts["text"]) : '';

    return '<div class="title_icon"><i class="bi bi-' . $icon . '"></i> ' . $text . '</div>';
}
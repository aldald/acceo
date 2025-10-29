<?php
/**
 * Fonction Helper : Charger un SVG inline
 * Utilise le chemin local au lieu de l'URL pour éviter les problèmes allow_url_fopen
 *
 * @package churchill
 */

if (!function_exists('get_inline_svg')) {
    /**
     * Récupère et affiche un SVG inline
     *
     * @param array $image_array ACF image array avec return_format='array'
     * @param string $fallback_alt Texte alternatif si image n'est pas SVG
     * @return void
     */
    function get_inline_svg($image_array, $fallback_alt = '') {
        if (empty($image_array)) {
            return;
        }

        // Vérifier si c'est un SVG
        if ($image_array['mime_type'] === 'image/svg+xml') {
            
            // Méthode 1 : Utiliser get_attached_file() pour le chemin local
            if (!empty($image_array['ID'])) {
                $file_path = get_attached_file($image_array['ID']);
                
                if (file_exists($file_path)) {
                    echo file_get_contents($file_path);
                    return;
                }
            }
            
            // Méthode 2 : Convertir l'URL en chemin local
            if (!empty($image_array['url'])) {
                $upload_dir = wp_upload_dir();
                $file_path = str_replace($upload_dir['baseurl'], $upload_dir['basedir'], $image_array['url']);
                
                if (file_exists($file_path)) {
                    echo file_get_contents($file_path);
                    return;
                }
            }
            
            // Fallback : Si tout échoue, afficher une image
            echo '<img src="' . esc_url($image_array['url']) . '" alt="' . esc_attr($fallback_alt) . '" loading="lazy">';
            
        } else {
            // Si ce n'est pas un SVG, afficher comme image normale
            echo '<img src="' . esc_url($image_array['url']) . '" alt="' . esc_attr($fallback_alt) . '" loading="lazy">';
        }
    }
}
<?php
/**
 * Topbar Menu Icons
 * Champs ACF pour le menu topbar uniquement
 *
 * @package churchill
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Add ACF icon field for TOPBAR menu ONLY
 */
add_action('acf/init', 'churchill_add_topbar_menu_fields', 20);
function churchill_add_topbar_menu_fields()
{
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_topbar_menu_fields',
            'title' => 'Paramètres du menu Topbar',
            'fields' => array(
                array(
                    'key' => 'field_topbar_icon',
                    'label' => 'Icône du menu',
                    'name' => 'topbar_icon',
                    'type' => 'image',
                    'instructions' => 'Ajoutez une icône pour cet élément du menu topbar (recommandé : 48x48px)',
                    'return_format' => 'array',
                    'preview_size' => 'thumbnail',
                    'library' => 'all',
                )
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'nav_menu_item',
                        'operator' => '==',
                        'value' => 'location/topbar-menu', // ⚠️ À adapter selon ton menu
                    ),
                ),
            ),
            'menu_order' => 10,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'left',
            'instruction_placement' => 'label',
            'active' => true,
        ));
    }
}

/**
 * Display icon in TOPBAR menu frontend
 */
add_filter('nav_menu_item_title', 'churchill_display_topbar_icon', 10, 4);
function churchill_display_topbar_icon($title, $item, $args, $depth)
{
    if (isset($args->theme_location) && $args->theme_location === 'topbar-menu') {
        $icon = get_field('topbar_icon', $item);

        if ($icon && !empty($icon['url'])) {
            $title = '<img src="' . esc_url($icon['url']) . '" class="topbar-menu-icon" alt="' . esc_attr($icon['alt'] ?: '') . '" style="width:20px;height:20px;margin-right:8px;vertical-align:middle;"> ' . $title;
        }
    }

    return $title;
}

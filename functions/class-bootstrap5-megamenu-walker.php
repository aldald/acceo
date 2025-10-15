<?php
/**
 * Bootstrap 5 Mega Menu Walker with ACF Support
 */
class Bootstrap_5_MegaMenu_Walker extends Walker_Nav_Menu {
    
    private $mega_menu_items = array();
    private $current_parent_id = 0;
    
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        
        if ($depth === 0 && $this->current_parent_id) {
            // Vérifier si c'est le menu "Vous êtes"
            $parent_item = get_post($this->current_parent_id);
            $parent_title = get_the_title($this->current_parent_id);
            
            if (stripos($parent_title, 'vous') !== false || stripos($parent_title, 'êtes') !== false) {
                // C'est le mega menu "Vous êtes"
                $output .= "\n$indent<div class=\"mega-menu-wrapper\">\n";
                $output .= "$indent<div class=\"container-fluid\">\n";
                $output .= "$indent<div class=\"mega-menu-content\">\n";
                $output .= "$indent<div class=\"row g-3\">\n";
            } else {
                // Dropdown normal
                $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
            }
        } else {
            $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
        }
    }
    
    function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        
        if ($depth === 0 && $this->current_parent_id) {
            $parent_title = get_the_title($this->current_parent_id);
            
            if (stripos($parent_title, 'vous') !== false || stripos($parent_title, 'êtes') !== false) {
                $output .= "$indent</div>\n"; // .row
                $output .= "$indent</div>\n"; // .mega-menu-content
                $output .= "$indent</div>\n"; // .container
                $output .= "$indent</div>\n"; // .mega-menu-wrapper
            } else {
                $output .= "$indent</ul>\n";
            }
        } else {
            $output .= "$indent</ul>\n";
        }
    }
    
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        // Si c'est un parent de niveau 0
        if ($depth === 0) {
            if (in_array('menu-item-has-children', $classes)) {
                $classes[] = 'dropdown';
                $this->current_parent_id = $item->ID;
                
                // Vérifier si c'est "Vous êtes"
                if (stripos($item->title, 'vous') !== false || stripos($item->title, 'êtes') !== false) {
                    $classes[] = 'has-megamenu';
                    $classes[] = 'vous-etes-menu';
                }
            }
        }
        
        // Pour les éléments dans le mega menu
        if ($depth === 1 && $this->current_parent_id) {
            $parent_title = get_the_title($this->current_parent_id);
            
            if (stripos($parent_title, 'vous') !== false || stripos($parent_title, 'êtes') !== false) {
                // C'est un item du mega menu
                $this->render_mega_menu_item($output, $item, $indent);
                return;
            }
        }
        
        // Rendu normal pour les autres éléments
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="nav-item ' . esc_attr($class_names) . '"' : ' class="nav-item"';
        
        $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        
        $output .= $indent . '<li' . $id . $class_names .'>';
        
        $attributes = ! empty($item->url) ? ' href="' . esc_attr($item->url) .'"' : '';
        $attributes .= ' class="nav-link' . (in_array('menu-item-has-children', $classes) ? ' dropdown-toggle' : '') . '"';
        
        if (in_array('menu-item-has-children', $classes) && $depth === 0) {
            $attributes .= ' data-bs-toggle="dropdown"';
        }
        
        $item_output = $args->before ?? '';
        $item_output .= '<a'. $attributes .'>';
        $item_output .= ($args->link_before ?? '') . apply_filters('the_title', $item->title, $item->ID) . ($args->link_after ?? '');
        
        if ($depth === 0 && in_array('menu-item-has-children', $classes)) {
            $item_output .= ' <i class="bi bi-chevron-down"></i>';
        }
        
        $item_output .= '</a>';
        $item_output .= $args->after ?? '';
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
    
    /**
     * Render mega menu item with ACF fields
     */
    private function render_mega_menu_item(&$output, $item, $indent) {
        // Récupérer les champs ACF
        $image = get_field('menu_item_image', $item->ID);
        $description = get_field('menu_item_description', $item->ID);
        $is_highlighted = get_field('menu_item_highlight', $item->ID);
        
        $output .= $indent . '<div class="col-lg-3 col-md-6">' . "\n";
        $output .= $indent . '  <a href="' . esc_url($item->url) . '" class="service-card-link">' . "\n";
        $output .= $indent . '    <div class="service-card' . ($is_highlighted ? ' highlighted' : '') . '">' . "\n";
        
        // Image
        if ($image && !empty($image['url'])) {
            $output .= $indent . '      <div class="service-icon">' . "\n";
            $output .= $indent . '        <img src="' . esc_url($image['url']) . '" alt="' . esc_attr($image['alt'] ?? $item->title) . '">' . "\n";
            $output .= $indent . '      </div>' . "\n";
        } else {
            // Image par défaut si aucune image n'est définie
            $output .= $indent . '      <div class="service-icon">' . "\n";
            $output .= $indent . '        <i class="bi bi-building"></i>' . "\n";
            $output .= $indent . '      </div>' . "\n";
        }
        
        // Titre
        $output .= $indent . '      <h4>' . esc_html($item->title) . '</h4>' . "\n";
        
        // Description
        if ($description) {
            $output .= $indent . '      <p class="service-description">' . esc_html($description) . '</p>' . "\n";
        }
        
        $output .= $indent . '    </div>' . "\n";
        $output .= $indent . '  </a>' . "\n";
        $output .= $indent . '</div>' . "\n";
    }
    
    function end_el(&$output, $item, $depth = 0, $args = null) {
        if ($depth === 1) {
            $parent_title = get_the_title($this->current_parent_id);
            
            if (stripos($parent_title, 'vous') !== false || stripos($parent_title, 'êtes') !== false) {
                // Pas de </li> pour les items du mega menu
                return;
            }
        }
        
        $output .= "</li>\n";
    }
}
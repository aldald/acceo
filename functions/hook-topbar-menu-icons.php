<?php

/**
 * Topbar Menu Icons
 * Add custom icon fields to menu items
 *
 * @package churchill
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * Add icon field to menu item
 */
add_action('wp_nav_menu_item_custom_fields', 'churchill_menu_icon_field', 10, 2);
function churchill_menu_icon_field($item_id, $item)
{
    $icon_url = get_post_meta($item_id, '_menu_icon', true);
?>
    <p class="field-menu-icon description description-wide">
        <label for="menu-icon-<?php echo $item_id; ?>">
            <?php _e('Icône du menu', 'churchill'); ?><br>
            <input type="hidden"
                id="menu-icon-<?php echo $item_id; ?>"
                class="widefat menu-icon-url"
                name="menu-icon[<?php echo $item_id; ?>]"
                value="<?php echo esc_attr($icon_url); ?>">

            <button type="button" class="button button-secondary upload-menu-icon" data-item-id="<?php echo $item_id; ?>">
                <?php _e('Choisir une icône', 'churchill'); ?>
            </button>

            <button type="button" class="button button-secondary remove-menu-icon" data-item-id="<?php echo $item_id; ?>" style="<?php echo empty($icon_url) ? 'display:none;' : ''; ?>">
                <?php _e('Supprimer', 'churchill'); ?>
            </button>
        </label>

        <span class="icon-preview" style="display:block;margin-top:10px;">
            <?php if ($icon_url): ?>
                <img src="<?php echo esc_url($icon_url); ?>" style="max-width:24px;height:auto;">
            <?php endif; ?>
        </span>
    </p>
<?php
}

/**
 * Save icon field
 */
add_action('wp_update_nav_menu_item', 'churchill_save_menu_icon', 10, 2);
function churchill_save_menu_icon($menu_id, $menu_item_db_id)
{
    if (isset($_POST['menu-icon'][$menu_item_db_id])) {
        update_post_meta($menu_item_db_id, '_menu_icon', sanitize_text_field($_POST['menu-icon'][$menu_item_db_id]));
    } else {
        delete_post_meta($menu_item_db_id, '_menu_icon');
    }
}

/**
 * Enqueue media uploader
 */
add_action('admin_enqueue_scripts', 'churchill_menu_icon_script');
function churchill_menu_icon_script($hook)
{
    if ('nav-menus.php' !== $hook) {
        return;
    }

    wp_enqueue_media();

    wp_add_inline_script('jquery', "
        jQuery(document).ready(function($) {
            $(document).on('click', '.upload-menu-icon', function(e) {
                e.preventDefault();
                var button = $(this);
                var itemId = button.data('item-id');
                var input = $('#menu-icon-' + itemId);
                var preview = button.closest('.field-menu-icon').find('.icon-preview');
                var removeBtn = button.siblings('.remove-menu-icon');
                
                var frame = wp.media({
                    title: 'Choisir une icône',
                    button: { text: 'Utiliser cette icône' },
                    multiple: false,
                    library: { type: 'image' }
                });
                
                frame.on('select', function() {
                    var attachment = frame.state().get('selection').first().toJSON();
                    input.val(attachment.url);
                    preview.html('<img src=\"' + attachment.url + '\" style=\"max-width:24px;height:auto;\">');
                    removeBtn.show();
                });
                
                frame.open();
            });
            
            $(document).on('click', '.remove-menu-icon', function(e) {
                e.preventDefault();
                var button = $(this);
                var itemId = button.data('item-id');
                $('#menu-icon-' + itemId).val('');
                button.closest('.field-menu-icon').find('.icon-preview').html('');
                button.hide();
            });
        });
    ");
}

/**
 * Add icon to menu items
 */
add_filter('nav_menu_item_title', 'churchill_add_menu_icon', 10, 4);
function churchill_add_menu_icon($title, $item, $args, $depth)
{
    // Seulement pour le menu topbar
    if (isset($args->theme_location) && $args->theme_location === 'topbar-menu') {
        $icon_url = get_post_meta($item->ID, '_menu_icon', true);

        if ($icon_url) {
            $title = '<img src="' . esc_url($icon_url) . '" class="menu-icon" alt=""> ' . $title;
        }
    }

    return $title;
}


// Charger Google Fonts
add_action('wp_enqueue_scripts', 'load_montserrat_font');
function load_montserrat_font()
{
    wp_enqueue_style('montserrat-font', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap', array(), null);
}

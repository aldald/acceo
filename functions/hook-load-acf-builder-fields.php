<?php

// Contenus page builder
add_action('acf/include_fields', function () {
    if (! function_exists('acf_add_local_field_group')) {
        return;
    }

    if ($groups = glob(STYLESHEETPATH . '/acf-json/*.{json}', GLOB_BRACE)) {
        $layouts = array();

        foreach ($groups as $groupPath) {
            $group = json_decode(file_get_contents($groupPath), true);

            // Vérifie si le groupe est inactif (ajuste la condition selon ta structure)
            if (!isset($group["active"]) || !$group["active"]) {

                if (isset($group["fields"]) && is_array($group["fields"])) {
                    $fields = array();
                    foreach ($group["fields"] as $field) {
                        $field["key"] .= "churchill"; // Ajoute "churchill" à la clé
                        $fields[] = $field;
                    }
                }

                $layoutKey = str_replace("group", "layout", $group["key"]);
                $layout = array(
                    'key' => $layoutKey,
                    'name' => sanitize_title($group["title"]),
                    'label' => $group["title"],
                    'display' => 'block',
                    'sub_fields' => $fields,
                    'min' => '',
                    'max' => '',
                    'acfe_flexible_render_template' => 'components/' . sanitize_title($group["title"]) . '.php',
                    'acfe_flexible_render_style' => '',
                    'acfe_flexible_render_script' => '',
                    'acfe_flexible_modal_edit_size' => '',
                    'acfe_flexible_thumbnail' => false,
                    'acfe_flexible_settings' => false,
                    'acfe_flexible_settings_size' => 'medium',
                    'acfe_layout_locations' => array(
                        array(
                            array(
                                'param' => 'post_type',
                                'operator' => '==',
                                'value' => 'page',
                            ),
                            array(
                                'param' => 'page_template',
                                'operator' => '==',
                                'value' => 'default',
                            ),
                        ),
                        array(
                            array(
                                'param' => 'post_type',
                                'operator' => '==',
                                'value' => 'page',
                            ),
                            array(
                                'param' => 'page_template',
                                'operator' => '==',
                                'value' => 'template-pages/actualites-liste.php',
                            ),
                        ),
                        array(
                            array(
                                'param' => 'options_page',
                                'operator' => '==',
                                'value' => 'blog_composant',
                            ),
                        ),
                        array(
                            array(
                                'param' => 'options_page',
                                'operator' => '==',
                                'value' => 'blog_category_composant',
                            ),
                        ),
                        array(
                            array(
                                'param' => 'taxonomy',
                                'operator' => '==',
                                'value' => 'categorie_mission',
                            ),
                        ),
                        array(
                            array(
                                'param' => 'post_type',
                                'operator' => '==',
                                'value' => 'realisation',
                            ),
                        ),

                    ),
                    'acfe_flexible_category' => false,
                    'acfe_layout_col' => 'auto',
                    'acfe_layout_allowed_col' => false,
                );

                $layouts[$layoutKey] = $layout;
            }
        }
    }

    acf_add_local_field_group(array(
        'key' => 'group_653a695dbbce2',
        'title' => 'Contenus page builder',
        'fields' => array(
            array(
                'key' => 'field_653a695f6e2ce',
                'label' => 'Sections',
                'name' => 'sections',
                'aria-label' => '',
                'type' => 'flexible_content',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'acfe_flexible_advanced' => 1,
                'acfe_flexible_stylised_button' => 1,
                'acfe_flexible_layouts_templates' => 0,
                'acfe_flexible_layouts_placeholder' => 0,
                'acfe_flexible_layouts_thumbnails' => 0,
                'acfe_flexible_layouts_settings' => 1,
                'acfe_flexible_layouts_locations' => 1,
                'acfe_flexible_async' => array(
                    0 => 'title',
                    1 => 'layout',
                ),
                'acfe_flexible_add_actions' => array(
                    0 => 'title',
                    1 => 'copy',
                ),
                'acfe_flexible_remove_button' => array(
                    0 => 'collapse',
                ),
                'acfe_flexible_layouts_state' => 'force_open',
                'acfe_flexible_modal_edit' => array(
                    'acfe_flexible_modal_edit_enabled' => '0',
                    'acfe_flexible_modal_edit_size' => 'large',
                ),
                'acfe_flexible_modal' => array(
                    'acfe_flexible_modal_enabled' => '0',
                    'acfe_flexible_modal_title' => false,
                    'acfe_flexible_modal_size' => 'full',
                    'acfe_flexible_modal_col' => '4',
                    'acfe_flexible_modal_categories' => false,
                ),
                'acfe_flexible_grid' => array(
                    'acfe_flexible_grid_enabled' => '0',
                    'acfe_flexible_grid_align' => 'center',
                    'acfe_flexible_grid_valign' => 'stretch',
                    'acfe_flexible_grid_wrap' => false,
                ),
                'layouts' => array(
                    'layout_653a698dc1168' => array(
                        'key' => 'layout_653a698dc1168',
                        'name' => 'section',
                        'label' => 'Section',
                        'display' => 'block',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_653a6b996e2d0',
                                'label' => 'Composants',
                                'name' => 'composants',
                                'aria-label' => '',
                                'type' => 'flexible_content',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'acfe_flexible_advanced' => 1,
                                'acfe_flexible_stylised_button' => 0,
                                'acfe_flexible_hide_empty_message' => 0,
                                'acfe_flexible_empty_message' => '',
                                'acfe_flexible_layouts_templates' => 1,
                                'acfe_flexible_layouts_previews' => 1,
                                'acfe_flexible_layouts_thumbnails' => 0,
                                'acfe_flexible_layouts_settings' => 1,
                                'acfe_flexible_layouts_locations' => 0,
                                'acfe_flexible_async' => array(
                                    0 => 'title',
                                    1 => 'layout',
                                ),
                                'acfe_flexible_add_actions' => array(
                                    0 => 'copy',
                                ),
                                'acfe_flexible_remove_button' => array(
                                    0 => 'collapse',
                                ),
                                'acfe_flexible_modal_edit' => array(
                                    'acfe_flexible_modal_edit_enabled' => '1',
                                    'acfe_flexible_modal_edit_size' => 'large',
                                ),
                                'acfe_flexible_modal' => array(
                                    'acfe_flexible_modal_enabled' => '1',
                                    'acfe_flexible_modal_title' => 'Composants',
                                    'acfe_flexible_modal_size' => 'full',
                                    'acfe_flexible_modal_col' => '4',
                                    'acfe_flexible_modal_categories' => '0',
                                ),
                                'acfe_flexible_grid' => array(
                                    'acfe_flexible_grid_enabled' => '0',
                                    'acfe_flexible_grid_align' => 'center',
                                    'acfe_flexible_grid_valign' => 'stretch',
                                    'acfe_flexible_grid_wrap' => false,
                                ),
                                'layouts' => $layouts,
                                'min' => '',
                                'max' => '',
                                'button_label' => 'Ajouter un composant',
                                'acfe_flexible_layouts_placeholder' => false,
                                'acfe_flexible_layouts_state' => false,
                                'acfe_flexible_grid_container' => false,
                            ),
                        ),
                        'min' => '',
                        'max' => '',
                        'acfe_flexible_settings' => array(
                            0 => 'group_653a7516644ff',
                        ),
                        'acfe_flexible_settings_size' => 'medium',
                        'acfe_layout_locations' => array(
                            array(
                                array(
                                    'param' => 'post_type',
                                    'operator' => '==',
                                    'value' => 'page',
                                ),
                                array(
                                    'param' => 'page_template',
                                    'operator' => '==',
                                    'value' => 'default',
                                ),
                            ),
                            array(
                                array(
                                    'param' => 'post_type',
                                    'operator' => '==',
                                    'value' => 'page',
                                ),
                                array(
                                    'param' => 'page_template',
                                    'operator' => '==',
                                    'value' => 'template-pages/actualites-liste.php',
                                ),
                            ),
                            array(
                                array(
                                    'param' => 'options_page',
                                    'operator' => '==',
                                    'value' => 'blog_composant',
                                ),
                            ),
                            array(
                                array(
                                    'param' => 'options_page',
                                    'operator' => '==',
                                    'value' => 'blog_category_composant',
                                ),
                            ),
                            array(
                                array(
                                    'param' => 'taxonomy',
                                    'operator' => '==',
                                    'value' => 'categorie_mission',
                                ),
                            ),
                            array(
                                array(
                                    'param' => 'post_type',
                                    'operator' => '==',
                                    'value' => 'realisation',
                                ),
                            ),
                        ),
                        'acfe_flexible_render_template' => false,
                        'acfe_flexible_render_style' => false,
                        'acfe_flexible_render_script' => false,
                        'acfe_flexible_thumbnail' => false,
                        'acfe_flexible_modal_edit_size' => false,
                        'acfe_flexible_category' => false,
                        'acfe_layout_col' => 'auto',
                        'acfe_layout_allowed_col' => false,
                    ),
                ),
                'min' => '',
                'max' => '',
                'button_label' => 'Ajouter une section',
                'acfe_flexible_hide_empty_message' => false,
                'acfe_flexible_empty_message' => '',
                'acfe_flexible_layouts_previews' => false,
                'acfe_flexible_grid_container' => false,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                ),
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'default',
                ),
            ),
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                ),
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'template-pages/actualites-liste.php',
                ),
            ),
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'blog_composant',
                ),
            ),
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'blog_category_composant',
                ),
            ),
            array(
                array(
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'categorie_mission',
                ),
            ),
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'realisation',
                ),
            ),
        ),
        'menu_order' => 1,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => array(
            0 => 'preview',
            1 => 'block_editor',
            2 => 'categories',
            3 => 'discussion',
            4 => 'comments',
            5 => 'send-trackbacks',
            6 => 'format',
            8 => 'tags',
        ),
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
        'acfe_autosync' => array(
            0 => 'json',
        ),
        'acfe_form' => 0,
        'acfe_display_title' => 'Contenus',
        'acfe_meta' => '',
        'acfe_note' => '',
    ));
});

// Options des sections
add_action('acf/include_fields', function () {
    if (! function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_653a7516644ff',
        'title' => 'Options des sections',
        'fields' => array(
            array(
                'key' => 'field_653a86ee2abd2',
                'label' => '(Column 4/12)',
                'name' => '',
                'aria-label' => '',
                'type' => 'acfe_column',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'columns' => '4/12',
                'endpoint' => 0,
                'border' => '',
                'border_endpoint' => array(
                    0 => 'endpoint',
                ),
            ),
            array(
                'key' => 'field_653a755b675e4',
                'label' => 'Identifiant',
                'name' => 'identifiant',
                'aria-label' => '',
                'type' => 'acfe_slug',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array(
                'key' => 'field_654101648bd84',
                'label' => '(Column 8/12)',
                'name' => '',
                'aria-label' => '',
                'type' => 'acfe_column',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'columns' => '8/12',
                'endpoint' => 0,
                'border' => '',
                'border_endpoint' => array(
                    0 => 'endpoint',
                ),
            ),
            array(
                'key' => 'field_654101418bd83',
                'label' => 'Classes',
                'name' => 'classes',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'maxlength' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
            array(
                'key' => 'field_653a872e9fb8a',
                'label' => '(Column Endpoint)',
                'name' => '',
                'aria-label' => '',
                'type' => 'acfe_column',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'endpoint' => 1,
                'border_endpoint' => array(
                    0 => 'endpoint',
                ),
                'columns' => '6/12',
                'border' => '',
            ),
            array(
                'key' => 'field_653a85e0c8867',
                'label' => '(Column 6/12)',
                'name' => '',
                'aria-label' => '',
                'type' => 'acfe_column',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'columns' => '6/12',
                'endpoint' => 0,
                'border' => '',
                'border_endpoint' => array(
                    0 => 'endpoint',
                ),
            ),
            array(
                'key' => 'field_653a7517675e3',
                'label' => 'Couleur de fond',
                'name' => 'couleur_de_fond',
                'aria-label' => '',
                'type' => 'color_picker',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'enable_opacity' => 0,
                'return_format' => 'label',
                'display' => 'palette',
                'color_picker' => 0,
                'allow_null' => 1,
                'theme_colors' => 1,
                'colors' => array(),
                'button_label' => 'Sélectionner une couleur',
                'absolute' => false,
                'input' => true,
            ),
            array(
                'key' => 'field_656c794baea02',
                'label' => '(Column 3/12)',
                'name' => '',
                'aria-label' => '',
                'type' => 'acfe_column',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'columns' => '3/12',
                'endpoint' => 0,
                'border' => '',
                'border_endpoint' => array(
                    0 => 'endpoint',
                ),
            ),
            array(
                'key' => 'field_656c7959aea04',
                'label' => 'Marge haute',
                'name' => 'margin_top',
                'aria-label' => '',
                'type' => 'select',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    0 => '0',
                    1 => '1',
                    2 => '2',
                    3 => '3',
                    4 => '4',
                    5 => '5',
                    6 => '6',
                ),
                'default_value' => 0,
                'return_format' => 'value',
                'multiple' => 0,
                'max' => '',
                'prepend' => '',
                'append' => '',
                'allow_null' => 0,
                'ui' => 0,
                'ajax' => 0,
                'placeholder' => '',
                'allow_custom' => 0,
                'search_placeholder' => '',
                'min' => '',
            ),
            array(
                'key' => 'field_656c794faea03',
                'label' => '(Column 3/12)',
                'name' => '',
                'aria-label' => '',
                'type' => 'acfe_column',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'columns' => '3/12',
                'endpoint' => 0,
                'border' => '',
                'border_endpoint' => array(
                    0 => 'endpoint',
                ),
            ),
            array(
                'key' => 'field_656c7b78aea07',
                'label' => 'Marge basse',
                'name' => 'margin_bottom',
                'aria-label' => '',
                'type' => 'select',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    0 => '0',
                    1 => '1',
                    2 => '2',
                    3 => '3',
                    4 => '4',
                    5 => '5',
                    6 => '6',
                ),
                'default_value' => 0,
                'return_format' => 'value',
                'multiple' => 0,
                'max' => '',
                'prepend' => '',
                'append' => '',
                'allow_null' => 0,
                'ui' => 0,
                'ajax' => 0,
                'placeholder' => '',
                'allow_custom' => 0,
                'search_placeholder' => '',
                'min' => '',
            ),
            array(
                'key' => 'field_653a86730fa40',
                'label' => '(Column Endpoint)',
                'name' => '',
                'aria-label' => '',
                'type' => 'acfe_column',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'endpoint' => 1,
                'border_endpoint' => array(
                    0 => 'endpoint',
                ),
                'columns' => '6/12',
                'border' => '',
            ),
            array(
                'key' => 'field_656cf9296ca9b',
                'label' => '(Column 6/12)',
                'name' => '',
                'aria-label' => '',
                'type' => 'acfe_column',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'columns' => '6/12',
                'endpoint' => 0,
                'border' => '',
                'border_endpoint' => array(
                    0 => 'endpoint',
                ),
            ),
            array(
                'key' => 'field_656cf8dc9a6ce',
                'label' => 'Marges mobile automatiques',
                'name' => 'margin_mobile_auto',
                'aria-label' => '',
                'type' => 'true_false',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'message' => '',
                'default_value' => 1,
                'ui_on_text' => '',
                'ui_off_text' => '',
                'ui' => 1,
                'style' => '',
            ),
            array(
                'key' => 'field_656cf93b6ca9d',
                'label' => '(Column 3/12)',
                'name' => '',
                'aria-label' => '',
                'type' => 'acfe_column',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_656cf8dc9a6ce',
                            'operator' => '!=',
                            'value' => '1',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'columns' => '3/12',
                'endpoint' => 0,
                'border' => '',
                'border_endpoint' => array(
                    0 => 'endpoint',
                ),
            ),
            array(
                'key' => 'field_656cf9466ca9e',
                'label' => 'Marge haute mobile',
                'name' => 'margin_top_mobile',
                'aria-label' => '',
                'type' => 'select',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_656cf8dc9a6ce',
                            'operator' => '!=',
                            'value' => '1',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    0 => '0',
                    1 => '1',
                    2 => '2',
                    3 => '3',
                    4 => '4',
                    5 => '5',
                    6 => '6',
                ),
                'default_value' => 0,
                'return_format' => 'value',
                'multiple' => 0,
                'prepend' => '',
                'append' => '',
                'allow_null' => 0,
                'ui' => 0,
                'ajax' => 0,
                'placeholder' => '',
                'allow_custom' => 0,
                'search_placeholder' => '',
                'min' => '',
                'max' => '',
            ),
            array(
                'key' => 'field_656cf9336ca9c',
                'label' => '(Column 3/12)',
                'name' => '',
                'aria-label' => '',
                'type' => 'acfe_column',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_656cf8dc9a6ce',
                            'operator' => '!=',
                            'value' => '1',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'columns' => '3/12',
                'endpoint' => 0,
                'border' => '',
                'border_endpoint' => array(
                    0 => 'endpoint',
                ),
            ),
            array(
                'key' => 'field_656cf94d6ca9f',
                'label' => 'Marge basse mobile',
                'name' => 'margin_bottom_mobile',
                'aria-label' => '',
                'type' => 'select',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_656cf8dc9a6ce',
                            'operator' => '!=',
                            'value' => '1',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    0 => '0',
                    1 => '1',
                    2 => '2',
                    3 => '3',
                    4 => '4',
                    5 => '5',
                    6 => '6',
                ),
                'default_value' => 0,
                'return_format' => 'value',
                'multiple' => 0,
                'max' => '',
                'prepend' => '',
                'append' => '',
                'allow_null' => 0,
                'ui' => 0,
                'ajax' => 0,
                'placeholder' => '',
                'allow_custom' => 0,
                'search_placeholder' => '',
                'min' => '',
            ),
            array(
                'key' => 'field_656cf9546caa0',
                'label' => '(Column Endpoint)',
                'name' => '',
                'aria-label' => '',
                'type' => 'acfe_column',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'endpoint' => 1,
                'border_endpoint' => array(
                    0 => 'endpoint',
                ),
                'columns' => '6/12',
                'border' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                ),
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'default',
                ),
            ),
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                ),
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'template-pages/actualites-liste.php',
                ),
            ),
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'blog_composant',
                ),
            ),
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'blog_category_composant',
                ),
            ),
            array(
                array(
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'categorie_mission',
                ),
            ),
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'realisation',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => false,
        'description' => '',
        'show_in_rest' => 0,
        'acfe_autosync' => '',
        'acfe_form' => 0,
        'acfe_display_title' => 'Options',
        'acfe_meta' => '',
        'acfe_note' => '',
    ));
});

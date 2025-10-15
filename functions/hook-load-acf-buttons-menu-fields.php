<?php
if ( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_6422ce87c3c33',
        'title' => 'Boutons',
        'fields' => array(
            array(
                'key' => 'field_6422ce886a9a6',
                'label' => 'Boutons',
                'name' => 'boutons',
                'aria-label' => '',
                'type' => 'repeater',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'acfe_repeater_stylised_button' => 0,
                'layout' => 'block',
                'pagination' => 0,
                'min' => 0,
                'max' => 0,
                'collapsed' => '',
                'button_label' => 'Ajouter un bouton',
                'rows_per_page' => 20,
                'sub_fields' => array(
                    array(
                        'key' => 'field_6422ce926a9a7',
                        'label' => 'Lien',
                        'name' => 'lien',
                        'aria-label' => '',
                        'type' => 'acfe_advanced_link',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'post_type' => '',
                        'taxonomy' => '',
                        'parent_repeater' => 'field_6422ce886a9a6',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'nav_menu',
                    'operator' => '==',
                    'value' => 'location/principal',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'left',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
        'acfe_autosync' => '',
        'acfe_form' => 0,
        'acfe_display_title' => '',
        'acfe_meta' => array(
            '6422cf9dc86f5' => array(
                'acfe_meta_key' => '',
                'acfe_meta_value' => '',
            ),
        ),
        'acfe_note' => '',
    ));

endif;
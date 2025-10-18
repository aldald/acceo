<?php if (have_rows('sections',$args["context"])) { ?>

    <?php while (have_rows('sections',$args["context"])) : the_row(); ?>
        <?php
        $id = '';
        $classes= '';
        $bg_color= '';
        ?>
        <?php if (have_settings()) { ?>
            <?php while (have_settings()) : the_setting(); ?>
                <?php
                if (get_sub_field("identifiant") || get_sub_field("classes") || get_sub_field("couleur_de_fond") || get_sub_field("margin_top") || get_sub_field("margin_bottom")) {

                    if( get_sub_field("identifiant") ){
                        $id = 'id="'.get_sub_field("identifiant").'"';
                    } else {
                        $id = '';
                    }

                    if ( get_sub_field("classes") || get_sub_field("couleur_de_fond") || get_sub_field("margin_top") || get_sub_field("margin_bottom") ) {

                        $classes_array = array();

                        if ($custom_classes = get_sub_field("classes")) {
                            $classes_array[] = $custom_classes;
                        }

                        if ($margin_top = get_sub_field("margin_top")) {
                            if (get_sub_field('margin_mobile_auto') == true || $margin_top >= 5 && get_sub_field('margin_mobile_auto') == true) {
                                if ($margin_top == 6) {
                                    $classes_array[] = 'mt-'.intval($margin_top) / 2 + 1;
                                } else {
                                    $classes_array[] = 'mt-'.ceil(intval($margin_top) / 2);
                                }
                                $classes_array[] = 'mt-md-'.$margin_top;
                            } else {
                                $classes_array[] = 'mt-'.get_sub_field('margin_top_mobile');
                                $classes_array[] = 'mt-md-'.$margin_top;
                            }
                        }

                        if ($margin_bottom = get_sub_field("margin_bottom")) {
                            if (get_sub_field('margin_mobile_auto') == true || $margin_bottom >= 5 && get_sub_field('margin_mobile_auto') == true) {
                                if ($margin_bottom == 6) {
                                    $classes_array[] = 'mb-'.intval($margin_bottom) / 2 + 1;
                                } else {
                                    $classes_array[] = 'mb-'.ceil(intval($margin_bottom) / 2);
                                }
                                $classes_array[] = 'mb-md-'.$margin_bottom;
                            } else {
                                $classes_array[] = 'mb-'.get_sub_field('margin_bottom_mobile');
                                $classes_array[] = 'mb-md-'.$margin_bottom;
                            }
                        }

                        if ($bg_color = get_sub_field("couleur_de_fond")) {
                            $classes_array[] = 'py-5';
                            $classes_array[] = 'bg-'.$bg_color;
                        }

                        $classes = implode(" ", $classes_array);

                    } else {
                        $classes = '';
                        $bg_color = '';
                    }

                } else {
                    $classes = '';
                    $bg_color = '';
                }
                ?>
            <?php endwhile; ?>
        <?php } ?>

        <section <?php echo $id;?> class="<?php echo $classes; ?>">
            <?php if (have_rows('composants')) { ?>
                <?php while (have_rows('composants')) : the_row(); ?>
                    <?php get_template_part('components/' . get_row_layout(), '', array('id' => $id, 'classes' => $classes, 'section_color' => $bg_color)) ?>
                <?php endwhile; ?>
            <?php } ?>
        </section>

    <?php endwhile; ?>
<?php } ?>
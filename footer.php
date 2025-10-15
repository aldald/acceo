<?php

/**
 * Footer
 *
 * @package churchill
 */
// Exit if accessed directly.
defined('ABSPATH') || exit;
?>
<footer id="footer_wrapper" class="text-center text-sm-start">
    <section id="footer-top" class="container pb-5">
        <div class="row">
            <div class="col-sm-12 col-xl-4">
                <div class="logo-footer-infos">
                    <img class="mb-4" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo-footer.svg" alt="<?php bloginfo("name") ?>" />
                    <?php
                    echo render_button(array(
                        'type'   => 'primary',
                        'url'    => '#',
                        'text'   => 'Demander un devis',
                        'target' => '',
                    )); ?>
                    <?php
                    echo render_button(array(
                        'type'   => 'ghost',
                        'url'    => '#',
                        'text'   => 'Lorem ipsum',
                        'target' => '',
                    )); ?>

                    <div class="social-net-work-footer">
                        <?php if ($networks = get_field("reseaux_sociaux", "informations_generales")): ?>
                            <?php foreach ($networks as $network): ?>
                                <a class="mx-2" href="<?php echo $network["url"] ?>" target="_blank">
                                    <i class="bi bi-<?php echo $network["slug"] ?>"></i>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-xl-2">
                <div class="h2 mt-4 mb-3">
                    <?php echo wp_get_nav_menu_name('footer_1') ?>
                </div>
                <ul>
                    <?php wp_nav_menu(array('container' => '', 'theme_location' => 'footer_1', 'menu_class' => 'menu', 'menu_id' => 'menu-main-menu', 'link_before' => '', 'link_after' => '', 'items_wrap' => '%3$s')); ?>
                </ul>
            </div>
            <div class="col-sm-12 col-xl-2">
                <div class="h2 mt-4 mb-3">
                    <?php echo wp_get_nav_menu_name('footer_2') ?>
                </div>
                <ul>
                    <?php wp_nav_menu(array('container' => '', 'theme_location' => 'footer_2', 'menu_class' => 'menu', 'menu_id' => 'menu-main-menu', 'link_before' => '', 'link_after' => '', 'items_wrap' => '%3$s')); ?>
                </ul>
            </div>

            <div class="col-sm-12 col-xl-2">
                <div class="h2 mt-4 mb-3">
                    <?php echo wp_get_nav_menu_name('footer_3') ?>
                </div>
                <ul>
                    <?php wp_nav_menu(array('container' => '', 'theme_location' => 'footer_3', 'menu_class' => 'menu', 'menu_id' => 'menu-main-menu', 'link_before' => '', 'link_after' => '', 'items_wrap' => '%3$s')); ?>
                </ul>
            </div>

            <div class="col-sm-12 col-xl-2">
                <div class="h2 mt-4 mb-3">
                    <?php _e("Nous retrouver") ?>
                </div>

                <a class="footer-info d-block d-sm-flex align-items-center mb-3 target=" _blank" href="http://maps.google.com/?q=<?php echo get_field("adresse", "informations_generales") ?>">
                    <i class="bi bi-geo-alt"></i>
                    <div class="ms-3">
                        <?php echo get_field("adresse", "informations_generales") ?>
                    </div>
                </a>
                <a class="footer-info d-block d-sm-flex align-items-center mb-3" href="tel:<?php echo phone_format(get_field("telephone", "informations_generales")) ?>">
                    <i class="bi bi-telephone"></i>
                    <div class="ms-3">
                        <?php echo get_field("telephone", "informations_generales") ?>
                    </div>
                </a>
                <div class="footer-info d-block d-sm-flex align-items-center">
                    <i class="bi bi-clock"></i>
                    <div class="ms-3">
                        <?php echo get_field("hours", "informations_generales") ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section id="footer-bottom">
        <div class="container h-100 d-flex align-items-center justify-content-center">
            <ul class="d-sm-flex">
                <?php wp_nav_menu(array('container' => '', 'theme_location' => 'copyright', 'menu_class' => 'menu', 'menu_id' => 'menu-main-menu', 'link_before' => '', 'link_after' => '', 'items_wrap' => '%3$s')); ?>
            </ul>
        </div>
    </section>
</footer>
<?php wp_footer(); ?>
</body>

</html>
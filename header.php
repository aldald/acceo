<?php

/**
 * Header
 *
 * @package churchill
 */
defined('ABSPATH') || exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <!-- HEADER PRINCIPAL -->
    <header id="header_wrapper">

        <nav class="navbar navbar-expand-xl d-block autohide bg-white mx-2 my-2">
            <!-- Topbar Desktop -->
            <div class="top-bar-desktop">
                <div class="topbar-content">
                    <!-- Menu Topbar à Gauche -->
                    <nav class="topbar-nav">
                        <?php
                        if (has_nav_menu('topbar-menu')) {
                            wp_nav_menu(array(
                                'theme_location' => 'topbar-menu',
                                'menu_id' => 'topbar-menu',
                                'container' => false,
                                'depth' => 1,
                                'fallback_cb' => false,
                                'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                            ));
                        }
                        ?>
                    </nav>

                    <!-- Boutons CTA + Recherche Desktop -->
                    <div class="d-flex align-items-center">
                        <!-- Boutons CTA -->
                        <div class="cta-menu">
                            <?php
                            $locations = get_nav_menu_locations();
                            $menu_id = $locations['principal'] ?? null;
                            if ($menu_id && ($boutons = get_field("boutons", wp_get_nav_menu_object($menu_id)))):
                            ?>
                                <?php foreach ($boutons as $bouton): ?>
                                    <?php if ($lien = $bouton["lien"] ?? null): ?>
                                        <a href="<?php echo esc_url($lien["url"]); ?>"
                                            class="btn btn-primary ms-lg-3"
                                            <?php if (!empty($lien["target"])): ?>target="<?php echo esc_attr($lien["target"]); ?>" rel="noopener noreferrer" <?php endif; ?>
                                            data-label="<?php echo esc_attr($lien["title"]); ?>">
                                            <?php echo esc_html($lien["title"]); ?>
                                        </a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <!-- Icône Recherche Desktop -->
                        <a href="#search-form"
                            class="search-trigger ms-4 d-none d-lg-flex"
                            data-bs-toggle="collapse"
                            aria-expanded="false"
                            role="button"
                            aria-controls="search-form">
                            <i class="bi bi-search"></i><?php _e("Rechercher", "churchill") ?>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Formulaire de recherche en overlay (collapse) -->
            <div id="search-form" class="collapse search-overlay">
                <div class="container">
                    <button type="button" class="search-close" data-bs-toggle="collapse" data-bs-target="#search-form">
                        <i class="bi bi-x"></i>
                    </button>
                    <form class="d-flex py-3 position-relative" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                        <input placeholder="<?php _e("Rechercher sur le site", "churchill") ?>"
                            type="search"
                            name="s"
                            value="<?php echo get_search_query(); ?>"
                            autofocus>
                        <button type="submit" class="btn btn-primary ms-4">
                            <?php _e("Rechercher", "churchill"); ?>
                        </button>
                    </form>
                </div>
            </div>

            <div class="d-flex align-items-center px-4 g-0 bar-menu">
                <!-- Logo -->
                <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
                    <img class="d-none d-xl-inline"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo.svg"
                        alt="<?php bloginfo("name") ?>" />
                    <img class="d-xl-none"
                        src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo-mobile.svg"
                        alt="<?php bloginfo("name") ?>" />
                </a>

                <!-- Bouton Hamburger Mobile -->
                <button class="navbar-toggler collapsed"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#primary-menu"
                    aria-controls="primary-menu"
                    aria-expanded="false"
                    aria-label="<?php _e('Afficher le menu', 'churchill'); ?>">
                    <i id="menu-closed" class="bi bi-list"></i>
                    <i id="menu-opened" class="bi bi-x"></i>
                </button>

                <!-- Menu Principal -->
                <div class="collapse navbar-collapse" id="primary-menu">


                    <!-- Topbar Mobile (dans le menu hamburger) -->
                    <div class="top-bar-mobile d-xl-none">
                        <ul id="topbar-menu-mobile">
                            <?php
                            if (has_nav_menu('topbar-menu')) {
                                wp_nav_menu(array(
                                    'theme_location' => 'topbar-menu',
                                    'menu_id' => 'topbar-mobile-items',
                                    'container' => false,
                                    'depth' => 1,
                                    'fallback_cb' => false,
                                    'items_wrap' => '%3$s',
                                    'walker' => new Walker_Nav_Menu()
                                ));
                            }
                            ?>
                        </ul>
                    </div>

                    <!-- Recherche Mobile (dans le menu hamburger) -->
                    <form id="mobile-search-form"
                        class="d-flex d-xl-none pb-3 position-relative"
                        method="get"
                        action="<?php echo esc_url(home_url('/')); ?>">
                        <input placeholder="<?php _e("Rechercher sur le site", "churchill") ?>"
                            type="search"
                            class="form-control"
                            name="s"
                            value="<?php echo get_search_query(); ?>">
                        <button type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>

                    <!-- Navigation -->
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <?php
                        wp_nav_menu(array(
                            'container' => '',
                            'theme_location' => 'principal',
                            'menu_class' => 'menu',
                            'menu_id' => 'menu-main-menu',
                            'link_before' => '',
                            'link_after' => '',
                            'items_wrap' => '%3$s',
                            'walker' => new Bootstrap_5_MegaMenu_Walker()
                        ));
                        ?>
                    </ul>

                    <!-- Boutons CTA Mobile -->
                    <div class="cta-menu-mobile d-xl-none">
                        <?php
                        $locations = get_nav_menu_locations();
                        $menu_id = $locations['principal'] ?? null;
                        if ($menu_id && ($boutons = get_field("boutons", wp_get_nav_menu_object($menu_id)))):
                        ?>
                            <?php foreach ($boutons as $bouton): ?>
                                <?php if ($lien = $bouton["lien"] ?? null): ?>
                                    <a href="<?php echo esc_url($lien["url"]); ?>"
                                        class="btn btn-primary w-100"
                                        <?php if (!empty($lien["target"])): ?>target="<?php echo esc_attr($lien["target"]); ?>" rel="noopener noreferrer" <?php endif; ?>>
                                        <?php echo esc_html($lien["title"]); ?>
                                    </a>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Réseaux Sociaux Mobile -->
                    <div class="d-lg-none pt-5" id="nav-mobile-social-network">
                        <?php if ($networks = get_field("reseaux_sociaux", "informations_generales")): ?>
                            <?php foreach ($networks as $network): ?>
                                <a href="<?php echo esc_url($network["url"]); ?>" target="_blank" rel="noopener noreferrer">
                                    <i class="bi bi-<?php echo esc_attr($network["slug"]); ?>"></i>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>
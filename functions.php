<?php
require_once 'functions/hook-theme-setup.php';
require_once 'functions/hook-enqueue-scripts.php';
require_once 'functions/hook-enqueue-styles.php';
require_once 'functions/hook-tinymce-shortcodes.php';
require_once 'functions/hook-load-acf-builder-fields.php';
require_once 'functions/hook-load-contact-informations.php';
require_once 'functions/hook-load-acf-buttons-menu-fields.php';
require_once 'functions/hook-theme-colors.php';
require_once 'functions/hook-table-module.php';
require_once 'functions/hook-custom-wysiwyg-tools.php';
require_once 'functions/function-bootstrap5-pagination.php';
require_once 'functions/function-bootstrap5-yoast-breadcrumb.php';
require_once 'functions/function-custom-excerpt.php';
require_once 'functions/function-encode-email.php';
require_once 'functions/function-get-image-alt.php';
require_once 'functions/function-get-primary-category.php';
require_once 'functions/function-phone-format.php';
require_once 'functions/function-the-summary.php';
require_once 'functions/function-get-reading-time.php';
require_once 'functions/class-bootstrap5-nav-walker.php';
require_once 'functions/hook-topbar-menu-icons.php';
require_once 'functions/function-parse-colored-text.php';
require_once 'functions/hook-cpt-realisation.php';
require_once 'functions/hook-cpt-faq.php';
require_once 'functions/hook-cpt-mission.php';
require_once 'functions/function-render-blog-card.php';
require_once 'functions/function-render-actualite-card.php';
require_once 'functions/class-bootstrap5-megamenu-walker.php';
require_once 'functions/function-render-button.php';
require_once 'functions/function-render-category-badge.php';
require_once 'functions/function-acf-icon-picker.php';
require_once 'functions/hook-cpt-expertise.php';


add_action('admin_enqueue_scripts', function ($hook) {
    if (isset($_GET['page']) && (($_GET['page'] === 'blog_composant') || ($_GET['page'] === 'blog_category_composant')))  {
        wp_enqueue_editor();
        wp_enqueue_media();
        add_editor_style();
    }
});
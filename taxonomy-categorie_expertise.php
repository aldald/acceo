<?php
/**
 * Template pour les archives de catégories de expertises
 * 
 * @package churchill
 */

defined('ABSPATH') || exit;

get_header();

// Récupérer la catégorie actuelle
$current_category = get_queried_object();

// Rendre la catégorie accessible pour les composants
global $current_expertise_category;
$current_expertise_category = $current_category;
?>

<main class="category-expertise-page">

    <?php
    get_template_part('template-parts/builder', '', array("context" => 'categorie_expertise_' . $current_category->term_id));
    ?>

</main>

<?php
get_footer();
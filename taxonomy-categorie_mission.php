<?php
/**
 * Template pour les archives de catégories de missions
 * 
 * @package churchill
 */

defined('ABSPATH') || exit;

get_header();

// Récupérer la catégorie actuelle
$current_category = get_queried_object();

// Rendre la catégorie accessible pour les composants
global $current_mission_category;
$current_mission_category = $current_category;
?>

<main class="category-mission-page">

    <?php
    get_template_part('template-parts/builder', '', array("context" => 'categorie_mission_' . $current_category->term_id));
    ?>

</main>

<?php
get_footer();
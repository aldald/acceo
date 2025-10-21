<?php

defined('ABSPATH') || exit;
?>
<?php get_header(); ?>
    <main>
        <?php get_template_part('template-parts/builder','',array("context"=>get_the_ID())) ?>
    </main>
<?php get_footer(); ?>
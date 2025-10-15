<?php get_header();?>
<section>
    <div class="container">
        <div id="section-404" class="my-5 p-5 d-flex text-center justify-content-center align-items-center bg-3c3c3b">
            <div>
                <h1 class="d-flex align-items-center justify-content-center">404</h1>
                <p class="mb-5">
                    <?php _e("La page que vous recherchez n’existe pas.")?>
                </p>
                <a class="btn btn-primary mx-2 mb-3" href="<?php echo get_permalink(909)?>">
                    <?php _e("Consulter nos cuisines")?>
                </a>
                <a data-label="<?php _e("Retour à la page d’accueil")?>" class="btn btn-fourth mx-2  mb-3" href="<?php bloginfo("url")?>">
                    <?php _e("Retour à la page d’accueil")?>
                </a>
            </div>
        </div>
    </div>
</section>
<?php get_footer();?>
<?php
/**
 * Composant : Profils Équipe
 *
 * @package churchill
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Récupérer les champs
$chapo_composant = get_sub_field('chapo_composant');
$titre_composant = get_sub_field('titre_composant');
$texte_introduction = get_sub_field('texte_introduction');
$membres_equipe = get_sub_field('membres_equipe');

// Vérifier qu'il y a des membres
if (!$membres_equipe || empty($membres_equipe)) return;
?>

<div class="profils-equipe-wrapper">
    <div class="container">

        <!-- Header - 8 colonnes max -->
        <div class="row">
            <div class="col-lg-8 col-md-12">

                <?php if ($chapo_composant): ?>
                    <p class="profils-equipe-chapo"><?php echo esc_html($chapo_composant); ?></p>
                <?php endif; ?>

                <?php if ($titre_composant): ?>
                    <div class="title-heading">
                        <h2><?php echo display_colored_title($titre_composant); ?></h2>
                    </div>
                <?php endif; ?>

                <?php if ($texte_introduction): ?>
                    <div class="profils-equipe-intro">
                        <?php echo wp_kses_post($texte_introduction); ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>

        <div class="row g-4 profils-equipe-grid">
            
            <?php foreach ($membres_equipe as $membre): 
                $photo = $membre['photo_profil'];
                $nom_prenom = $membre['nom_prenom_profil'];
                $fonction = $membre['fonction_profil'];
            ?>

                <div class="col-lg-2 col-md-3 col-sm-4 col-6">
                    <div class="profil-card">
                        
                        <!-- Photo ronde -->
                        <div class="profil-photo">
                            <img src="<?php echo esc_url($photo['url']); ?>"
                                 alt="<?php echo esc_attr($nom_prenom); ?>"
                                 loading="lazy">
                        </div>

                        <!-- Nom et prénom -->
                        <h5 class="profil-nom"><?php echo esc_html($nom_prenom); ?></h5>

                        <!-- Fonction -->
                        <p class="profil-fonction"><?php echo esc_html($fonction); ?></p>

                    </div>
                </div>

            <?php endforeach; ?>

        </div>

    </div>
</div>
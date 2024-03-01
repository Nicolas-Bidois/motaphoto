<?php

// Boucle WordPress
$args = array(
    'post_type' => 'photo', 
    'post_status' => 'publish', // Sélectionner uniquement les articles publiés
    'posts_per_page' => 8, // Nombre d'articles à afficher
    'orderby' => 'rand'
);

// Effectuer la requête WP_Query
$query = new WP_Query($args);

// Boucle WordPress
while ($query->have_posts()) : $query->the_post();

    // Récupérer l'URL de l'image 
    $image_url = get_the_post_thumbnail_url(get_the_ID(), '');

    // Vérifier si une image existe
    if ($image_url) {
        // Afficher l'image avec la classe .photo-apparenté
        echo '<img src="' . esc_url($image_url) . '" alt="Image de l\'article" class="photo-apparenté">';
    }

    // Afficher le contenu de l'article
    the_content();

endwhile;

// Réinitialiser les données de la requête principale
wp_reset_postdata();


?>
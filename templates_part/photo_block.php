 <?php
        function display_related_photos() {
            $post_id = get_the_ID();
            $terms = get_the_terms($post_id, 'categorie');
    
            if ($terms && !is_wp_error($terms)) {
                $term_name = $terms[0]->name;
    
                if ($term_name) {
    
                    $related_posts_args = array(
                        'tax_query' => array(
                            array(
                                'taxonomy' => "categorie",
                                'field' => 'slug',
                                'terms' => $term_name,
                            ),
                        ),
                        'posts_per_page' => 2, // Limiter le nombre de résultats à 2
                        'orderby' => 'rand', // Mélanger les résultats de manière aléatoire
                    );
                    $related_posts_query = new WP_Query($related_posts_args);
    
                    if ($related_posts_query->have_posts()) {
                        while ($related_posts_query->have_posts()) {
                            $related_posts_query->the_post();
    
                            $content = get_post_field('post_content', get_the_ID());
    
                            preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
    
                            if (!empty($matches[1])) {
                                echo '<img src="' . esc_url($matches[1][0]) . '" class="photo-apparenté" alt="' . esc_attr(get_the_title()) . '" />';
                            } else {
                                echo 'Aucune image trouvée dans le contenu de l\'article.';
                            }
                        }
                        wp_reset_postdata(); 
                    } else {
                        echo 'Aucune photo apparentée trouvée dans la même catégorie.';
                    }
                } else {
                    echo 'Aucune catégorie trouvée pour cet article.';
                }
            } else {
                echo 'Erreur lors de la récupération des catégories.';
            }
        }
    
        // Div complète avec le contenu
        echo '<div>
                <h3>VOUS AIMEREZ AUSSI</h3>
                <div class="photos-apparentées">';
        display_related_photos();
        echo '</div>
                <a href="http://motaphoto.local/"><button type="button" class="afficher-toutes-les-photos wpcf7-form-control wpcf7-submit">Toutes les photos</button></a>
              </div>';
?>


<?php

function afficher_image_avec_classe_photo_couverture() {
    // Boucle WordPress
    $args = array(
        'post_type'      => 'photo', 
        'post_status'    => 'publish', // Sélectionner uniquement les articles publiés
        'posts_per_page' => 1, // Nombre d'articles à afficher
        'orderby'        => 'rand'
    );

    // Effectuer la requête WP_Query
    $query = new WP_Query($args);

    // Boucle WordPress
    while ($query->have_posts()) : $query->the_post();

        // Récupérer l'URL de l'image 
        $image_url = get_the_post_thumbnail_url(get_the_ID(), '');


    
        the_content();

    endwhile;

    // Réinitialiser les données de la requête principale
    wp_reset_postdata();
}

// Appeler la fonction pour afficher l'image avec la classe ajoutée
afficher_image_avec_classe_photo_couverture();
?>

<?php

// Fonction pour afficher les photos avec la classe photo-apparenté
function display_random_photos() {
    $args = array(
        'post_type' => 'photo', 
        'post_status' => 'publish', // Sélectionner uniquement les articles publiés
        'posts_per_page' => 8, // Nombre d'articles à afficher
        'orderby' => 'rand'
    );

    $query = new WP_Query($args);

    while ($query->have_posts()) : $query->the_post();

        $image_url = get_the_post_thumbnail_url(get_the_ID(), '');

        if ($image_url) {
            echo '<img src="' . esc_url($image_url) . '" alt="Image de l\'article" class="photo-apparenté">';
        }

        the_content();

    endwhile;

    wp_reset_postdata();
}

?>



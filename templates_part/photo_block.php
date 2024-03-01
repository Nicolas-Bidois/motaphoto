<div>
    <h3>VOUS AIMEREZ AUSSI</h3>
    <div class="photos-apparentées">
        <?php
        function display_related_photos()
        {
            $post_id = get_the_ID();
            $terms = get_the_terms($post_id, 'categorie');

            // Check if terms are found
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

                    // Vérifier s'il y a des articles dans la même catégorie
                    if ($related_posts_query->have_posts()) {
                        while ($related_posts_query->have_posts()) {
                            $related_posts_query->the_post();

                            // Récupérer le contenu de l'article
                            $content = get_post_field('post_content', get_the_ID());

                            // Utiliser une expression régulière pour extraire les balises <img>
                            preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);

                            // Afficher l'image
                            if (!empty($matches[1])) {
                                // Utiliser la classe dans votre balise img en appelant la fonction
                                echo '<img src="' . esc_url($matches[1][0]) . '" class="photo-apparenté" alt="' . esc_attr(get_the_title()) . '" />';
                            } else {
                                echo 'Aucune image trouvée dans le contenu de l\'article.';
                            }
                        }
                        wp_reset_postdata(); // Réinitialiser les données de l'article
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

        // Appeler la fonction pour afficher les photos apparentées
        display_related_photos();
        ?>
    </div>
    <a href="http://motaphoto.local/"><button type="button" class="afficher-toutes-les-photos wpcf7-form-control wpcf7-submit">Toutes les photos</button></a>
</div>







</div>
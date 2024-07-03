<?php
add_theme_support( 'post-thumbnails' ); 
 function enregistrement_des_menus()
{
    register_nav_menus(
        array(
            'menu-principal' => __('Menu Principal', 'mota'),
            'menu-footer' => __('Menu Footer', 'mota'),
        )
    );
}
add_action('after_setup_theme', 'enregistrement_des_menus');
?>



<?php function afficherImage()
{
    $cheminImage = 'http://motaphoto.local/wp-content/uploads/2024/05/Logo.png';
    $altText = 'Logo';

    $codeHTML = '<a href="http://motaphoto.local">' . '<img src="' . esc_url($cheminImage) . '" alt="' . esc_attr($altText) . '" class="logo"></a>';
    echo $codeHTML;
}
?>

<?php function ajouter_scripts()
{
    // Enregistrement des scripts 'scripts' et 'lightbox-script'
    wp_enqueue_script('scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '', true);
    wp_enqueue_script('lightbox-script', get_template_directory_uri() . '/js/lightbox.js', array('jquery'), '', true);

    // Définition de 'ajaxurl' pour les scripts 'scripts' et 'lightbox-script'
    /*wp_localize_script('scpt', 'ajaxurl', admin_url('admin-ajax.php'));
    wp_localize_script('lieeraghtbox-script', 'ajaxurl', admin_url('admin-ajax.php'));*/
    wp_localize_script( 'ajax-script', 'my_ajax_object',
            array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action('wp_enqueue_scripts', 'ajouter_scripts');


?>


<?php // Fonction pour récupérer les classes du format de l'image pour le conteneur
function get_image_container_classes()
{
    // Récupérer le format de l'image
    $image_format = get_the_terms(get_the_ID(), 'format')[0]->name;

    // Définir des classes spécifiques selon le format de l'image
    $classes = array();

    if ($image_format === 'PAYSAGE') {
        // Ajouter les classes pour le format paysage
        $classes[] = 'photo-info-container';
    } elseif ($image_format === 'PORTRAIT') {
        // Ajouter les classes pour le format portrait
        $classes[] = 'photo-info-container-portrait';
    }

    // Retourner les classes sous forme de chaîne séparée par des espaces
    return implode(' ', $classes);
}
?>
<?php
// Fonction pour récupérer les classes pour un autre élément en fonction du format de l'image
function get_full_photo_classes() {
    // Récupérer le format de l'image
    $image_format = get_the_terms(get_the_ID(), 'format')[0]->name;

    // Définir des classes spécifiques selon le format de l'image pour l'autre élément
    $classes = array();

    if ($image_format === 'Paysage') {
        // Ajouter les classes pour le format paysage
        $classes[] = 'full-photo';
    } elseif ($image_format === 'Portrait') {
        // Ajouter les classes pour le format portrait
        $classes[] = 'portrait-full-photo';
    }

    // Retourner les classes sous forme de chaîne séparée par des espaces
    return implode(' ', $classes);
} 
?>

<?php
// Fonction pour récupérer les classes pour un autre élément en fonction du format de l'image
function get_photo_couverture_classes() {
    // Récupérer le format de l'image
    $image_format = get_the_terms(get_the_ID(), 'format')[0]->name;

    // Définir des classes spécifiques selon le format de l'image pour l'autre élément
    $classes = array();

    if ($image_format === 'PAYSAGE') {
        // Ajouter les classes pour le format paysage
        $classes[] = 'paysage-couverture';
    } elseif ($image_format === 'PORTRAIT') {
        // Ajouter les classes pour le format portrait
        $classes[] = 'portrait-couverture';
    } else {
        // Ajouter une classe par défaut si aucun cas n'est rencontré
        $classes[] = 'autre-format-couverture';
    }

    // Retourner les classes sous forme de chaîne séparée par des espaces
    return implode(' ', $classes);
}

?>


<?php
// Fonction pour récupérer les classes pour un autre élément en fonction du format de l'image
function get_thumbnail_classes() {
    // Récupérer le format de l'image
    $image_format = get_the_terms(get_the_ID(), 'format')[0]->name;

    // Définir des classes spécifiques selon le format de l'image pour l'autre élément
    $classes = array();

    if ($image_format === 'PORTRAIT') {
        // Ajouter les classes pour le format paysage
        $classes[] = 'thumbnail';
    } elseif ($image_format === 'PAYSAGE') {
        // Ajouter les classes pour le format portrait
        $classes[] = 'paysage-thumbnail';
    }

    // Retourner les classes sous forme de chaîne séparée par des espaces
    return implode(' ', $classes);
} 
?>


<?php
// Fonction pour récupérer les classes pour un autre élément en fonction du format de l'image
function get_photo_block_classes() {
    // Récupérer le format de l'image
    $image_format = get_the_terms(get_the_ID(), 'format')[0]->name;

    // Définir des classes spécifiques selon le format de l'image pour l'autre élément
    $classes = array();

    if ($image_format === 'PAYSAGE') {
        // Ajouter les classes pour le format paysage
        $classes[] = 'photo-block';
    } elseif ($image_format === 'PORTRAIT') {
        // Ajouter les classes pour le format portrait
        $classes[] = 'portrait-photo-block';
    }

    // Retourner les classes sous forme de chaîne séparée par des espaces
    return implode(' ', $classes);
} 
?>


<?php
function get_reference_data() {
    $post_id = get_the_ID();
    $reference_data = get_field('reference', $post_id); // Utilisez ACF pour récupérer le champ 'reference'
    return $reference_data;
}
?>




<?php
/////

add_action('wp_ajax_filter_custom_photos', 'filter_custom_photos');
add_action('wp_ajax_nopriv_filter_custom_photos', 'filter_custom_photos');

function filter_custom_photos() {
    $category = $_POST['category'];
    $format = $_POST['format'];
    $order = $_POST['order']; // Ajout de la variable pour le tri

    $args = array(
        'post_type' => 'votre_type_de_contenu_personnalisé',
        'posts_per_page' => -1,
        'tax_query' => array(),
        'meta_query' => array(),
        'orderby' => 'date', // Trier par date par défaut
        'order' => $order, // Utilise la valeur du champ de sélection pour le tri
    );

    // Ajoutez les filtres de taxonomie si sélectionnés
    if (!empty($category)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'category',
            'field' => 'id',
            'terms' => $category,
        );
    }

    if (!empty($format)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'id',
            'terms' => $format,
        );
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            // Réutilisez le bloc d'affichage de photo déjà créé dans l'étape précédente
            get_template_part('template-parts/content', 'photo');
        endwhile;
        wp_reset_postdata();
    else :
        echo 'Aucune photo trouvée.';
    endif;

    wp_die();
}
?>

<?php
// Fonction pour charger plus d'images
function charger_plus_photos() {
    // Récupérer les paramètres envoyés par la requête AJAX
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $images_per_page = 8; // Nombre d'images à charger à chaque fois
    $offset = ($page - 1) * $images_per_page;

    // Arguments de requête pour récupérer les images
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => $images_per_page,
        'offset' => $offset,
        'orderby' => 'rand'
    );

    // Effectuer la requête WP_Query pour récupérer les images
    $query = new WP_Query($args);

    // Initialise la variable de sortie
    $output = '';

    // Boucle WordPress pour afficher les images
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            // Récupérer l'ID de l'article parent de l'article en cours
            $parent_post_id = wp_get_post_parent_id(get_the_ID());

            // Récupérer l'objet de l'article parent
            $parent_post = get_post($parent_post_id);

            // Récupérer le slug de l'article parent
            $parent_post_slug = ($parent_post) ? $parent_post->post_name : '';

            // Récupérer le contenu de l'article
            $content = get_post_field('post_content', get_the_ID());

            // Rechercher les balises d'images dans le contenu de l'article
            preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);

            // Vérifier si des images ont été trouvées
            if (!empty($matches[1])) {
                // Commencer la construction de la sortie
                $output .= '<div class="photo-ajust">
                                <div class="photo-wrapper">
                                    <img src="' . esc_url($matches[1][0]) . '" class="photo-apparenté2" alt="' . esc_attr(get_the_title()) . '">       
                                    <div class="imginfoex">            
                                        <div class="overlay"></div> <!-- Overlay pour la teinte foncée -->
                                        <i class="fas fa-expand expand-icon"></i>
                                        <a href="' . get_permalink() . '"><i class="fas fa-eye eye"></i></a>';

                // Ajouter le slug de l'article parent s'il est défini
                if ($parent_post_slug) {
                    $output .= '<p class="slug">' . esc_html($parent_post_slug) . '</p>';
                }

                // Continuer la construction de la sortie
                $output .= '<p class="reference">' . get_reference_data() . '</p>
                                    <p class="term">' . esc_html(get_the_terms(get_the_ID(), 'categorie')[0]->name) . '</p>
                                </div>
                            </div>
                        </div>';
            } else {
                $output .= 'Aucune image trouvée dans le contenu de l\'article.';
            }
        }
        wp_reset_postdata();
    } else {
        $output .= 'Aucune photo trouvée.';
    }

    echo $output; // Renvoyer la sortie
    exit; // Arrêter l'exécution après avoir renvoyé les images
}




// Ajouter une action pour le traitement AJAX
add_action('wp_ajax_charger_plus_photos', 'charger_plus_photos');
add_action('wp_ajax_nopriv_charger_plus_photos', 'charger_plus_photos');


function enqueue_lightbox_script() {
    wp_enqueue_script('lightbox-script', get_template_directory_uri() . '/js/lightbox.js', array('jquery'), null, true);
    wp_enqueue_style('lightbox-style', get_template_directory_uri() . '/css/lightbox.css', array(), null);
}
add_action('wp_enqueue_scripts', 'enqueue_lightbox_script');


// fonction pour les filtres

// Enregistrer et localiser le script JavaScript
add_action('wp_ajax_filter_photos_by_category', 'filter_photos_by_category');
add_action('wp_ajax_nopriv_filter_photos_by_category', 'filter_photos_by_category');

// Action pour les utilisateurs connectés
add_action('wp_ajax_filter_photos_by_format', 'filter_photos_by_format');
add_action('wp_ajax_nopriv_filter_photos_by_format', 'filter_photos_by_format');

function filter_photos_by_format() {
    $format_id = $_POST['format_id'];

    // Appeler la fonction display_photos avec le type 'format' et l'ID du format
    $output = display_photos('format', 0, $format_id); // 0 ou null pour le $category_id si non utilisé

    // Retourner la sortie générée par display_photos
    echo $output;

    // Terminer la requête AJAX
    wp_die();
}





function filter_photos_by_category() {
    $category_id = $_POST['category_id'];
    $type = $_POST['type'];
    $output = display_photos($type, $category_id);

    echo $output;

    wp_die();
}


//////*function display photo*///////
function display_photos($type, $category_id = null, $format_id = null, $order = 'DESC') {
    $output = ''; // Initialise la variable de sortie

    if ($type == 'related') {
        if (is_single()) {
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
                        'posts_per_page' => 2,
                        'orderby' => 'rand',
                    );
                    $related_posts_query = new WP_Query($related_posts_args);

                    if ($related_posts_query->have_posts()) {
                        while ($related_posts_query->have_posts()) {
                            $related_posts_query->the_post();

                            $parent_post_id = wp_get_post_parent_id(get_the_ID());
                            $parent_post = get_post($parent_post_id);
                            $parent_post_slug = ($parent_post) ? $parent_post->post_name : '';
                            $content = get_post_field('post_content', get_the_ID());
                            preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);

                            if (!empty($matches[1])) {
                                $output .= '<div class="photo-ajust">
                                                <div class="photo-wrapper">
                                                    <img src="' . esc_url($matches[1][0]) . '" class="photo-apparenté" alt="' . esc_attr(get_the_title()) . '">       
                                                    <div class="imginfoex">            
                                                        <div class="overlay"></div>
                                                        <i class="fas fa-expand expand-icon"></i>
                                                        <a href="' . get_permalink() . '"><i class="fas fa-eye eye"></i></a>';

                                if ($parent_post_slug) {
                                    $output .= '<p class="slug">' . esc_html($parent_post_slug) . '</p>';
                                }

                                $output .= '<p class="reference">' . get_reference_data() . '</p>
                                            <p class="term">' . esc_html($term_name) . '</p>
                                            </div>
                                        </div>
                                    </div>';
                            } else {
                                $output .= 'Aucune image trouvée dans le contenu de l\'article.';
                            }
                        }
                        wp_reset_postdata(); 
                    } else {
                        $output .= 'Aucune photo apparentée trouvée dans la même catégorie.';
                    }
                } else {
                    $output .= 'Aucune catégorie trouvée pour cet article.';
                }
            } else {
                $output .= 'Erreur lors de la récupération des catégories.';
            }
        }
    } elseif ($type == 'random') {
        $args = array(
            'post_type' => 'photo', 
            'post_status' => 'publish',
            'posts_per_page' => 8, // Afficher initialement 8 images
            'orderby' => 'rand', // Ordre aléatoire par défaut
        );
    
        if ($category_id) { // Vérifie si une catégorie est sélectionnée
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'categorie',
                    'field' => 'term_id',
                    'terms' => $category_id,
                )
            );
        }
    
        if ($format_id) { // Vérifie si un format est sélectionné
            $args['tax_query'][] = array(
                array(
                    'taxonomy' => 'format',
                    'field' => 'term_id',
                    'terms' => $format_id,
                )
            );
        }

        $query = new WP_Query($args);
    
        while ($query->have_posts()) : $query->the_post();
    
            $parent_post_id = wp_get_post_parent_id(get_the_ID());
            $parent_post = get_post($parent_post_id);
            $parent_post_slug = ($parent_post) ? $parent_post->post_name : '';
            $content = get_post_field('post_content', get_the_ID());
            preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);
    
            if (!empty($matches[1])) {
                $output .= '<div class="photo-ajust">
                                <div class="photo-wrapper">
                                    <img src="' . esc_url($matches[1][0]) . '" class="photo-apparenté2" alt="' . esc_attr(get_the_title()) . '">       
                                    <div class="imginfoex">            
                                        <div class="overlay"></div>
                                        <i class="fas fa-expand expand-icon"></i>
                                        <a href="' . get_permalink() . '"><i class="fas fa-eye eye"></i></a>';
    
                if ($parent_post_slug) {
                    $output .= '<p class="slug">' . esc_html($parent_post_slug) . '</p>';
                }
    
                $output .= '<p class="reference">' . get_reference_data() . '</p>
                            <p class="term">' . esc_html(get_the_terms(get_the_ID(), 'categorie')[0]->name) . '</p>
                            </div>
                        </div>
                    </div>';
            } else {
                $output .= 'Aucune image trouvée dans le contenu de l\'article.';
            }
    
        endwhile;
    
        wp_reset_postdata();
    } elseif ($type == 'category' || $type == 'format' || $type == 'combined') {
        // Arguments de base pour la requête WP_Query
        $args = array(
            'post_type' => 'photo',
            'post_status' => 'publish',
            'posts_per_page' => -1, // Afficher toutes les images
            'orderby' => 'date',
            'order' => $order,
        );

        // Filtrage par catégorie et/ou format
        $tax_query = array();
        if ($category_id) {
            $tax_query[] = array(
                'taxonomy' => 'categorie',
                'field' => 'term_id',
                'terms' => $category_id,
            );
        }
        if ($format_id) {
            $tax_query[] = array(
                'taxonomy' => 'format',
                'field' => 'term_id',
                'terms' => $format_id,
            );
        }
        if (!empty($tax_query)) {
            $args['tax_query'] = $tax_query;
        }

        $query = new WP_Query($args);

        while ($query->have_posts()) : $query->the_post();

            $parent_post_id = wp_get_post_parent_id(get_the_ID());
            $parent_post = get_post($parent_post_id);
            $parent_post_slug = ($parent_post) ? $parent_post->post_name : '';
            $content = get_post_field('post_content', get_the_ID());
            preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);

            if (!empty($matches[1])) {
                $output .= '<div class="photo-ajust">
                                <div class="photo-wrapper">
                                    <img src="' . esc_url($matches[1][0]) . '" class="photo-apparenté2" alt="' . esc_attr(get_the_title()) . '">       
                                    <div class="imginfoex">            
                                        <div class="overlay"></div>
                                        <i class="fas fa-expand expand-icon"></i>
                                        <a href="' . get_permalink() . '"><i class="fas fa-eye eye"></i></a>';

                if ($parent_post_slug) {
                    $output .= '<p class="slug">' . esc_html($parent_post_slug) . '</p>';
                }

                $output .= '<p class="reference">' . get_reference_data() . '</p>
                            <p class="term">' . esc_html(get_the_terms(get_the_ID(), 'categorie')[0]->name) . '</p>
                            </div>
                        </div>
                    </div>';
            } else {
                $output .= 'Aucune image trouvée dans le contenu de l\'article.';
            }

        endwhile;

        wp_reset_postdata();
    } else {
        $output .= 'Type de requête non valide.';
    }

    return $output;
}



add_action('wp_ajax_filter_photos', 'ajax_filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'ajax_filter_photos');

function ajax_filter_photos() {
    // Récupération des données envoyées en POST
    $type = isset($_POST['type']) ? sanitize_text_field($_POST['type']) : 'random';
    $category_id = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;
    $format_id = isset($_POST['format_id']) ? intval($_POST['format_id']) : 0;
    $order = isset($_POST['order']) ? sanitize_text_field($_POST['order']) : 'DESC';

    // Vérification du type de requête
    if ($type === 'combined') {
        // Filtrer par catégorie, format et ordre
        echo display_photos('combined', $category_id, $format_id, $order);
    } else {
        echo 'Type de requête non valide.';
    }

    // Termination de la requête AJAX
    wp_die();
}

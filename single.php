<?php get_header(); ?>
<?php if (have_posts()):
    while (have_posts()):
        the_post();
        ?>
        <div class="<?php echo esc_attr(get_image_container_classes()); ?> container">
            <div class="info-block">
                <h1 class="entry-title">
                    <?php the_title(); ?>
                </h1>
                <p>RÉFÉRENCE :
    <?php 
    $nom_du_champ = 'reference';
    $valeur_du_champ = get_field($nom_du_champ);
    echo esc_html($valeur_du_champ);
    ?>
</p>
<script>
    var reference_data = <?php echo json_encode($valeur_du_champ); ?>;
</script>
                <p>CATÉGORIE :
                    <?php echo get_the_terms(get_the_ID(), 'categorie')[0]->name; ?>
                </p>
                <p>FORMAT :
                    <?php echo get_the_terms(get_the_ID(), 'format')[0]->name; ?>
                </p>
                <p>TYPE :
                    <?php $nom_du_champ = 'Type';
                        $valeur_du_champ = get_field($nom_du_champ);
                        echo $valeur_du_champ;
                        ?>
                 <p class="t-none">Titre :
                    <?php $nom_du_champ = 'titre';
                        $valeur_du_champ = get_field($nom_du_champ);
                        echo $valeur_du_champ;
                        ?>  
                </p>
                <p>ANNÉE :
                <?php $nom_du_champ = 'date';
                        $valeur_du_champ = get_field($nom_du_champ);
                        echo $valeur_du_champ;
                        ?>

                </p>
                <!-- Ajoutez d'autres informations spécifiques à votre type de contenu ici -->
            </div>

            <div class="<?php echo esc_attr(get_photo_block_classes()); ?>">
                <?php
                // Récupérer le contenu de l'article
                $content = get_post_field('post_content', get_the_ID());

                // Utiliser une expression régulière pour extraire les balises <img>
                preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);

                // Afficher la première image trouvée
                if (!empty($matches[1])) {
                    // Utiliser la classe dans votre balise img en appelant la fonction
                    echo '<img src="' . esc_url($matches[1][0]) . '" class="' . get_full_photo_classes() . '" alt="' . esc_attr(get_the_title()) . '" />';

                }
                ?>
            </div>
        </div>
        <div class="bloc container">
            <p class="text-1">Cette photo vous intéresse ?</p>
            <button type="button" class="pos contact-link popup contact-button wpcf7-form-control wpcf7-submit"
                data-photo-ref="<?php echo get_post_meta(get_the_ID(), 'reference_photo', true); ?>">
                Contact
            </button>

            <?php
// Récupérez les ID des photos précédente et suivante dans votre catalogue
$previous_photo = get_previous_post();
$previous_photo_id = is_object($previous_photo) ? $previous_photo->ID : null;

$next_photo_id = get_next_post() ? get_next_post()->ID : null;

// Récupérer le contenu HTML de l'article suivant ou précédent
$html_content_next = '';
$html_content_previous = '';

if ($next_photo_id) {
    $html_content_next = get_post_field('post_content', $next_photo_id);
}

if ($previous_photo_id) {
    $html_content_previous = get_post_field('post_content', $previous_photo_id);
}

// Utilisez preg_match_all pour extraire les URLs d'image
$image_urls_next = array();
preg_match_all('/<img[^>]+src=([\'"])(?<src>.+?)\1/i', $html_content_next, $matches_next);
$image_urls_next = $matches_next['src'];

// Utilisez preg_match_all pour extraire les URLs d'image
$image_urls_previous = array();
preg_match_all('/<img[^>]+src=([\'"])(?<src>.+?)\1/i', $html_content_previous, $matches_previous);
$image_urls_previous = $matches_previous['src'];
?>

<div class="fleches">
    <div class="deusfleches">
    <?php if ($previous_photo_id): ?>
        <a href="<?php echo get_permalink($previous_photo_id); ?>" class="nav-link arrow-left" title="Photo précédente">
            <span class="arrow">&#8592;</span>
        </a>
    <?php endif; ?>

    <?php if ($next_photo_id): ?>
        <a href="<?php echo get_permalink($next_photo_id); ?>" class="nav-link arrow-right" title="Photo suivante">
            <span class="arrow">&#8594;</span>
        </a>
    <?php endif; ?>
    </div>
    <div id="thumbnail-container">
    </div>
</div>

<script>
    <?php if ($previous_photo_id): ?>
    // Événement au survol de la flèche de gauche
    document.querySelector('.arrow-left').addEventListener('mouseover', function () {
        showThumbnail('previous');
    });
    <?php endif; ?>

    <?php if ($next_photo_id): ?>
    // Événement au survol de la flèche de droite
    document.querySelector('.arrow-right').addEventListener('mouseover', function () {
        showThumbnail('next');
    });
    <?php endif; ?>

function showThumbnail(direction) {
    var thumbnailContainer = document.getElementById('thumbnail-container');
    thumbnailContainer.innerHTML = '';

    var img = new Image();
    img.className = 'thumbnail';

    var imageUrls = (direction === 'next') ? <?php echo json_encode($image_urls_next); ?> : <?php echo json_encode($image_urls_previous); ?>;

    if (imageUrls.length > 0) {
        var imageUrl = imageUrls[0]; // Prenez la première image trouvée

        if (imageUrl) {
            img.src = imageUrl;
            thumbnailContainer.appendChild(img);
        }
    } else {
        console.error('Aucune URL d\'image trouvée.');
    }
}
</script>








                </div>
            </div>
        </div>

        </div>
        <?php
    endwhile;
else:
    echo 'Aucun article trouvé.';
endif; ?>

<div class="bar-photos-apparentées container">
</div> 
    <div class="photos-apparentées container">
    <?php
// Charger le contenu du fichier de modèle partiel dans un contexte isolé
include ('templates_part/photo_block.php')

?>


    </div>
<?php get_footer(); ?>
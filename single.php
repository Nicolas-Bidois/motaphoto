<?php get_header(); ?>
<?php if (have_posts()):
    while (have_posts()):
        the_post();
        ?>
        <div class="<?php echo esc_attr(get_image_container_classes()); ?>">
            <div class="info-block">
                <h1 class="entry-title">
                    <?php the_title(); ?>
                </h1>
                <p>RÉFÉRENCE :
                    <?php echo get_post_meta(get_the_ID(), 'référence', true); ?>
                    <script>var reference_data = <?php echo json_encode(get_reference_data()); ?>;</script>
                </p>
                <p>CATÉGORIE :
                    <?php echo get_the_terms(get_the_ID(), 'categorie')[0]->name; ?>
                </p>
                <p>FORMAT :
                    <?php echo get_the_terms(get_the_ID(), 'format')[0]->name; ?>
                </p>
                <p>TYPE :
                    <?php echo get_post_meta(get_the_ID(), 'type', true); ?>
                </p>
                <p>ANNÉE :
                    <?php echo get_post_meta(get_the_ID(), 'Année', true); ?>
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
        <div class="bloc">
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
if ($next_photo_id) {
    $html_content = get_post_field('post_content', $next_photo_id);
} elseif ($previous_photo_id) {
    $html_content = get_post_field('post_content', $previous_photo_id);
} else {
    $html_content = ''; // Si ni l'article suivant ni l'article précédent n'existent pas, définissez la variable $html_content sur une chaîne vide
}

// Utilisez preg_match_all pour extraire les URLs d'image
$image_urls = array();
preg_match_all('/<img[^>]+src=([\'"])(?<src>.+?)\1/i', $html_content, $matches);
$image_urls = $matches['src'];
?>

<div class="fleches">
    <?php if ($previous_photo_id): ?>
        <a href="<?php echo get_permalink($previous_photo_id); ?>" class="nav-link arrow-left" title="Photo précédente">
            <?php echo wp_get_attachment_image(get_post_thumbnail_id($previous_photo_id), array(81, 71), false, array('class' => 'thumbnail')); ?>
            <span class="arrow">&#8592;</span>
        </a>
    <?php endif; ?>

    <?php if ($next_photo_id): ?>
        <a href="<?php echo get_permalink($next_photo_id); ?>" class="nav-link arrow-right" title="Photo suivante">
            <?php echo wp_get_attachment_image(get_post_thumbnail_id($next_photo_id), array(81, 71), false, array('class' => 'thumbnail')); ?>
            <span class="arrow">&#8594;</span>
        </a>
    <?php endif; ?>
    <div id="thumbnail-container">
        <?php
        // Afficher les images extraites par preg_match_all
        foreach ($image_urls as $url) {
            echo '<img src="' . $url . '" class="thumbnail" />';
        }
        ?>
    </div>
</div>

<script>
// Événement au survol de la flèche de droite
document.querySelector('.arrow-right').addEventListener('mouseover', function() {
    showThumbnail('next');
});

// Événement au survol de la flèche de gauche
document.querySelector('.arrow-left').addEventListener('mouseover', function() {
    showThumbnail('previous');
});

function showThumbnail(direction) {
    var thumbnailContainer = document.getElementById('thumbnail-container');
    thumbnailContainer.innerHTML = '';

    var img = new Image();
    img.className = 'thumbnail';

    var imageUrl = '';

    if (direction === 'next') {
        imageUrl = "<?php echo $next_photo_id ? esc_url(wp_get_attachment_url(get_post_thumbnail_id($next_photo_id))) : ''; ?>";
    } else if (direction === 'previous') {
        imageUrl = "<?php echo $previous_photo_id ? esc_url(wp_get_attachment_url(get_post_thumbnail_id($previous_photo_id))) : ''; ?>";
    }

    if (imageUrl) {
        img.src = imageUrl;
        thumbnailContainer.appendChild(img);
    } else {
        console.error('Image URL not found.');
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
<div class="bar-photos-apparentées"></div>
    <div class="photos-apparentées">
        <?php get_template_part('templates_part/photo_block'); ?>
    </div>
<?php get_footer(); ?>
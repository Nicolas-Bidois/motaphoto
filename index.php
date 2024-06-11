<?php get_header(); ?>
<a href=""></a>
<div class="hero_head">
    
    <h1  class=" hero-container event">PHOTOGRAPHE EVENT</h1>
    <?php
include ('templates_part/photo_couv.php')
?>

</div>
<div class="espace-photo-index">


    <select name="category-filter" id="category-filter">
        <option value="">Catégories</option>
        <?php
        $categories = get_categories(array('taxonomy' => 'categorie', 'hide_empty' => false));
        foreach ($categories as $category) {
            echo '<option value=" ' . esc_attr($category->term_id) . '" class="category-option" id="' . esc_attr($category->term_id) . '">' . esc_html($category->name) . '</option>';
        }
        ?>
    </select>

    
    <script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('category-filter').addEventListener('change', function() {
        var category_id = this.value; // Récupérer l'identifiant de la catégorie sélectionnée
        if (category_id) { // Vérifier si une catégorie est sélectionnée
            console.log("Catégorie sélectionnée :", category_id); // Afficher l'identifiant de la catégorie dans la console
            filterPhotosByCategory(category_id); // Appeler la fonction pour filtrer les photos par catégorie
        } else {
            console.log("Veuillez sélectionner une catégorie."); // Afficher un message si aucune catégorie n'est sélectionnée
        }
    });
});

function filterPhotosByCategory(category_id) {
    var data = {
        'action': 'filter_photos', // Action pour identifier le traitement à effectuer côté serveur
        'type': 'category', // Type de requête pour afficher les images en fonction de la catégorie sélectionnée
        'category_id': category_id // Envoyer l'identifiant de la catégorie sélectionnée
    };

    // Envoyer la requête AJAX au serveur
    jQuery.post("/wp-admin/admin-ajax.php", data, function(response) {
        var photosContainer = document.querySelector('.photo-index');
        if (photosContainer) {
            photosContainer.innerHTML = response; // Mettre à jour le contenu avec les nouvelles photos
        } else {
            console.error("Element with class 'photo-index' not found.");
        }
    });
}






    </script>



    <select name="format-filter" id="format-filter">
        <option value="">Formats</option>
        <?php
        $formats = get_categories(array('taxonomy' => 'format', 'hide_empty' => false));
        foreach ($formats as $format) {
            echo '<option value="' . esc_attr($format->term_id) . '">' . esc_html($format->name) . '</option>';
        }
        ?>
    </select>

    <select name="order-filter" id="order-filter">
        <option value="">Trier par</option>
        <option value="DESC">Plus récentes</option>
        <option value="ASC">Plus anciennes</option>
    </select>



</div>
<div class="photo-apparenté2">
<?php
include ('templates_part/photo_block.php')
?>
<div class="pos-button">
<button id="charger-plus-btn">Charger plus</button>
</div>
</div>
<?php get_footer(); ?>
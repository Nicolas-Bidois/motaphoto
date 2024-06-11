<?php

if (isset($_POST['action']) && $_POST['action'] == 'charger-plus-btn') {
    $page = isset($_POST['page']) ? $_POST['page'] : 1;

    echo display_photos('random', $page);
    wp_die(); // Arrête l'exécution du script WordPress
}


// Vérifie si le fichier actuel est single.php
if (is_single()) {
    echo '<div>
            <h3 class="titre-random">VOUS AIMEREZ AUSSI</h3>
            <div class="photos-apparentées" style="display: flex;">';
    // Appel de la fonction display_photos('related') une seule fois
    echo display_photos('related'); // Affiche les photos liées
    echo '</div>
          </div>';
}

// Vérifie si le fichier actuel est index.php
if (is_home() || is_front_page()) {
    echo '<div>
    <div class="photo-index">';
    echo display_photos('random'); // Affiche les photos aléatoires
    echo '</div>
    </div>';
}
?>

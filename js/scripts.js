jQuery(document).ready(function($) {
    var contactMenuButton = $('#menu-principal .popup');
    var contactButton = $('.contact-link, .contact-button'); 
    var modalMenu = $('#modal-contact').dialog({
        autoOpen: false,
        modal: true,
        width: 400,
        // Autres options selon vos besoins
    });
    var modalContact = $('#modal-contact').dialog({
        autoOpen: false,
        modal: true,
        width: 400,
        // Autres options selon vos besoins
    });

    // Activer la fermeture de la fenêtre modale du menu
    $('#modal-menu').on('click', function(e) {
        var target = $(e.target);
        if (target.hasClass('popup-overlay') || !target.closest('.wpcf7').length) {
            $('.popup-overlay').addClass('fade-out-overlay');
            setTimeout(function() {
                modalMenu.dialog('close');
            }, 500);
        }
    });

    // Activer la fermeture de la fenêtre modale du contact
    $('#modal-contact').on('click', function(e) {
        var target = $(e.target);
        if (target.hasClass('popup-overlay') || !target.closest('.wpcf7').length) {
            $('.popup-overlay').addClass('fade-out-overlay');
            setTimeout(function() {
                modalContact.dialog('close');
            }, 500);
        }
    });

    // Écouter le clic sur l'élément du menu "Contact"
    contactMenuButton.on('click', function(e) {
        e.preventDefault();
        modalMenu.dialog('open');
    });

    // Écouter le clic sur le bouton "Contact"
    contactButton.on('click', function(e) {
        e.preventDefault();
        var photoRef = $(this).data('réf.photo');
        $('#referenceField').val(photoRef);
        // Réinitialiser la classe pour garantir que l'animation fonctionne correctement lors de l'ouverture suivante
        $('.popup-overlay').removeClass('fade-out-overlay');
        modalContact.dialog('open');
    });

    // ... Autres fonctionnalités selon vos besoins
});




// Fonction pour pré-remplir le champ de référence
jQuery(document).ready(function($) {
    // Fonction pour pré-remplir le champ de référence
    function prefillReferenceField() {
        // Vérifier si reference_data n'est pas vide
        if (reference_data && reference_data.trim() !== '') {
            // Utiliser la variable reference_data pour pré-remplir le champ
            $('input[name="your-subject"]').val(reference_data);
        }
    }

    // Appeler la fonction pour pré-remplir le champ au chargement du document
    prefillReferenceField();
});

/////////////////////////////////////////////////////////






(function($) {
    $(document).ready(function() {
        var offset = 8; // Le nombre initial d'images affichées
        var imagesPerPage = 8; // Nombre d'images à afficher à chaque requête
        var displayedIds = []; // Tableau pour stocker les ID des images déjà affichées
    
        // Fonction pour charger plus d'images
        function chargerPlus() {
            $.ajax({
                url: window.frontendajax ? frontendajax.ajaxurl : null,
                type: 'POST',
                data: {
                    action: 'charger_plus_photos',
                    offset: offset,
                    images_per_page: imagesPerPage,
                    displayed_ids: displayedIds.join(',') // Envoyez les ID déjà affichés au serveur
                },
                success: function(response) {
                    $('.photo-apparenté2').append(response);
                    offset += imagesPerPage; // Mettez à jour l'offset pour la prochaine requête
                    updateDisplayedIds(response); // Mettez à jour les ID affichés
                }
            });
        }

        // Fonction pour mettre à jour les ID affichés
        function updateDisplayedIds(response) {
            // Récupérer les ID des nouvelles images
            var newIds = $(response).find('.photo-apparenté').map(function() {
                return $(this).data('image-id');
            }).get();
            // Concaténer les nouveaux IDs avec les IDs déjà affichés
            displayedIds = displayedIds.concat(newIds);
            console.log(response)
        }

        // Gérez le clic sur le bouton "Charger plus"
        $('#charger-plus-btn').on('click', function() {
            chargerPlus();
        });
    });
})(jQuery);



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







/*
(function($) {
    $(document).ready(function() {
        var page = 1; // Le numéro initial de page
        var perPage = 8; // Nombre d'articles par page

        // Fonction pour charger plus de photos
        function chargerPlus() {
            $.ajax({
                url: 'http://motaphoto.local/wp-json/wp/v2/media',
                type: 'GET',
                headers: {
                    'Accept': 'application/json'
                },
                data: {
                    per_page: perPage,
                    page: page
                },
                success: function(response) {
                    // Convertissez la réponse en chaîne pour la recherche
                    var responseString = JSON.stringify(response);
console.log(response)
                    // Trouvez l'index du premier caractère '[' (début du tableau JSON)
                    var startIndex = responseString.indexOf('[');

                    if (startIndex !== -1) {
                        // Extrait le JSON à partir de cet index jusqu'à la fin
                        var jsonString = responseString.substring(startIndex);

                        try {
                            // Parsez le JSON extrait
                            var jsonData = JSON.parse(jsonString);
                            console.log(jsonData);

                            
                            jsonData.forEach(function(photo) {
                                // Ajoutez la logique pour afficher chaque photo
                                $('.photo-apparente2').append('<img src="' + photo.source_url + '" alt="' + photo.alt_text + '">');
                            });

                            page++; // Mettez à jour le numéro de page pour la prochaine requête
                        } catch (error) {
                            console.error('Erreur lors de l\'analyse du JSON:', error);
                        }
                    } else {
                        console.error('Aucun tableau JSON trouvé dans la réponse.');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Erreur Ajax:', textStatus, errorThrown);
                    // Affichez la réponse complète du serveur dans la console en cas d'erreur
                    console.log('Réponse du serveur:', jqXHR.responseText);
                    
                    $('.photo-apparente2').append('<p>Erreur lors du chargement des photos.</p>');
                }
            });
        }

        // Gérez le clic sur le bouton "Charger plus"
        $('#charger-plus-btn').on('click', function() {
            chargerPlus();
        });
    });
})(jQuery);
*/


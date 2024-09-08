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

    var contactMenuOpen = false; // Variable pour suivre l'état de la modale du menu

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
        console.log(target.hasClass('popup-overlay'))
        if (target.hasClass('popup-overlay') || !target.closest('.wpcf7').length) {
            setTimeout(function() {
                modalContact.dialog('close');
            }, 500);
        }
    });

    // Écouter le clic sur l'élément du menu "Contact"
    contactMenuButton.on('click', function(e) {
        e.preventDefault();
        if (!contactMenuOpen) {
            contactMenuOpen = true; // Marquer la modale comme ouverte
            modalMenu.dialog('open');
            // Réinitialiser la variable lorsque la modale se ferme
            modalMenu.on('dialogclose', function() {
                contactMenuOpen = false;
            });
        }
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

document.addEventListener("DOMContentLoaded", function() {
    // Vérifier si nous ne sommes pas sur la page principale (index)
    if (window.location.pathname !== '/' && window.location.pathname !== '/index.html') {
        var referenceField = document.getElementById('reference_field');
        if (referenceField && typeof reference_data !== 'undefined') {
            referenceField.value = reference_data;
        }
    }
});




/////////////////////////////////////////////////////////


document.addEventListener('DOMContentLoaded', function() {
    var categoryFilter = document.getElementById('category-filter');
    var formatFilter = document.getElementById('format-filter');
    var orderFilter = document.getElementById('order-filter');

    // Vérifier si les éléments existent avant d'ajouter les événements
    if (categoryFilter && formatFilter && orderFilter) {
        categoryFilter.addEventListener('change', applyFilters);
        formatFilter.addEventListener('change', applyFilters);
        orderFilter.addEventListener('change', applyFilters);
    } else {
        console.error("Un ou plusieurs filtres sont manquants.");
    }

    // Fonction pour appliquer les filtres et mettre à jour les photos
    function applyFilters() {
        var category_id = categoryFilter.value;
        var format_id = formatFilter.value;
        var order = orderFilter.value;

        var data = {
            'action': 'filter_photos', // Action côté serveur
            'type': 'combined', // Type de requête pour combiner les filtres
            'category_id': category_id,
            'format_id': format_id,
            'order': order // Paramètre pour l'ordre
        };

        // Requête AJAX pour appliquer les filtres
        jQuery.post("/wp-admin/admin-ajax.php", data, function(response) {
            var photosContainer = document.querySelector('.photo-index');
            if (photosContainer) {
                photosContainer.innerHTML = response; // Mettre à jour les photos avec le résultat de la requête
                console.log("Photos mises à jour avec les filtres appliqués.");
                // Réinitialiser les événements de la lightbox après la mise à jour des images
                initLightbox();
            } else {
                console.error("Élément avec la classe 'photo-index' introuvable.");
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Erreur AJAX : " + textStatus, errorThrown);
        });
    }

    // Fonction pour initialiser la lightbox
    function initLightbox() {
        // Récupérer tous les éléments ayant la classe "expand-icon"
        var expandIcons = document.querySelectorAll('.expand-icon');
        console.log("Nombre d'icônes d'agrandissement trouvées : " + expandIcons.length);

        // Parcourir tous les éléments et ajouter un gestionnaire d'événement au clic
        expandIcons.forEach(function(expandIcon) {
            console.log("Ajout d'un gestionnaire d'événement au clic pour une icône d'agrandissement.");
    
            expandIcon.addEventListener('click', function() {
                console.log("Clic détecté sur une icône d'agrandissement.");
    
                // Récupérer l'URL de l'image à partir de l'attribut "src" de l'élément parent
                var imgElement = this.closest('.photo-ajust').querySelector('.photo-apparenté, .photo-apparenté2');
                if (imgElement) {
                    var imageUrl = imgElement.getAttribute('src');
                    console.log("URL de l'image : " + imageUrl);
    
                    // Créer un élément d'image pour la lightbox
                    var lightboxImg = document.createElement('img');
                    lightboxImg.src = imageUrl;
    
                    // Créer un conteneur pour la lightbox
                    var lightboxContainer = document.createElement('div');
                    lightboxContainer.classList.add('lightbox-container');
                    lightboxContainer.appendChild(lightboxImg);
    
                    // Créer les éléments pour la référence et le terme
                    var referenceParagraph = document.createElement('p');
                    referenceParagraph.classList.add('lightbox__reference');
                    lightboxContainer.appendChild(referenceParagraph);
    
                    var termParagraph = document.createElement('p');
                    termParagraph.classList.add('lightbox__term');
                    lightboxContainer.appendChild(termParagraph);
    
                    // Ajouter les boutons de fermeture, suivant et précédent
                    var closeBtn = document.createElement('button');
                    closeBtn.classList.add('lightbox__close');
                    closeBtn.textContent = 'X';
                    lightboxContainer.appendChild(closeBtn);
    
                    var nextBtn = document.createElement('button');
                    nextBtn.classList.add('lightbox__next');
                    nextBtn.innerHTML = 'Suivant <i class="fa-solid fa-arrow-right"></i>';
                    lightboxContainer.appendChild(nextBtn);
    
                    var prevBtn = document.createElement('button');
                    prevBtn.classList.add('lightbox__prev');
                    prevBtn.innerHTML = '<i class="fa-solid fa-arrow-left"></i> Précédent';
                    lightboxContainer.appendChild(prevBtn);
    
                    // Liste des URL des images, en excluant les images avec la classe 'hero_head'
                    var imageUrls = Array.from(document.querySelectorAll('.photo-ajust .photo-apparenté:not(.hero_head), .photo-ajust .photo-apparenté2:not(.hero_head)'))
                        .map(img => img.getAttribute('src'));
    
                    // Variable pour suivre l'index de l'image actuellement affichée
                    var currentImageIndex = imageUrls.indexOf(imageUrl);
    
                    // Fonction pour mettre à jour les éléments de référence et de terme
                    function updateReferenceAndTerm() {
                        var currentIcon = Array.from(expandIcons).find(icon => {
                            var img = icon.closest('.photo-ajust').querySelector('.photo-apparenté, .photo-apparenté2');
                            return img && img.getAttribute('src') === imageUrls[currentImageIndex];
                        });
                        if (currentIcon) {
                            var referenceElement = currentIcon.closest('.photo-ajust').querySelector('.reference');
                            var termElement = currentIcon.closest('.photo-ajust').querySelector('.term');
                            if (referenceElement && termElement) {
                                console.log("Référence trouvée : " + referenceElement.textContent);
                                console.log("Terme trouvé : " + termElement.textContent);
                                referenceParagraph.textContent = referenceElement.textContent;
                                termParagraph.textContent = termElement.textContent;
                            } else {
                                console.error("Les éléments de référence et de terme n'ont pas été trouvés.");
                            }
                        } else {
                            console.error("L'élément currentIcon n'a pas été trouvé.");
                        }
                    }
    
                    // Mettre à jour les éléments de référence et de terme initialement
                    updateReferenceAndTerm();
    
                    // Ajouter un événement pour fermer la lightbox au clic sur le bouton de fermeture
                    closeBtn.addEventListener('click', function() {
                        document.body.removeChild(lightboxContainer);
                        console.log("Lightbox supprimée de la page.");
                    });
    
                    // Logique pour afficher l'image suivante
                    function showNextImage() {
                        currentImageIndex = (currentImageIndex + 1) % imageUrls.length;
                        lightboxImg.src = imageUrls[currentImageIndex];
                        // Mettre à jour les éléments de référence et de terme
                        updateReferenceAndTerm();
                    }
    
                    // Logique pour afficher l'image précédente
                    function showPreviousImage() {
                        currentImageIndex = (currentImageIndex - 1 + imageUrls.length) % imageUrls.length;
                        lightboxImg.src = imageUrls[currentImageIndex];
                        // Mettre à jour les éléments de référence et de terme
                        updateReferenceAndTerm();
                    }
    
                    // Ajouter un gestionnaire d'événement pour le bouton suivant
                    nextBtn.addEventListener('click', showNextImage);
    
                    // Ajouter un gestionnaire d'événement pour le bouton précédent
                    prevBtn.addEventListener('click', showPreviousImage);
    
                    // Ajouter la lightbox à la page
                    document.body.appendChild(lightboxContainer);
                    console.log("Lightbox ajoutée à la page.");
    
                } else {
                    console.error("Aucun élément img trouvé avec la classe .photo-apparenté ou .photo-apparenté2.");
                }
    
            });
        });
    }

    // Initialiser la lightbox au chargement de la page
    initLightbox();
});








//burger menu
jQuery(document).ready(function($) {
    var page = 1;
    var loading = false;
    var $loadmoreButton = $('#charger-plus-btn');
    var $photosContainer = $('.photo-index');

    $loadmoreButton.on('click', function() {
        if (!loading) {
            loading = true;
            page++;

            $.ajax({
                url: "/wp-admin/admin-ajax.php", // Utilisation de la variable ajaxurl définie par WordPress
                type: 'POST',
                data: {
                    action: 'charger_plus_photos',
                    page: page
                },
                success: function(response) {
                    // Ajouter les nouvelles photos au conteneur
                    console.log(response)
                    $photosContainer.append(response);
                    loading = false;
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    loading = false;
                }
            });
        }
    });
});



// css filtre 

// cacher button charger-plus
jQuery(document).ready(function($) {
    // Fonction pour gérer la visibilité du bouton "Charger plus"
    function toggleLoadMoreButton() {
        var loadMoreButton = $('#charger-plus-btn');
        var categoryValue = $('#category-filter').val();
        var formatValue = $('#format-filter').val();

        if (loadMoreButton.length) {
            if (categoryValue === '' && formatValue === '') {
                loadMoreButton.removeClass('hidden'); // Affiche le bouton "Charger plus"
            } else {
                loadMoreButton.addClass('hidden'); // Masque le bouton "Charger plus"
            }
        }
    }

    // Appel initial pour vérifier l'état au chargement de la page
    toggleLoadMoreButton();

    // Écouteurs d'événement pour les changements de sélection dans les filtres
    $('#category-filter, #format-filter').change(function() {
        toggleLoadMoreButton(); // Appelle la fonction de gestion de visibilité du bouton
    });
});


    

// burger menu


jQuery(document).ready(function($) {
    $('.burger').click(function() {
        $('.navigation').toggleClass('open');
        $('header').toggleClass('menu-open');

        // Ajouter la classe 'hidden' aux éléments spécifiés lorsque le menu est ouvert
        if ($('.navigation').hasClass('open')) {
            $('body').addClass('no-scroll'); // Ajoutez la classe pour désactiver le scroll
            $('.photo-apparenté, .photo-apparenté2 img, .hero_head img, .hero-container').addClass('hidden');
        } else {
            $('body').removeClass('no-scroll'); // Retirez la classe pour activer le scroll
            $('.photo-apparenté, .photo-apparenté2 img, .hero_head img,  .hero-container').removeClass('hidden');
        }
    });

    // Retirer la classe 'no-scroll' lorsque le menu est fermé
    $('.burger.open').click(function() {
        $('body').removeClass('no-scroll');
        $('.photo-apparenté, .photo-apparenté2 img').removeClass('hidden');
    });

    // Optionally, close the menu when a menu item is clicked
    $('#menu-principal a').click(function() {
        $('.navigation').removeClass('open');
        $('header').removeClass('menu-open');
        $('body').removeClass('no-scroll');
        $('.photo-apparenté, .photo-apparenté2 img').removeClass('hidden');
    });
});








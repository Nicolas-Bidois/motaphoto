<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php bloginfo('name'); ?>
    </title>
    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_uri(); ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/scripts.js"></script>


</head>

<body>
    <div id="wrapper" class="hfeed">
        <header id="header">
            <nav id="menu">
                <?php afficherImage(); ?>

                <div class="navigation">
                    <?php
                    wp_nav_menu(array('theme_location' => 'menu-principal', 'menu_id' => 'menu-principal', ));
                    ?>
                    <div class="burger">
                    <span class="line"></span>
                    <span class="line"></span>
                    <span class="line"></span>
                    </div>
                        <div id="modal-contact">
                            <div class="popup-overlay">
                            <!-- Contenu de la fenêtre modale, y compris le formulaire de Contact Form 7 -->
                            <?php echo do_shortcode('[contact-form-7 id="dcc1ee0" title="Formulaire de contact 1"]'); ?>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
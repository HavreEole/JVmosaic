<?php

    $afficherHeader = function($titre) {
        
        $description = '';
        if ($titre == 'Personnes de l\'industrie du jeu vidéo') {
            $description = 'Afin de faciliter les prises de contact, cet annuaire filtre les profils de personnes évoluant dans l\'industrie du jeu vidéo en fonction de leurs spécificités.';
            
        } else {
            $description = 'Consultez le profil et les projets de '.$titre.', une personne évoluant dans l\'industrie du jeu vidéo.';
            $titre = 'Profil de '.$titre;
            
        }
        
        $monTexte = '
            <!DOCTYPE html>
            <html>
                <head>
                    <title>Annuaire JV Mosaïc - '.$titre.'</title>
                    <meta name="description" content="'.$description.'" />
                    <meta charset="UTF-8"/>
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                    <link rel="stylesheet" type="text/css" href="styles/main.css"/>
                </head>
                <body>

                    <header>
                        <a href="index.php">JV Mosaic</a>
                        <a href="#">Se connecter</a>
                    </header>
        ';
        return $monTexte;
        unset($monTexte);
    }

?>

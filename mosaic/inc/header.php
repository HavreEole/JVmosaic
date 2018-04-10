<?php

    $afficherHeader = function($titre) {
        $monTexte = '
            <!DOCTYPE html>
            <html>
                <head>
                    <title>JV Mosaïque - '.$titre.'</title>
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

<?php

    include("inc/bridge.php");

    include("inc/header.php");
    echo($afficherHeader('Personnes de l\'industrie du jeu vidéo'));
               
    echo("<main>");

        include("inc/list.php");

    echo("</main>");
        
    include("inc/footer.php"); 
    echo($afficherFooter());

    echo("</body></html>");

?>
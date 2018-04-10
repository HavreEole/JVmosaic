<?php
    include("inc/secure.php"); /* se connecter ? */

    include("inc/header.php");
    echo($afficherHeader('Accueil'));
               
    echo("<main>");

        include("inc/list.php");

    echo("</main>");
        
    include("inc/footer.php"); 
    echo($afficherFooter());

    echo("</body></html>");

?>
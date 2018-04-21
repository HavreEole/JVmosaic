<section id="menuListStyles">
    <?php include("inc/menu.php"); ?>
    <article id="personnesListe" class="col-5-4"> 
        <?php fillArticle(); ?>
    </article> 
</section>


<?php

    /* Remplir Article */
    function fillArticle() {

        $myContent = "";
        $tagList = ""; // liste des tags s'il y a une recherche en cours.
        $tagListArray = array(); // liste des tags s'il y a une recherche en cours.
        $cardSelection = array(); // les numeros de profils qu'on va afficher.
        $affichageLength = 8;
        $voirPlus = false;
        
        
        /* Titre html */

        if (testNotEmptyGetFromUrl("tag")) { // s'il y a des tags dans l'url,

            $safeTag = getGetFromUrl("tag"); // régupérer les tags dans l'url,
            $multiTags = explode(",",$safeTag); // en faire un array.

            foreach ( $multiTags as $oneTag ) {
                
                $verifOneTag = queryThis("compareTagName",$oneTag); // Verifier que ce tag existe,

                if ( $verifOneTag != '') { // si oui, l'ajouter.
                    $tagList .= $verifOneTag.", ";
                    array_push($tagListArray,$verifOneTag);
                }
                
            }
                
            $tagList = rtrim($tagList,', ');
        }
        
        
        
        /* Affichage du titre et selection des cards */
        
        if ($tagList != "") {
            
            $myContent.= "<h1><span>Les résultats pour votre recherche : ".$tagList."</span></h1>";
            
            $personnesNumList = queryThis("getPersonnesParTags",$tagListArray,$affichageLength);
                
            if ( count($personnesNumList) > $affichageLength ) { $voirPlus = true; }
            
            
        } else {
            
            $myContent.= "<h1><span>Quelques personnes de l'industrie du jeu vidéo</span></h1>";
            $maxRand = queryThis("nombrePersonnes")-1; 
            $personnesNumList = array();
            for ($i=0; $i<$affichageLength; $i++) {
                array_push($personnesNumList,mt_rand(0,$maxRand));
            }
            $personnesNumList = array_unique($personnesNumList);
            
            $voirPlus = true;
            
        }
        foreach ($personnesNumList as $onePersonnesNum) {
            array_push($cardSelection,queryThis("getPersonne",$onePersonnesNum,'profil'));
        }


        
        /* Cards html */
        
        foreach ( $cardSelection as $oneCard ) {
            $myContent.= "<a href=\"profil.php?num=".$oneCard['numero']."\">";
            $myContent.= "<div>";
            $myContent.= "<img src=\"".$oneCard['urlAvatar']."\">";
            $myContent.= "<span>";
            if ($oneCard['prenom'] != "") { $myContent.= $oneCard['prenom']." "; }
            if ($oneCard['pseudo'] != "") { $myContent.= $oneCard['pseudo']." "; }
            $myContent.= $oneCard['nom']."</span>";
            $myContent.= "</div></a>";
        } unset($oneCard);
        $myContent.= "</div></a>";

        
        
        /* Voir plus ? */
        if ($voirPlus) { $myContent.= "<p><a href=\"\">Voir plus...</a></p>"; }
        // TODO: ajouter un get ?voirPlus=longueur avec js, verifier longueur max.
        // ou post ou session. :?
        
        
        
        echo($myContent);
        
        /*** Contenu d'une card dans Article :

            <a href="profil.php?num=0">
                <div>
                    <img src="img/avatars/0.jpg"/>
                        <span>Jeanne</span>
                </div>
            </a>
            <p><a href="">Voir plus...</a></p>
        
        ***/
        
    }



?>
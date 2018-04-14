<section id="menuListStyles">
    <?php include("inc/menu.php"); ?>
    <article id="personnesListe" class="col-5-4"> 
        <?php fillArticle(); ?>
    </article> 
</section>


<?php

    /*** Contenu d'une card dans Article :

        <a href="profil.php?num=0">
            <div>
                <img src="img/avatars/0.jpg"/>
                    <span>Jeanne</span>
            </div>
        </a>
        <p><a href="">Voir plus...</a></p> // TODO
        
    ***/


    /* Remplir Article */
    function fillArticle() {
        
        $personne = getPersonne(-1);

        $myContent = "";

        
        /* Titre html */
        $myContent.= "<h1><span>";
        if (testNotEmptyGetFromUrl("tag")) {

            $safeTag = getGetFromUrl("tag");
            $tagList = "";
            
            if (strpos($safeTag,",")>=0) { // s'il y a des virgules il y a plusieurs tags.
                
                $multiTags = explode(",",$safeTag);
                
                foreach ( $multiTags as $oneTag ) {
                    $tagList.= " \"".$oneTag."\"";
                } unset($oneTag);
                
            } else {
            
                $tagList.= " \"".$safeTag."\"";
                    
            }
            
            $myContent.= "Les résultats pour votre recherche".$tagList;

        } else {

            $myContent.= "Quelques personnes de l'industrie du jeu vidéo";
            
        }
        $myContent.= "</span></h1>";


        /* Cards selection */
        
        // TODO 0. trier les profils affichés si clic sur un tag.
        // $cardSelection = array();
        // if (testNotEmptyGetFromUrl("tag")) {
        // } else {} // penser à retirer les bannies.

        $cardSelection = array_rand($personne,8); // x personnes au hasard.
        
        
        /* Cards html */
        foreach ( $cardSelection as $oneCard ) {
            $myContent.= "<a href=\"profil.php?num=".$personne[$oneCard][0]."\">";
            $myContent.= "<div>";
            $myContent.= "<img src=\"".$personne[$oneCard][12]."\">";
            $myContent.= "<span>";
            if ($personne[$oneCard][5] != "") { $myContent.= $personne[$oneCard][5]." "; }
            if ($personne[$oneCard][6] != "") { $myContent.= $personne[$oneCard][6]." "; }
            $myContent.= $personne[$oneCard][7]."</span>";
            $myContent.= "</div></a>";
        } unset($oneCard);

        
        $myContent.= "</div></a><p><a href=\"\">Voir plus...</a></p>";


        echo($myContent);
        
    }

?>
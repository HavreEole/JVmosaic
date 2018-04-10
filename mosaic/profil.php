<?php

    include("inc/secure.php");

    include("inc/header.php");
    echo($afficherHeader('Accueil'));
               
        echo("
            <main>
                <section id='profilStyles'>
                    <menu>
                        <a href='index.php'>
                            <h1>◃Accueil</h1>
                        </a>
                    </menu>");
        
        $anErrorOccured = false;
        if (!empty($_GET["num"]) || $_GET["num"] == 0){ // 0 est considéré comme vide...
            
            $safeGetNum = htmlspecialchars($_GET["num"]);
            
            if (    filter_var($safeGetNum, FILTER_VALIDATE_INT) === 0 // num is a number
                    || !filter_var($safeGetNum, FILTER_VALIDATE_INT) === false  ) {
                
                
                //$profilNums = getProfilNums($theNum); // requete sql
                $profilNums = array($safeGetNum,0,1); // temporaire

                echo fillPersonne($profilNums[0]);

                if ( count($profilNums) > 1 ) {

                    for ($i=1; $i<count($profilNums); $i++) {
                        echo fillProjet($profilNums[$i]);
                    }

                }
                
            } else { $anErrorOccured = true; }
            
        } else { $anErrorOccured = true; }

        if ($anErrorOccured) {
            echo("
                <article id='projetProfil'>
                    <div class='wrapper'>
                        <p>Erreur : ce profil n'existe pas.</p>
                    </div>
                </article>");
        }

        echo("</section></main>");
        
    include("inc/footer.php");
    echo($afficherFooter());

    echo("</body></html>");

?>



<?php



    /* Remplir Profil */
    function fillPersonne($numPersonne) {
        
        $personne = getPersonne($numPersonne);
        $monTexte = '';

        // num mail mdp admin ban prénom pseudo nom twitter linkedin site desc avatar
        
        // Nom, prénom, pseudo <- titre
        $monTexte .= '<h1><span>'.$personne[5].' '.$personne[6].' '.$personne[7].'</span></h1>';
        
        // avatar
        $monTexte .= '<article id="personneProfil">';
        $monTexte .= '<div class="wrapper">';
        $monTexte .= '<div class="col-6-2">';
        $monTexte .= '<img src="'.$personne[12].'">';
        $monTexte .= '</div>';
        
        // description
        $monTexte .= '<div class="col-6-2">';
        $monTexte .= '<p>'.$personne[11].'</p>';
        $monTexte .= '</div>';
        
        // liste de tags (Depeindre) //num, numPers, numProj
        $monTexte .= '<div class="col-6-2">';
        $monTexte .= '<p class="tagList">';
        $findDepeindre = getDepeindre();
        $personneTagsList = array();
        foreach($findDepeindre as $aDepiction) {
            if ($aDepiction[1] == $numPersonne) {
                array_push($personneTagsList,$aDepiction[2]);
            }
        }
        foreach($personneTagsList as $aPersonneTag) {
            $infosPersonneTag = getTag($aPersonneTag); // num, nom, nbUsages
            $monTexte .= '<span>'.$infosPersonneTag[1].'</span>';
        }
        $monTexte .= '</p>';
        
        // twitter, linkedin, site web
        $monTexte .= '<p><span>Twitter</span><a href="https://twitter.com/'.$personne[8].'">'.$personne[8].'</a></p>';
        $monTexte .= '<p><span>Linkedin</span><a href="https://www.linkedin.com/in//'.$personne[9].'">'.$personne[9].'</a></p>';
        $monTexte .= '<p><span>Site web</span><a href="'.$personne[10].'">'.$personne[10].'</a></p>';
        $monTexte .= '</div>';
        $monTexte .= '</div>';
        $monTexte .= '</article>';

        return $monTexte;
 
    }

    /* Remplir Projet */
    function fillProjet($numProjet) {
        
        $projet = getProjet($numProjet);
        
        $monTexte = '';
        
        //num, mdp, nom, studio, desc, date, site, visuel.
        
        // nom studio, site web, date de sortie
        $monTexte .= '<article class="projetProfil">';
        $monTexte .= '<div class="wrapper">';
        $monTexte .= '<div class="col-6-2">';
        $monTexte .= '<p><span>Nom</span>'.$projet[2].'</p>';
        $monTexte .= '<p><span>Studio</span>'.$projet[3].'</p>';
        $monTexte .= '<p><span>Site web</span><a href="'.$projet[6].'">'.$projet[6].'</a></p>';
        $monTexte .= '<p><span>Date de sortie</span>'.$projet[5].'</p>';
        
        // liste de tags (Decrire) //num, numProj, numTag
        $monTexte .= '<p class="tagList">';
        $findDecrire = getDecrire();
        $projetTagsList = array();
        foreach($findDecrire as $aDescription) {
            if ($aDescription[1] == $numProjet) {
                array_push($projetTagsList,$aDescription[2]);
            }
        }
        foreach($projetTagsList as $aProjetTag) {
            $infosProjetTag = getTag($aProjetTag); // num, nom, nbUsages
            $monTexte .= '<span>'.$infosProjetTag[1].'</span>';
        }
        $monTexte .= '</p>';
        $monTexte .= '</div>';

        // description
        $monTexte .= '<div class="col-6-2">';
        $monTexte .= '<p>'.$projet[4].'</p>';
        $monTexte .= '</div>';
        
        // visuel
        $monTexte .= '<div class="col-6-2">';
        $monTexte .= '<img src="'.$projet[7].'">';
        $monTexte .= '</div>';
        $monTexte .= '</div>';
        $monTexte .= '</article>';
        
            
        return $monTexte;
 
    }





?>

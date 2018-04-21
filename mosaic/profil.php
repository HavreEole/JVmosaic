<?php

    include("inc/bridge.php");

    include("inc/header.php");
    echo($afficherHeader('Annuaire mosaïque - Profil'));
               
        echo("
            <main>
                <section id='profilStyles'>
                    <menu>
                        <a href='index.php'>
                            <h3>◃Accueil</h3>
                        </a>
                    </menu>");
        
        $anErrorOccured = false;
        if (testNotEmptyGetFromUrl("num")){
            
            $safeGetNum = getGetFromUrl("num");
            
            $profilNums = queryThis("personneProjetsNums",$safeGetNum);

            echo fillPersonne($safeGetNum);

            if ( count($profilNums) > 0 ) {
                foreach ($profilNums as $oneProject) {
                    
                    echo fillProjet($oneProject,$safeGetNum);
                    
                }
            }
            
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
        
        $personne = queryThis("getPersonne",$numPersonne,'profil');
        $monTexte = '';

        // num mail mdp admin ban prénom pseudo nom twitter linkedin site desc avatar
        
        // Nom, prénom, pseudo <- titre
        $monTexte .= '<h1><span>'.$personne["prenom"].' '.$personne["pseudo"].' '.$personne["nom"].'</span></h1>';
        
        // avatar
        $monTexte .= '<article id="personneProfil">';
        $monTexte .= '<div class="wrapper">';
        $monTexte .= '<div class="col-3-1">';
        $monTexte .= '<img src="'.$personne['urlAvatar'].'">';
        $monTexte .= '</div>';
        
        // description
        $monTexte .= '<div class="col-3-1">';
        $monTexte .= '<p>'.$personne['description'].'</p>';
        $monTexte .= '</div>';
        
        // liste de tags (depeindre)
        $monTexte .= '<div class="col-3-1">';
        $monTexte .= '<p class="tagList">';
        
        $personneTagsList = queryThis("getDepeindre",$numPersonne);
        foreach($personneTagsList as $aPersonneTagName) {
            $monTexte .= '<span>'.$aPersonneTagName.'</span>';
        }
        
        $monTexte .= '</p>';
        
        // twitter, linkedin, site web
        $monTexte .= '<p><span>Twitter</span><a href="https://twitter.com/'.$personne['twitter'].'">'.$personne['twitter'].'</a></p>';
        $monTexte .= '<p><span>Linkedin</span><a href="https://www.linkedin.com/in//'.$personne['linkedin'].'">'.$personne['linkedin'].'</a></p>';
        $monTexte .= '<p><span>Site web</span><a href="'.$personne['website'].'">'.$personne['website'].'</a></p>';
        $monTexte .= '</div>';
        $monTexte .= '</div>';
        $monTexte .= '</article>';

        return $monTexte;
 
    }

    /* Remplir Projet */
    function fillProjet($numProjet,$numPersonne) {
        
        $projet = queryThis("getProjet",$numProjet);
        //num, mdp, nom, studio, desc, date, site, visuel.
        
        $monTexte = '';
        
        // nom studio, site web, date de sortie
        $monTexte .= '<article class="projetProfil">';
        $monTexte .= '<div class="wrapper">';
        $monTexte .= '<div class="col-3-1">';
        $monTexte .= '<p><span>Nom</span>'.$projet['nom'].'</p>';
        $monTexte .= '<p><span>Studio</span>'.$projet['studio'].'</p>';
        $monTexte .= '<p><span>Site web</span><a href="'.$projet['website'].'">'.$projet['website'].'</a></p>';
        $monTexte .= '<p><span>Date de sortie</span>'.$projet['dateSortie'].'</p>';
        
        
        // liste de membres sur le projet (Travailler)
        
        $projetMembers = queryThis("getProjectMembers",$numProjet);

        if ( count($projetMembers)>1 ) {
            
            $monTexte .= '<p><span>Equipe</span>';
            $otherMembersTxt = '';
            
            foreach($projetMembers as $aProjetMember) {

                $patronyme = ( $aProjetMember['pseudo'] != "" ? $aProjetMember['pseudo'] :
                               $aProjetMember['prenom']." ".$aProjetMember['nom'] );
                
                if ( $numPersonne == $aProjetMember['numero'] ) {

                    $monTexte .= $patronyme.', ';
                    
                } else {

                    $otherMembersTxt .= '<a href="profil.php?num='.$aProjetMember['numero'].'">'.$patronyme.'</a>, ';
                }
            }
            
            $otherMembersTxt = rtrim($otherMembersTxt,', ');
            $monTexte .= $otherMembersTxt.'.';
            $monTexte .= '</p>';
        }
        
        
        // liste de tags (Decrire)
        $monTexte .= '<p class="tagList">';
        
        $projetTagsList = queryThis("getDecrire",$numProjet);
        foreach($projetTagsList as $aProjetTagName) {
            $monTexte .= '<span>'.$aProjetTagName.'</span>';
        }
        
        $monTexte .= '</p>';
        $monTexte .= '</div>';

        
        // description
        $monTexte .= '<div class="col-3-1">';
        $monTexte .= '<p>'.$projet['description'].'</p>';
        $monTexte .= '</div>';
        
        
        // visuel
        $monTexte .= '<div class="col-3-1">';
        $monTexte .= '<img src="'.$projet['urlVisuel'].'">';
        $monTexte .= '</div>';
        $monTexte .= '</div>';
        $monTexte .= '</article>';
        
            
        return $monTexte;
 
    }





?>

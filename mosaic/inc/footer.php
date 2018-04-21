<?php

    $afficherFooter = function() {
        $monTexte = '<footer><span>Admins : ';
        
        $listAdmins = queryThis("admins");
        $listAdminsTxt = '';
        
        foreach ($listAdmins as $oneAdmin) {
            
            $listAdminsTxt .= '<a href="profil.php?num='.$oneAdmin['numero'].'">';
            
            if ( $oneAdmin['pseudo'] != '') { // on affiche que le pseudonyme
                $listAdminsTxt .= $oneAdmin['pseudo'];
                
            } else { // ou bien le nom et prénom.
                $listAdminsTxt .= $oneAdmin['prenom'].' '.$oneAdmin['nom'];
            }
            
            $listAdminsTxt .= '</a>, ';
                
        }
        
        $listAdminsTxt = rtrim($listAdminsTxt,', ');
            
        $monTexte .= $listAdminsTxt.'</span></footer>';

        return $monTexte;
        unset($monTexte);
    }

?>
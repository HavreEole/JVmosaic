<script>

    function addTag(e,aTag) { // quand on clique sur un tag.
        
        e.preventDefault();
        
        // si le tag n'est pas déjà dans l'url,
        if( document.location.href.indexOf(aTag) == -1 ) {
            
            // s'il n'y a pas encore de tags dans l'url on met ?tag= ,
            if ( document.location.href.indexOf("?tag") == -1 ) {

                document.location.href="?tag="+aTag;

            } else { // sinon on rajoute juste le nouveau tag.
                document.location.href+=","+aTag;
            }
        }
    }
    
    function removeTag(e,aTag) { // quand on clique sur un tag selectionné.
        
        e.preventDefault();
        var myLoc = document.location.href;

        if (myLoc.search(aTag)) { // si ce tag existe bien dans l'url,

            if (myLoc.search(","+aTag)>-1) { // tag derrière un autre
                myLoc = myLoc.replace(","+aTag,""); // on le supprime avec sa virgule.

            } else if (myLoc.search("tag="+aTag+",")>-1) { // tag avec liste derrière
                myLoc = myLoc.replace(aTag+",",""); // on le supprime avec sa virgule.

            } else { // sinon c'est que le tag est seul
                myLoc = "index.php"; // on vide l'url.
            }

            document.location.href=myLoc;

        }

    }

</script>



<menu class="col-5-1">
      <?php fillMenu(); ?> 
</menu>



<?php

    function fillMenu() {
        
        $offsetAffichage = 0;
        $lengthAffichage = 6;
        $tags = queryThis("getTags",$lengthAffichage,$offsetAffichage);
   
        
        
        /* Tags dans l'url = tags à selectionner dans le menu */
        $shortTags = $tags;
        $tagSelectListUrl = array();
        $tagSelectList = array();
        $filtrerHtml = "<h3>Filtrer</h3>";
        
        if (testNotEmptyGetFromUrl("tag")) {
            
            // s'il y en a on doit pouvoir tous les déselectionner d'un coup.
            $filtrerHtml = "<a href='index.php'><h3>Défiltrer</h3></a>";
            
            
            // s'il y a des tags dans l'url on vérifie qu'ils sont legits.
            // $tagSelectList servira pour ajouter une classe de tag selectionné.
            $safeGetTag = getGetFromUrl("tag");
            $tagSelectListUrl = (explode(",",$safeGetTag));
            
            foreach ( $tagSelectListUrl as &$oneTag ) {
                $verifOneTag = queryThis("compareTagName",$oneTag); 
                if ( $verifOneTag != '') { array_push($tagSelectList,$verifOneTag); }
            }
            
            
            // si des tags sont dans l'url, ils devront forcément apparaitre dans la liste.
            $tagExistAlready = array(); $tagsToAdd = array();

            foreach($tags as $aTag) { // on va retirer ceux qui sont déjà dans la liste.
                foreach($tagSelectList as $aSelectedTag) {
                    if ($aTag['nomPourUrl'] == $aSelectedTag) {
                        array_push($tagExistAlready,$aSelectedTag);
                    }
                }
            }
            $tagsToAdd = array_diff($tagSelectList,$tagExistAlready);
            foreach($tagsToAdd as $aTagToAdd) { // puis on va y ajouter ceux qui manquent.
                    array_push($tags,queryThis("getOneTag",$aTagToAdd));
            }
        }
        

        
        /* Affichage des tags triés */
        
        echo($filtrerHtml);
        echo("<ul>");
        
        foreach ($tags as $aTagInfos) {
            
            // au clic sur le lien :
            $tagOnclick = "' onclick='addTag(event,\"".$aTagInfos['nomPourUrl']."\")'";
            
            // le tag est-il selectionné ?
            $tagClass= "";
            if (in_array($aTagInfos['nomPourUrl'],$tagSelectList)) {
                $tagClass= " class='tagSelect' "; // on ajoute une classe
                $tagOnclick = "' onclick='removeTag(event,\"".$aTagInfos['nomPourUrl']."\")'"; // on change l'event.
            }
            
            // affichage :
            echo(   "<li>
                        <a href='?tag=".$aTagInfos['nomPourUrl'].$tagOnclick.$tagClass.">
                            <span>".$aTagInfos['nbUsages']."</span>
                            ".$aTagInfos['nom']."
                        </a>
                    </li>"  ); // Plus lisible : <a href="?tag=graphisme" onclick="addTag(event,'Graphisme')" class="tagSelect">
 
        } unset($tags);
        
        echo("<p><a href=''>Voir plus...</a></p></ul>");
        
        
    }



?>
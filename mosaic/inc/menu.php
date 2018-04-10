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



<menu class="col-6-2">
      <?php fillMenu(); ?> 
</menu>



<?php

    function fillMenu() {
        
        $tags = getTag(-1);
        
        
        
        /* Tri des tags par nombre d'usage */

        $tagsTries = array(); // array(indexDansTags=>nbUsages).
        
        foreach($tags as &$oneTagInfos) { // &$oneTagInfos et pas $oneTagInfos.
            
            $infosDuTag = array($oneTagInfos[0]=>$oneTagInfos[2]);
            $tagsTries += $infosDuTag;
            
            // on est obligés de faire correspondre le nom à l'url..
            $nomTagPourUrl = $oneTagInfos[1]; /*****************/// à faire.
                
            // cette info servira plus bas.
            array_push($oneTagInfos,$nomTagPourUrl);
            
            /* /!\ On ne peut faire un array_push sur une valeur ($oneTagInfos) du tableau ($tags) passé en foreach que grace au & -> &$oneTagInfos. https://stackoverflow.com/questions/9920619/changing-value-inside-foreach-loop-doesnt-change-value-in-the-array-being-itera#9920684 "In order to be able to directly modify array elements within the loop precede $value with &. In that case the value will be assigned by reference." */ // Elle m'aura bien fait patiner celle là... -_-
            
        } unset($oneTagInfos); // vide $oneTagInfos.
        
        natsort($tagsTries); // cet array peut être trié.
        $tagsTries = array_reverse($tagsTries,true);
        
        // raccourcir la liste à afficher :
        $offsetAffichage = 0;
        $lengthAffichage = 5;
        $shortTags = array_slice($tagsTries,$offsetAffichage,$lengthAffichage,true);
        
        
        
        /* Tags selectionnés */
        
        $tagSelectList = array();
        $filtrerHtml = "<h1>Filtrer</h1>";
        
        if (!empty($_GET["tag"])) {
            
            // s'il y en a on doit pouvoir tous les déselectionner d'un coup.
            $filtrerHtml = "<a href='index.php'><h1>Défiltrer</h1></a>";
            
            $safeGetTag = htmlspecialchars($_GET["tag"]); /****secure****/
            $tagSelectList = (explode(",",$safeGetTag));
            // ce tableau servira aussi plus bas pour insérer une classe.
            
            // ils doivent forcément apparaitre dans le menu,
            foreach($tags as $oneTagInfos) {
                foreach($tagSelectList as $aSelectedTag) {
                    if ($aSelectedTag == $oneTagInfos[3]) {
                        $shortTags += array($oneTagInfos[0]=>$oneTagInfos[2]);
                    }
                }
                
            } unset($oneTagInfos,$aSelectedTag);
            
        }
        

        
        /* Affichage des tags triés */
        
        echo($filtrerHtml);
        echo("<ul>");
        
        foreach ($shortTags as $tagIndex => $tagNbUsages) {
            
            $nomTag = $tags[$tagIndex][1];
            $nomTagPourUrl = $tags[$tagIndex][3]; // obtenu dans le traitement des Tags selectionnés.
            
            // au clic sur le lien :
            $tagOnclick = "' onclick='addTag(event,\"".$nomTagPourUrl."\")'";
            
            // le tag est-il selectionné ?
            $tagClass= "";
            if (in_array($nomTagPourUrl,$tagSelectList)) {
                $tagClass= " class='tagSelect' "; // on ajoute une classe
                $tagOnclick = "' onclick='removeTag(event,\"".$nomTagPourUrl."\")'"; // on change l'event.
            }
            
            // affichage :
            echo(   "<li>
                        <a href='?tag=".$nomTagPourUrl.$tagOnclick.$tagClass.">
                            <span>".$tagNbUsages."</span>
                            ".$nomTag."
                        </a>
                    </li>"  ); // Plus lisible : <a href="?tag=graphisme" onclick="addTag(event,'Graphisme')" class="tagSelect">
 
        } unset($tagNbUsages);
        
        echo("<p><a href=''>Voir plus...</a></p></ul>");
        
        
    }



?>
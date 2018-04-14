<?php


function testNotEmptyGetFromUrl ($aThing) { // vérifie uniquement que ce n'est pas vide.
    
    
    if (isset($_GET[$aThing])) { // éviter des erreurs avec certains hébergeurs.
        
        if (!empty($_GET[$aThing])) {
            return true;
            
        } else { // but empty return false if 0 :
            
            $safeGet = getGetFromUrl($aThing);
            return ($safeGet == 0) ? true : false;
        
        }
    
    } else { return false; }

}

function getGetFromUrl ($aThing) { // retourne un résultat secure.
    
    $safeGetThing = htmlspecialchars($_GET[$aThing]);
    // trim trim((string)$safeGetThing, '-')
    
    // +1

    if ($aThing == "num") {
        
        // pour que FILTER_VALIDATE_INT fonctionne :
        $safeGetThing = (int)$safeGetThing;
        
        // retourne false si not a number et 0; retire les + et espaces devant et les .xxx après.
        $safeGetThing = filter_var($safeGetThing, FILTER_VALIDATE_INT);
        
        if ($safeGetThing < 0 ) { $safeGetThing *= -1; } // reste les négatifs à convertir.
        if (!$safeGetThing) { $safeGetThing = 0; } // et si c'était un 0 ou un nan, false = 0.
        
        /********TODO*********/// méthode ici pour vérif que l'index ne dépasse pas ?
        
    } else {
        
        $safeGetThing = trim( $safeGetThing, $character_mask = " \t\n\r\0\x0B" );
        // trim retournera "" si null.
        
        // $safeGetThing = filter_input_array($safeGetThing, FILTER_SANITIZE_STRING);
        // filter_input_array() expects parameter 1 to be long, string given in C:\wamp\www\mosaic\inc\bridge.php on line 48
        
    }
    
    //var_dump($safeGetThing);
    return $safeGetThing;
    

    
}



// http://wisercoder.com/check-for-integer-in-php/

// Pass a random generated string ( hashed ) as a hidden element in your form each time your form is rendered, save the string on generation in you're session and on form sumbit check for that first, if they don't match then you don't eaven need to bother checking the id or other elements sent

/*    

    // TAGS pour List :
    $safeGetTag = array(); // TODO session ?
    if (!empty($_GET["tag"])) {
        
        // TODO 1. sécuriser ce qui vient de Get.
        $safeGetTag = htmlspecialchars($_GET["tag"]);
        
    }
    
    
    // NUM personne pour profil :
    // num !empty
    // num is a number
    $safeGetNum = htmlspecialchars($_GET["num"]);
    $profilNums = getProfilNums($theNum);
    
*/

/*

https://secure.php.net/manual/en/book.filter.php
https://secure.php.net/manual/en/function.filter-input.php
https://secure.php.net/manual/fr/filter.filters.sanitize.php
https://secure.php.net/manual/en/filter.filters.validate.php
Remember to trim() the $_POST before your filters are applied
https://www.w3schools.com/php/php_filter.asp

To include multiple flags, simply separate the flags with vertical pipe symbols.
For example, if you want to use filter_var() to sanitize $string with FILTER_SANITIZE_STRING and pass in FILTER_FLAG_STRIP_HIGH and FILTER_FLAG_STRIP_LOW, just call it like this:
$string = filter_var($string, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);

https://secure.php.net/manual/en/function.urlencode.php <- pas sur get !!
js : window.location.href = 'display_album.php?album=' + encodeURIComponent(title);
Replace ampersands with &amp; blank space is equivalent to “%20” : with %3A / with %2F https://perishablepress.com/url-character-codes/

TODO 2. url-iser les noms.
on est obligés de faire correspondre le nom à l'url..
$nomTagPourUrl = $oneTagInfos[1]; /*****************

requetes sql http://www.bitrepository.com/sanitize-data-to-prevent-sql-injection-attacks.html
notamment mais pas que : 
$query = sprintf("SELECT * FROM `members` WHERE username='%s' AND password='%s'", $username, $password);
The %s from the sprintf() function indicates that the argument is treated as and presented as a string.

https://secure.php.net/manual/en/function.htmlentities.php htmlspecialchars mais pour garder les elements d'urls. -> pour linkedin etc ?

captchas : https://www.w3.org/TR/turingtest/

*/

    /* Qui et quels projets */
    function getProfilNums($theNum) {
        
        // num personne, num projets...
        $profilNums = array();

        array_push($profilNums,$safeGetNum);
        
        // Travailler -> liste des projets
        
        // for
        // array_push les n° de projets
        
        return $profilNums;
    }


    /* infos */

    function getPersonne($aNum) {

        $personne = array(
            
             // num mail mdp admin ban prénom pseudo nom twitter linkedin site desc avatar
            array(0,"cami@vanille.com","vanille",0,0,"Camille","","Vanille","@vanille","","vanille.com","Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. ","img/avatars/0.jpg"),
            array(1,"pinpin@lapin.com","lapin",0,0,"Juan","Pippin","Fisher","@pippin","pippin","pippin.com","Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.","img/avatars/1.jpg"),
            array(2,"dotydot@dot.com","dot",0,0,"Blue","","dotstar","@blue","blue","blue.com","Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?","img/avatars/2.jpg"),
            array(3,"grrr@grrr.com","grrr",0,0,"Teddy","","Furbear","@teddy","teddy","teddy.com","But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness.","img/avatars/3.jpg"),
            array(4,"picpicpic@ture.com","ture",0,0,"Dan","Pic","Greatcam","@picpicpic","","picpicpic.com","No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure.","img/avatars/4.jpg"),
            array(5,"flyfly@flyfly.com","fly",0,0,"Marty","","Fly","@fly","","fly.com","To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it?","img/avatars/5.jpg"),
            array(6,"potpotpot@pot.com","pot",0,0,"Potter","","Coolbus","@potpotpot","","potpotpot.com","But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?","img/avatars/6.jpg"),
            array(7,"lalala@la.com","la",0,0,"","","Lace","@lalala","lalala","","At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio.","img/avatars/7.jpg"),
            array(8,"gregar@gargre.com","garden",0,0,"Green","Pretty","Garden","","","","blablabla","img/avatars/8.jpg"),
            array(9,"lili@cena.com","cena",0,0,"Light","","Cena","@cena","","","blablabla","img/avatars/9.jpg"),
            array(10,"grass@grass.com","grass",0,0,"","Wide","Outdoor","@outdoor","","","blablabla","img/avatars/10.jpg"),
            array(11,"miam@miam.com","miam",0,0,"Adorable","Cute","Party","","adorable","adorable.com","blablabla","img/avatars/11.jpg"),
            array(12,"o@cean.com","cean",0,0,"Karin","","Ocean","","ocean","ocean.com","blablabla","img/avatars/12.jpg"),
            array(13,"chap@pie.com","pie",0,0,"Chappie","Mountain","Hat","@chappie","","","blablabla","img/avatars/13.jpg"),
            array(14,"__@__.com","blanche",0,0,"Blanche","White","Glasses","","","blanche.com","blablabla","img/avatars/14.jpg"),
            array(15,"pink@brun.com","pink",0,0,"Rose","","Brown","","pink","","blablabla","img/avatars/15.jpg"),
            array(16,"point@glasses.com","dot",0,0,"Dot","","Curly","","","","blablabla","img/avatars/16.jpg"),
            array(17,"denise@masque.com","mask",0,0,"Venicia","","Mask","@venicia","venicia","venicia.com","blablabla","img/avatars/17.jpg"),
            array(18,"large@town.com","big",0,0,"Secret","Big","City","@bigcity","","","blablabla","img/avatars/18.jpg"),
            array(19,"jiji@ne.com","jean",0,0,"Jean","Jeanne","Graph","","","","blablabla","img/avatars/19.jpg"),
            array(20,"lili@dev.com","dev",0,0,"","Little","Dev","","","","blablabla","img/avatars/20.jpg"),
            array(21,"sourire@sourire.com","beard",0,0,"Smile","","Whitebeard","@smile","","smile.com","blablabla","img/avatars/21.jpg"),
            array(22,"plage@plage.com","wave",0,0,"Wave","","Surfer","@wave","","","blablabla","img/avatars/22.jpg"),
            array(23,"ponponpon@pont.com","pont",0,0,"Bridge","Ocean","Mister","","mister","","blablabla","img/avatars/23.jpg"),
            array(24,"ella@ella.com","ella",0,0,"Two","","Ombrella","@ombrella","","ombrella.com","blablabla","img/avatars/24.jpg"),
            array(25,"yumyum@coffee.com","yum",0,0,"Chill","","Coffee","","","","blablabla","img/avatars/25.jpg"),
            array(26,"will@sky.com","will",0,0,"Will","Sky","Blondy","","","will.com","blablabla","img/avatars/26.jpg"),
            array(27,"ray@ure.com","ray","Ray",0,0,"Stripes","Yellow","@ray","","ray.com","blablabla","img/avatars/27.jpg"),
            array(28,"autumn@autumn.com","feuille",0,0,"Leaf","Walking","Forest","@leaf","","leaf.com","blablabla","img/avatars/28.jpg"),
            array(29,"sand@sand.com","sable",0,0,"Sand","","Marine","","","","blablabla","img/avatars/29.jpg"),
            array(30,"lili@manager.com","mana",0,0,"Lila","","Manager","","","","blablabla","img/avatars/30.jpg")
        );
        
        $personneRequest;
        
        if ($aNum >= 0) {
            return $personne[$aNum];
            
        } else {
            return $personne;
        }
        
    }


    function getTag($aNum) {

        $tag = array( // num, nom, nbUsages
                array(0,"Freelance",12),
                array(1,"Journalisme",15),
                array(2,"Developpement",10),
                array(3,"CommunityManagement",6),
                array(4,"Unity",4),
                array(5,"Management",7),
                array(6,"Graphisme",3),
                array(7,"GameDesign",1),
                array(8,"2D",0),
                array(9,"LevelDesign",4),
                array(10,"3D",7),
                array(11,"GameJam",9),
                array(12,"Lead",2),
                array(13,"Indie",4),
                array(14,"NeedJob",7),
                array(15,"Illustration",0),
                array(16,"ConceptArt",9),
                array(17,"Chroniques",5),
                array(18,"Youtube",4),
                array(19,"Streaming",1),
                array(20,"Recherche",8),
                array(21,"Enseignement",6),
                array(22,"Musique",1),
                array(23,"Composing",0),
                array(24,"SoundDesign",3),
                array(25,"Animation",4),
                array(26,"Expat",2),
                array(27,"ToolDev",2),
                array(28,"Politique",4),
                array(29,"NarrativeDesign",4),
                array(30,"Web",8),
            );
        
        if ($aNum >= 0) {
            return $tag[$aNum];
            
        } else {
            return $tag;
        }

    }


    function getDepeindre() {
        
        $depeindre = array( //num, numPers, numTag
            array(0,0,6),
            array(1,3,6),
            array(2,2,1),
            array(3,3,1),
            array(4,7,15),
            array(5,1,12),
            array(6,2,4),
            array(7,3,14),
            array(8,4,1),
            array(9,5,7),
            array(10,6,2),
            array(11,7,3),
            array(12,8,4),
            array(13,9,5),
            array(14,10,8),
            array(15,0,9),
            array(16,1,10),
            array(17,2,11),
            array(18,3,12),
            array(19,4,13),
            array(20,5,14),
        );

        return $depeindre;
    }


    function getDecrire() {
        
        $decrire = array( //num, numProj, numTag
            array(0,9,2),
            array(1,8,4),
            array(2,7,6),
            array(3,6,8),
            array(4,5,10),
            array(5,4,12),
            array(6,3,14),
            array(7,2,16),
            array(8,1,18),
            array(9,0,20),
            array(10,9,22),
            array(11,8,24),
            array(12,7,26),
            array(13,6,28),
            array(14,5,30),
            array(15,4,1),
            array(16,3,3),
            array(17,2,5),
            array(18,1,7),
            array(19,0,9),
            array(20,9,11),
        );

        return $decrire;
    }

  
    function getTravailler() {
        
        $travailler = array( //num, numPers, numProj
            array(0,9,0),
            array(1,8,2),
            array(2,7,4),
            array(3,6,6),
            array(4,5,8),
            array(5,4,0),
            array(6,3,2),
            array(7,2,4),
            array(8,1,6),
            array(9,0,8),
            array(10,9,1),
            array(11,8,3),
            array(12,7,5),
            array(13,6,7),
            array(14,5,9),
            array(15,4,1),
            array(16,3,3),
            array(17,2,5),
            array(18,1,7),
            array(19,0,9),
            array(20,9,0),
        );

        return $travailler;
    }


    function getProjet($aNum) {
        
        $projet = array( //num, mdp, nom, studio, desc, date, site, visuel.
            array(0,"sjfpelsifn","LOL","Studio Lol","Un jeu où on rigole énormément.","01/01/01","lololol.com","img/visuels/0.jpg"),
            array(1,"dfgfgdfggg","Libraire","Raplapla","Vous travaillez dans une bibliothèque.","01/01/01","pouet.com","img/visuels/1.jpg"),
            array(2,"eqzeqzezee","Lapins Attaque","5 Jours","C'est peut-être un piège avec des bruits bizarres...","01/01/01","nini.com","img/visuels/2.jpg"),
            array(3,"poihjjfgff","Bêtes Apparat","Boulanger","C'est pas gagné mais c'est sympa d'essayer !","01/01/01","gagaga.com","img/visuels/3.jpg"),
            array(4,"bnrqseezrr","Nombres on fire","Pierre","Attention, il ne faut pas partir en mission en solitaire.","01/01/01","toto.com","img/visuels/4.jpg"),
            array(5,"yuityrdfff","Hôtel Castor","Heures","Comme c'est joli il y a des rondins et c'est gentil !","01/01/01","tutu.com","img/visuels/5.jpg"),
            array(6,"azeedxdfgg","Salopette Nocturne","Vampire","La spéléologie pour les chauve-souris.","01/01/01","yop.com","img/visuels/6.jpg"),
            array(7,"dfghjjghyy","Lumière Bonsoir","Repos","C'est très tranquille.","01/01/01","hiphip.com","img/visuels/7.jpg"),
            array(8,"zezeddvfgg","Poisson ici famille","L'Equipe","Un jeu avec des familles de poissons. Des fois ils ont des points communs, mais faut pas le dire.","01/01/01","plop.com","img/visuels/8.jpg"),
            array(9,"mlmouigfgg","Patience","Reflexion","Ca s'appelle Patience mais en fait c'est vachement rapide, c'est un concept.","01/01/01","krr.com","img/visuels/9.jpg"),
        );
        
        if ($aNum >= 0) {
            return $projet[$aNum];
            
        } else {
            return $projet;
        }
        
    }



?>
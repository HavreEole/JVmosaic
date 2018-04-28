<?php

    // /!\ faire un htaccess sur le serveur pour masquer ces fichiers.
    // Contenu du .htaccess : deny from all
    // https://openclassrooms.com/courses/le-htaccess-et-ses-fonctionnalites
    // https://www.digitalocean.com/community/tutorials/how-to-use-the-htaccess-file
    // Réécrire une URL : https://www.digitalocean.com/community/tutorials/how-to-set-up-mod_rewrite

    // Masquer les erreurs PHP : https://stackoverflow.com/a/32648423
    error_reporting(E_ALL); ini_set('display_errors', 0);

    // 1. Connexion et requêtes SQL
    // 2. Récupérations GET (from url)
    // 3. Récupérations POST (from inputs)
    


    /* SQL */

    function queryThis ($aThing, $aString='-1', $aVar='-1') { // Connexion et distribution des requêtes.
        
        if (extension_loaded("PDO")) {
            
            try {
                
 
                $servername = "localhost";
                $dbname = "mosaic";
                $username = "root";
                $password = "";
                
                
                $dsn = 'mysql:host='.$servername.';dbname='.$dbname.';port=3306;charset=utf8';
                $pdo = new PDO($dsn, $username, $password);
                
                // https://secure.php.net/manual/fr/pdo.connections.php (+ 1er commentaire)
                // https://www.upguard.com/articles/top-11-ways-to-improve-mysql-security
                //https://stackoverflow.com/questions/45018620/is-pdo-database-connection-secure#45018660
                
                // https://stackoverflow.com/a/60496 :
                $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // when using PDO to access a MySQL database real prepared statements are not used by default. To fix this you have to disable the emulation of prepared statements.
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // the script will not stop with a Fatal Error when something goes wrong; it gives the developer the chance to catch any error(s) which are thrown as PDOExceptions.

                
                switch($aThing) {
                        
                    case "admins" :             return findAdmins($pdo); break;
                    case "getPersonne" :        return getPersonne($pdo,$aString,$aVar); break;
                    case "nombrePersonnes" :    return nombrePersonnes($pdo); break;
                    case "personneProjetsNums" :return personneProjetsNums($pdo,$aString); break;
                    case "getProjet" :          return getProjet($pdo,$aString,$aVar); break;
                    case "getTags" :            return getTags($pdo,$aString,$aVar); break;
                    case "getOneTag" :          return getOneTag($pdo,$aString); break;
                    case "getDepeindre" :       return getDepeindre($pdo,$aString); break;
                    case "getDecrire" :         return getDecrire($pdo,$aString); break;
                    case "getProjectMembers" :  return getProjectMembers($pdo,$aString); break;
                    case "compareTagName" :     return compareTagName($pdo,$aString); break;
                    case "getPersonnesParTags" :return getPersonnesParTags($pdo,$aString,$aVar); break;
                    default :                   return NULL; break;
     
                }
                
                $dsn = NULL; // fin de connexion.
                
 
            } catch (exception $e) { // pour qu'il n'y ait pas un message d'erreur affichant le mdp en clair sur le site en cas de problème...
                //die('Erreur:'.$e->getMessage());
                die('Erreur: Accès refusé.');
                
                return NULL;
            }
            
        }
        
    }


    
    /* REFs :
        fetch() -> retourne seulement la première ligne, sous forme d'array.
        fetchAll() -> retourne toutes les lignes, chacune sous forme d'arrays dans un array.
        fetchColumn() -> retourne juste une colonne. Ex: "SELECT COUNT('nom') FROM..." rendra juste un nombre.
        
        fetch...(PDO::FETCH_NUM) -> rendra un array avec index numérique.
        fetch...(PDO::FETCH_ASSOC) -> rendra un array avec index associatif (key=>value).
        -> Par défaut on obtient FETCH_BOTH qui renvoie chaque valeur dubliquée avec une clef numérique puis associative.
        
        fetch...(PDO::FETCH_COLUMN) -> rendra un array simple de la colonne (0=>'a',1=>'b',2=>'c'),
            au lieu d'un array avec juste une valeur dans un array, ce qui est bof :
            array( 0 => array( 0=>'a'), 1 => array( 0=>'b'), 2 => array( 0=>'c'),).
            
        Une requête complète :
            $requete = $pdo->query('SELECT * FROM table');
            $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
            $requete->closeCursor(); $requete=NULL; // fin de requête.
            return $resultat;

        Une requête préparée :
            $monNumero = 2;
            $requete = $pdo->prepare('SELECT * FROM table WHERE numero = :numero');
            $requete->execute(array('numero' => $monNumero));
            $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
            $requete->closeCursor(); $requete=NULL; return $resultat;
    */
    


    function findAdmins($pdo) { // Footer : trouver tous les admins du site.

        $requete = $pdo->query('SELECT numero,prenom,pseudo,nom FROM mz_personne WHERE admin=1');
        $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
        $requete->closeCursor(); $requete=NULL; return $resultat;
    }


    function getPersonne($pdo,$aNum,$aMode) { // Récupérer une personne
        
        $theQuery = 'SELECT ';
        
        switch ($aMode) {
            case 'profil': $theQuery .= 'numero,ban,prenom,pseudo,nom,twitter,linkedin,website,description,urlAvatar'; break;
            case 'list': $theQuery = 'numero,ban,prenom,pseudo,nom,urlAvatar'; break;
            case 'connexion': $theQuery = 'numero,email,mdp,ban'; break;
            default : $theQuery = 'numero'; break;
        }
        
        $theQuery .= ' FROM mz_personne WHERE numero = :numero';
        
        $requete = $pdo->prepare($theQuery);
        $requete->execute(array('numero' => $aNum));
        $resultat = $requete->fetch(PDO::FETCH_ASSOC);
        $requete->closeCursor(); $requete=NULL; return $resultat;
    }


    function nombrePersonnes($pdo) { // compter le nombre total de personnes
        
        $requete = $pdo->query('SELECT COUNT(ban) FROM mz_personne WHERE ban = 0');
        $resultat = $requete->fetchColumn();
        $requete->closeCursor(); $requete=NULL; return $resultat;
    }


    function personneProjetsNums($pdo,$aNum) { // récupérer les numeros de projets d'une personne
        
        $requete = $pdo->prepare('SELECT numero_PROJET FROM mz_travailler WHERE numero_PERSONNE = :numero');
        $requete->execute(array('numero' => $aNum));
        $resultat = $requete->fetchAll(PDO::FETCH_COLUMN);
        $requete->closeCursor(); $requete=NULL; return $resultat;
    }


    function getProjet($pdo,$aNum,$mdp) { // récupérer un projet
        
        $theQuery = 'SELECT nom,studio,description,dateSortie,website,urlVisuel FROM mz_projet WHERE numero = :numero';
        
        if ($mdp != '-1') { $theQuery = 'SELECT numero,mdp FROM mz_projet WHERE numero = :numero'; }
        
        $requete = $pdo->prepare($theQuery);
        $requete->execute(array('numero' => $aNum));
        $resultat = $requete->fetch(PDO::FETCH_ASSOC);
        $requete->closeCursor(); $requete=NULL; return $resultat;
    }


    function getTags($pdo,$affichageLength,$affichageOffset) { // Récupérer une liste de tags, triés par nb d'affichages.

        
        $requete = $pdo->prepare('SELECT nom,nbUsages FROM mz_tags ORDER BY nbUsages DESC LIMIT :affichageLength');
        $requete->execute(array('affichageLength' => $affichageLength));
        $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
        $requete->closeCursor(); $requete=NULL;
        
        foreach ($resultat as &$oneResultat) { // Faire correspondre le nom à l'url :

            $nomTagPourUrl = strtolower($oneResultat['nom']); // pas de majs
            $nomTagPourUrl = preg_replace('/[ ]/', '-', $nomTagPourUrl); // les espaces sont des -.
            // ! on autorisera que a-zA-Z0-9 et - dans la création de tags.
            
            $oneResultat['nomPourUrl'] = $nomTagPourUrl;
            
            /* /!\ On ne peut faire un array_push sur une valeur ($oneResultat) du tableau ($resultat) passé en foreach que grace au & -> &$oneResultat. https://stackoverflow.com/questions/9920619/changing-value-inside-foreach-loop-doesnt-change-value-in-the-array-being-itera#9920684 "In order to be able to directly modify array elements within the loop precede $value with &. In that case the value will be assigned by reference." */ // Elle m'aura bien fait patiner celle là... -_-
        }
        
        // calculer et trier le nombre d'utilisations des tags en temps réel ?
        // Juste usages par personnes : SELECT t.nom,count(d.numero_TAGS) ct FROM `tags` t inner join depeindre d on t.numero = d.numero_TAGS group by t.nom ORDER BY `ct` DESC
        // Ou usages par personnes ET projets : // SELECT DISTINCT nom,count(d.numero_TAGS) ct from tags t INNER JOIN ( SELECT numero_PERSONNE,numero_TAGS FROM depeindre UNION SELECT numero_PERSONNE,numero_TAGS FROM decrire d2 INNER JOIN travailler tr ON d2.numero_PROJET = tr.numero_PROJET ) as d ON d.numero_TAGS = t.numero group by t.nom ORDER BY ct DESC;
        
        return $resultat;
        
    }


    function getOneTag($pdo,$anUrlName) { // Récupérer un tag
        
        //faire correspondre l'url au tag
        $aName = preg_replace('/[-]/', ' ', $anUrlName); // des espaces
        $aName = ucwords($aName); // maj devant chaque mot
        // /!\ ne marche pas pour "2D" par exemple, ce qui peut poser problème.
        
        /* Ref si on veut reverse */
        //$nomTagPourUrl = strtolower($resultat['nom']); // pas de majs
        //$nomTagPourUrl = preg_replace('/[ ]/', '-', $nomTagPourUrl); // les espaces sont des -.
        
        $requete = $pdo->prepare('SELECT nom,nbUsages FROM mz_tags WHERE nom = :nom');
        $requete->execute(array('nom' => $aName));
        $resultat = $requete->fetch(PDO::FETCH_ASSOC);
        $requete->closeCursor(); $requete=NULL;
        
        $resultat['nomPourUrl'] = $anUrlName;
        
        return $resultat;
        
    }


    function getDepeindre($pdo,$aNum) { // récupérer les tags qui depeignent une personne.

        $requete = $pdo->prepare('  SELECT nom FROM mz_tags t
                                    INNER JOIN mz_depeindre d ON t.numero = d.numero_TAGS
                                    WHERE d.numero_PERSONNE = :numero');
        $requete->execute(array('numero' => $aNum));
        $resultat = $requete->fetchAll(PDO::FETCH_COLUMN);
        $requete->closeCursor(); $requete=NULL; return $resultat;
    }


    function getDecrire($pdo,$aNum) { // récupérer les tags qui décrivent un projet
        
        $requete = $pdo->prepare('  SELECT nom FROM mz_tags t
                                    INNER JOIN mz_decrire d ON t.numero = d.numero_TAGS
                                    WHERE d.numero_PROJET = :numero');
        $requete->execute(array('numero' => $aNum));
        $resultat = $requete->fetchAll(PDO::FETCH_COLUMN);
        $requete->closeCursor(); $requete=NULL; return $resultat;
    }


    function getProjectMembers($pdo,$aNum) { // liste des gens qui travaillent sur le même projet
        
        $requete = $pdo->prepare('  SELECT p.numero,nom,prenom,pseudo FROM mz_personne p
                                    INNER JOIN mz_travailler t ON p.numero = t.numero_PERSONNE
                                    WHERE t.numero_PROJET = :numero');
        $requete->execute(array('numero' => $aNum));
        $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
        $requete->closeCursor(); $requete=NULL; return $resultat;
    }


    function compareTagName($pdo,$anUrlName) { // Comparer les tags de l'url aux tags de la db.
            
        //faire correspondre l'url au tag
        $aName = preg_replace('/[-]/', ' ', $anUrlName); // des espaces
        $aName = ucwords($aName); // maj devant chaque mot

        $requete = $pdo->prepare('SELECT nom FROM mz_tags WHERE nom = :nom');
        $requete->execute(array('nom' => $aName));
        $resultat = $requete->fetchColumn();
        $requete->closeCursor(); $requete=NULL;

        if (!$resultat) { $anUrlName = ''; }

       return $anUrlName;
            
    }


    function getPersonnesParTags($pdo,$anArray,$affichageLength) { // -> liste des personnes par tags.
        
        $resultatBrut = array();
        $resultat = array();
        
        
        foreach ($anArray as $oneTagName) { // liste des personnes pour chaque tag
            
            //faire correspondre l'url au tag
            $oneTagName = preg_replace('/[-]/', ' ', $oneTagName); // des espaces
            $oneTagName = ucwords($oneTagName); // maj devant chaque mot
            
            // Personnes ayant le tag dans leur profil mais pas dans leurs projets :
            /*$requete = $pdo->prepare('  SELECT numero_PERSONNE FROM depeindre d
                                        INNER JOIN tags t on d.numero_TAGS = t.numero
                                        WHERE t.nom = :nom
                                        LIMIT :affichageLength');*/

            // Personnes ayant le tag soit dans leur profil soit dans leurs projets :
            $requete = $pdo->prepare('  SELECT DISTINCT numero_PERSONNE FROM
                                            (   SELECT numero_PERSONNE,numero_TAGS FROM mz_depeindre
                                                UNION
                                                SELECT numero_PERSONNE,numero_TAGS FROM mz_decrire d2
                                                    INNER JOIN mz_travailler tr ON d2.numero_PROJET = tr.numero_PROJET
                                            ) as d
                                        INNER JOIN mz_tags t ON d.numero_TAGS = t.numero
                                        WHERE t.nom = :nom
                                        LIMIT :affichageLength');
            $requete->execute(array('nom' => $oneTagName, 'affichageLength' => $affichageLength+1));
            $resultat = $requete->fetchAll(PDO::FETCH_COLUMN);
            $requete->closeCursor(); $requete=NULL;

            array_push($resultatBrut,$resultat);
        }
        
        
        if (count($resultatBrut)>1) { // si plusieurs tags, on fait l'intersection :
            
            $intersectionResultats = array();
            
            for ($i=0; $i<count($resultatBrut)-1; $i++) {
                if ($i == 0) { $intersectionResultats = $resultatBrut[$i]; }
                $intersectionResultats = array_intersect($intersectionResultats,$resultatBrut[$i+1]);
            }
            
            $resultat = $intersectionResultats;
            
            
        } else { // sinon on renvoie juste la liste :

            $resultat = $resultatBrut[0];
        }

        
        return $resultat;
        
    }
    
    // TODO
    // longueur max : limiter le nombre de résultats retournés sur les grosses requetes.
    // embêtant de devoir recharger toute la page. Ajax ?
    // personnes bannies ?
    




    /* RECUPERATIONS */


    /* vérifie uniquement que ce n'est pas vide. */
    function testNotEmptyGetFromUrl ($aThing) {

        if (isset($_GET[$aThing])) { // éviter des erreurs avec certains hébergeurs.

            if (!empty($_GET[$aThing])) {
                return true;

            } else { // but empty return false if 0 :
                return ($_GET[$aThing] == 0) ? true : false;
                
            }

        } else { return false; }

    }


    /* (URL) retourne un résultat secure depuis les GET. */
    function getGetFromUrl ($aThing) {

        $safeGetThing = $_GET[$aThing];

        if ($aThing == "num") {

            $safeGetThing = preg_replace('/[^0-9]/', '', $safeGetThing); // retire tout non-digit
            $safeGetThing = preg_replace('/\A[0+]/', '', $safeGetThing); // puis retire les 0 au début
            if ( $safeGetThing == "" ) { $safeGetThing = "0"; } // s'il ne reste rien on en fait un 0.

            // vérifier que l'index ne dépasse pas.
            if ( $safeGetThing >= queryThis("nombrePersonnes") ) { $safeGetThing = "0"; }

        } else if ($aThing == "tag") {

            // Any single character except : the range a-z or A-Z or 0-9 or ,
            $safeGetThing = preg_replace('/[^a-zA-Z0-9,-]/', '', $safeGetThing);

        }

        return $safeGetThing;

    }


    /* (INPUT) retourne un résultat secure depuis les POST. */
    function getPostFromInput () {
        
        // -> htmlspecialchars pour qqchose qui va être affiché en html
        // -> + sanitization lib, mais en attendant je vais juste retirer les trucs louches.
        // <>~%'{([-|_\^)]=}+$*!:;.?é`çà@$£/§#& ,
        
        /* ... */
        
        /*
            htmlspecialchars($_GET[$aThing], ENT_QUOTES);
            htmlentities($safeGetThing);
            strip_tags($safeGetThing);
            filter_var($safeGetThing, FILTER_SANITIZE_ENCODED);
            https://secure.php.net/manual/en/function.urlencode.php <- pas sur get !!
        */
        
        // MDP
        // mdp faire un hashtag et ne jamais le décoder.
        // comparer avec la tentative de mdp hashée de l'user quand il veut se connecter.
        // sha1($password) pour crypter le mdp dans la base
        // https://secure.php.net/manual/fr/faq.passwords.php#faq.passwords.fasthash
        // voir wikipedia plutôt pour l'explication du salt.
        
        // TAGS (création)
        // ! on autorisera QUE les alphas, digits et espaces. Pas d'espaces multiples, pas de "".
        
        // Twitter -> placer un @ devant; verif les caractères permis dans les @ twitter.
        // linkedin -> placer l'url normale devant; autoriser les - pour linkedin.
        // website : autoriser / _ - . et ?
        
        // messages d'avertissement :
        // ne pas entrer son mail ou tel
        // reflechir avant d'indiquer sa ville dans les tags
        // message habituel mdp fort
        
        // captchas : pour l'instant juste mettre un mot de passe fort, en dur.
    
    }




/* About sql injections, xss.. : http://kunststube.net/escapism/ */

// URL TAGS
// filter_sanitize_encoded pour les url, -> pour comparer les tags de la bdd avec ceux de l'url ?
// js : window.location.href = '?tag=' + encodeURIComponent(title); Replace ampersands with &amp; blank space is equivalent to “%20” : with %3A / with %2F https://perishablepress.com/url-character-codes/

// SQL
// the mysql_ prefix / DB-handler is outdated, deprecated and should not be used at all. The safest way is to use either mysqli_ or PDO, and use prepared statements.
// -> https://stackoverflow.com/questions/60174/how-can-i-prevent-sql-injection-in-php?rq=1
// http://www.bitrepository.com/sanitize-data-to-prevent-sql-injection-attacks.html
// notamment mais pas que, dans $query = sprintf("SELECT * FROM `members` WHERE username='%s' AND password='%s'", $username, $password); The %s from the sprintf() function indicates that the argument is treated as and presented as a string.

    /* $requete = $pdo->prepare('SELECT nom FROM personne WHERE numero = :numero');
       $requete->execute(array('numero' => $numero))
                 or die(print_r($requete->errorInfo()));
                 // récupérer une erreur, pas trop l'impression que ça marche. :?*/

// REFS
// https://www.owasp.org/index.php/Cross-site_Scripting_%28XSS%29
// http://wisercoder.com/check-for-integer-in-php/

// FILTERS
// https://secure.php.net/manual/en/book.filter.php
// https://www.w3schools.com/php/php_filter.asp
// Remember to trim() the $_POST before your filters are applied
// To include multiple flags, simply separate the flags with vertical pipe symbols.

// CAPTCHAS : https://www.w3.org/TR/turingtest/
// ASTUCE ? Pass a random generated string ( hashed ) as a hidden element in your form each time your form is rendered, save the string on generation in your session and on form sumbit check for that first, if they don't match then you don't eaven need to bother checking the id or other elements sent


?>
<?php
if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    $racine = "..";
}
include_once "$racine/modele/bd.resto.inc.php";
include_once "$racine/modele/bd.typecuisine.inc.php";
include_once "$racine/modele/bd.photo.inc.php";

// creation du menu burger
$menuBurger = array();
$menuBurger[] = array("url" => "./?action=recherche&critere=nom", "label" => "Recherche par nom");
//? not needed START ---------------------
// $menuBurger[] = array("url" => "./?action=recherche&critere=adresse", "label" => "Recherche par adresse");
// $menuBurger[] = array("url" => "./?action=recherche&critere=typecuisine", "label" => "Recherche par typecuisine");
//? not needed END ---------------------
$menuBurger[] = array("url" => "./?action=recherche&critere=rechercheavancee", "label" => "recherche Avancee");



$msg = '';

// list type cuisine
$listTypesCuisine = getTypesCuisine();

// critere de recherche par defaut
$critere = "nom";
if (isset($_GET["critere"])) {
    $critere = $_GET["critere"];
}

// recuperation des donnees GET, POST, et SESSION
if (isset($_GET["critere"])) {
    $critere = $_GET["critere"];
}
$nomR = "";
if (isset($_POST["nomR"])) {
    $nomR = trim($_POST["nomR"]);
}
$voieAdrR = "";
if (isset($_POST["voieAdrR"])) {
    $voieAdrR = trim($_POST["voieAdrR"]);
}
$cpR = "";
if (isset($_POST["cpR"])) {
    $cpR = trim($_POST["cpR"]);
}
$villeR = "";
if (isset($_POST["villeR"])) {
    $villeR = trim($_POST["villeR"]);
}

$idTC = 0;
if (isset($_POST["idTC"])) {
    $idTC = (int) $_POST["idTC"];
}

// appel des fonctions permettant de recuperer les donnees utiles a l'affichage 


switch ($critere) {
    // recherche par nom
    case 'nom':
        $listeRestos = getRestosByNomR($nomR);
        break;
    //? not needed START ---------------------
    // // recherche par adresse
    // case 'adresse':
    //     $listeRestos = getRestosByAdresse($voieAdrR, $cpR, $villeR);
    //     break;
    // // recherche par typecuisine
    // case 'typecuisine':

    //     $listeRestos = getRestosByIdtc($idTC);
    //     if (count($listeRestos) < 1) {
    //         $msgTC = "Il n'existe aucun restaurant spécialisé dans ce type de cuisine.";
    //     }
    //     break;
    //? not needed END ---------------------
    // recherche avancee
    case 'rechercheavancee':
        $hasAddress = !empty($voieAdrR) || !empty($cpR) || !empty($villeR);
        $hasIdTC = !empty($idTC) && $idTC > 0;
        $listeRestos = [];
        if ($hasAddress && $hasIdTC) {
            $listeRestos = getRestosByRAvancee($idTC, $voieAdrR, $cpR, $villeR);
        } elseif ($hasAddress && !$hasIdTC) {
            $listeRestos = getRestosByAdresse($voieAdrR, $cpR, $villeR);

        } elseif (!$hasAddress && $hasIdTC) {
            $listeRestos = getRestosByIdtc($idTC);
        }
        if (count($listeRestos) < 1) {
            $msg = "Aucun restaurant trouvé.";
        }
        break;
}



// traitement si necessaire des donnees recuperees
;

// appel du script de vue qui permet de gerer l'affichage des donnees
$titre = "Recherche d'un restaurant";
include "$racine/vue/entete.html.php";
include "$racine/vue/vueRechercheResto.php";
if (!empty($_POST)) {
    // affichage des resultats de la recherche
    include "$racine/vue/vueResultRecherche.php";
}
include "$racine/vue/pied.html.php";

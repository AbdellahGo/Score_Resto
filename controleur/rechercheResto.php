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
$menuBurger[] = array("url" => "./?action=recherche&critere=adresse", "label" => "Recherche par adresse");
$menuBurger[] = array("url" => "./?action=recherche&critere=typecuisine", "label" => "Recherche par typecuisine");
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

$listIdTC = array_map('intval', $_POST["typesCuisine"] ?? []);


switch ($critere) {
    // recherche par nom
    case 'nom':
        $listeRestos = getRestosByNomR($nomR);
        break;
    // recherche par adresse
    case 'adresse':
        $listeRestos = getRestosByAdresse($voieAdrR, $cpR, $villeR);
        break;
    // recherche par typecuisine
    case 'typecuisine':
        $listeRestos = getRestosByIdtc($listIdTC);
        if (count($listeRestos) < 1) {
            $msg = "Il n'existe aucun restaurant spécialisé dans ce type de cuisine.";
        }
        break;
    // recherche avancee
    case 'rechercheavancee':
        $listeRestos = [];
        $hasAddress = !empty($voieAdrR) || !empty($cpR) || !empty($villeR);
        $hasIdTC = !empty($listIdTC);

        if (!$hasIdTC) {
            $msg = "Veuillez sélectionner au moins un type de cuisine.";
        } elseif (!$hasAddress) {
            $msg = "Veuillez saisir au moins un champ d'adresse.";
        } else {
            $listeRestos = getRestosByRAvancee($listIdTC, $voieAdrR, $cpR, $villeR);
            if (count($listeRestos) < 1) {
                $msg = "Aucun restaurant trouvé.";
            }
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

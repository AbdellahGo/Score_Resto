<?php
include_once "$racine/modele/authentification.inc.php";
include_once "$racine/modele/bd.resto.inc.php";

$mailU = getMailULoggedOn();
$roleU = $_SESSION['roleU'] ?? 'user';

if ($roleU !== 'moderateur') {
    header('Location: ./?action=accueil');
    exit();
}

$msg = '';
if ($mailU !== '') {
    if (
        !empty($_POST["nomR"]) && !empty($_POST["numAdrR"]) && !empty($_POST["voieAdrR"]) && !empty($_POST["cpR"]) && !empty($_POST["villeR"]) && !empty($_POST["descR"]) && !empty($_POST["horairesR"]) && !empty($_POST["latitudeDegR"]) && !empty($_POST["longitudeDegR"])
    ) {
        $nomR = $_POST["nomR"];
        $numAdrR = $_POST["numAdrR"];
        $voieAdrR = $_POST["voieAdrR"];
        $cpR = $_POST["cpR"];
        $villeR = $_POST["villeR"];
        $descR = $_POST["descR"];
        $horairesR = $_POST["horairesR"];
        $latitudeDegR = $_POST["latitudeDegR"];
        $longitudeDegR = $_POST["longitudeDegR"];
        
        $critiquesEnAttente = addResto($nomR, $numAdrR, $voieAdrR, $c, $villeR, $descR, $horairesR, $latitudeDegR, $longitudeDegR);
    }

}


$titre = "Ajouter un restaurant";
include "$racine/vue/entete.html.php";
include "$racine/vue/vueModerateurR.php";
include "$racine/vue/pied.html.php";
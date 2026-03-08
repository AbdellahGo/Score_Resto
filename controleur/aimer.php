<?php
if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    $racine = "..";
}
include_once "$racine/modele/bd.aimer.inc.php";
// récupération des données GET, POST, et SESSION
$idR = $_GET["idR"];

// appel des fonctions permettant de récupérer les données utiles a l'affichage

$mailU = getMailULoggedOn();
if ($mailU != "") {
    $aimer = getAimerById($mailU, $idR);

        // traitement si nécessaire des données récupérer
    ;
    if ($aimer == false) {
        addAimer($mailU, $idR);
    } else {
        delAimer($mailU, $idR);
    }
}

// redirection vers le ‘referer’
header('Location: ' . $_SERVER['HTTP_REFERER']);

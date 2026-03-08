<?php
include_once "$racine/modele/authentification.inc.php";
include_once "$racine/modele/bd.critiquer.inc.php";
$idR = $_GET["idR"];


$mailU = getMailULoggedOn();
$msgDelete = '';
if ($mailU != "") {
    $req = deleteCritiquesByUser($idR, $mailU);
    $msgDelete = $req
        ? "Commentaire a été supprimé avec succès."
        : "Erreur lors de la suppression d'un commentaire";
}


// Store msg in session before redirecting
$_SESSION['msgDelete'] = $msgDelete;
header('Location: ' . $_SERVER['HTTP_REFERER']);

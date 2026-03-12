<?php
include_once "$racine/modele/authentification.inc.php";
include_once "$racine/modele/bd.critiquer.inc.php";
$idR = $_GET["idR"];


$mailU = getMailULoggedOn();
$msgAdd = '';
if ($mailU != "") {
    if (!empty(trim($_POST['critiquesU']))) {
        $critiquesU = trim($_POST['critiquesU']);
        if (mb_strlen($critiquesU) > 160) {
            $msgAdd = "Le commentaire ne doit pas dépasser 160 caractères.";
        } else {
            $req = addOrUpdateCritiquer($idR, $mailU, null, $critiquesU);
            $msgAdd = $req
                ? "Commentaire ajouté avec succès."
                : "Erreur lors de l'enregistrement.";
        }
    }
} else {
    $msgAdd = "Vous devez être connecté pour ajouter un commentaire.";
}
// Store msgAdd in session before redirecting
$_SESSION['msgAdd'] = $msgAdd;
header('Location: ' . $_SERVER['HTTP_REFERER']);

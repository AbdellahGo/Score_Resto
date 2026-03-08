<?php
include_once "$racine/modele/authentification.inc.php";
include_once "$racine/modele/bd.critiquer.inc.php";
$idR = $_GET["idR"];


$mailU = getMailULoggedOn();
$msgAdd = '';
if ($mailU != "") {
    if (!empty(trim($_POST['critiquesU'])) && isset($_POST['noteU'])) {

        $critiquesU = trim($_POST['critiquesU']);
        $noteU = (int) $_POST['noteU'];

        if ($noteU < 1 || $noteU > 5) {
            $msgAdd = "Veuillez attribuer une note entre 1 et 5.";
        } else {
            $req = addCritiquesByUser($idR, $mailU, $noteU, $critiquesU);
            $msgAdd = $req
                ? "Commentaire ajouté avec succès."
                : "Erreur lors de l'enregistrement.";
            error_log(var_export($req, true));
        }
    } else {
        $msgAdd = "Veuillez saisir un commentaire et une note.";
    }
} else {
    $msgAdd = "Vous devez être connecté pour ajouter un commentaire.";
}
// Store msgAdd in session before redirecting
$_SESSION['msgAdd'] = $msgAdd;
header('Location: ' . $_SERVER['HTTP_REFERER']);

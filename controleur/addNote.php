<?php
include_once "$racine/modele/authentification.inc.php";
include_once "$racine/modele/bd.critiquer.inc.php";
$idR = $_GET["idR"];
$note = $_GET["note"];


$mailU = getMailULoggedOn();
if ($mailU != "") {
    addOrUpdateCritiquer($idR, $mailU, $note, null);
}
header('Location: ' . $_SERVER['HTTP_REFERER']);
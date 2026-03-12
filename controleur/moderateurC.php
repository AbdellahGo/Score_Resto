<?php
include_once "$racine/modele/authentification.inc.php";
include_once "$racine/modele/bd.critiquer.inc.php";

$mailU = getMailULoggedOn();
$roleU = $_SESSION['roleU'] ?? 'user';

if ($roleU !== 'moderateur') {
    header('Location: ./?action=accueil');
    exit();
}

if ($mailU !== '') {
    $critiquesEnAttente = getCritiquesEnAttente();
}


$titre = "Gerer Les Critiques en attente";
include "$racine/vue/entete.html.php";
include "$racine/vue/vueModerateurC.php";
include "$racine/vue/pied.html.php";
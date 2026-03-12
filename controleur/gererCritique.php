<?php
include_once "$racine/modele/authentification.inc.php";
include_once "$racine/modele/bd.critiquer.inc.php";

$mailU = getMailULoggedOn();
$roleU = $_SESSION['roleU'] ?? 'user';

if ($roleU !== 'moderateur') {
    header('Location: ./?action=accueil');
    exit();
}
if ($mailU !== "") {
    if (isset($_POST['idR']) && isset($_POST['mailU'])) {
        $idR = (int) $_POST['idR'];
        $mailU = $_POST['mailU'];

        if (isset($_POST['approve'])) {
            approveCritique($idR, $mailU);
        } elseif (isset($_POST['reject'])) {
            rejectCritique($idR, $mailU);
        }
    }
}

header('Location: ./?action=moderateurCritiques');
exit();
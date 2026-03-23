<?php
include_once "$racine/modele/authentification.inc.php";
include_once "$racine/modele/bd.critiquer.inc.php";

$mailU = getMailULoggedOn();
$roleU = $_SESSION['roleU'] ?? 'user';
$msg = '';
$commentEffected = array();
if ($roleU !== 'moderateur') {
    header('Location: ./?action=accueil');
    exit();
}
if ($mailU !== "") {
    if (isset($_POST['idR']) && isset($_POST['mailU'])) {
        $idR = (int) $_POST['idR'];
        $mailUComment = $_POST['mailU'];
        var_dump($mailU == $mailUComment);
        if ($mailU == $mailUComment) {
            $msg = "Vous ne pouvez pas modérer votre propre commentaire, seul l'auteur modérateur peut le modérer.";
            $commentEffected = [
                'idR' => $idR ?? null,
                'mailU' => $mailUComment ?? null
            ];

        } else {
            $commentEffected = [];
            if (isset($_POST['approve'])) {
                approveCritique($idR, $mailUComment);
            } elseif (isset($_POST['reject'])) {
                rejectCritique($idR, $mailUComment);
            }
        }
    }
}
$_SESSION['msg'] = $msg;
$_SESSION['commentEffected'] = $commentEffected;
header('Location: ./?action=moderateurCritiques');
exit();
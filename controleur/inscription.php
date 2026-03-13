<?php
include_once "$racine/modele/bd.utilisateur.inc.php";

// creation du menu burger
$menuBurger = array();
$menuBurger[] = array("url" => "./?action=connexion", "label" => "Connexion");
$menuBurger[] = array("url" => "./?action=inscription", "label" => "Inscription");


$inscrit = false;
$msg = "";
// recuperation des donnees GET, POST, et SESSION
if (!empty($_POST["mailU"]) && !empty($_POST["mdpU"]) && !empty($_POST["pseudoU"])) {
    $mailU = trim($_POST["mailU"]);
    $mdpU = trim($_POST["mdpU"]);
    $pseudoU = trim($_POST["pseudoU"]);
    if (!filter_var($mailU, FILTER_VALIDATE_EMAIL)) {
        $msg = "S'il vous plaît, mettez une adresse email valide. exemple@gamil.com";
    } elseif (getUtilisateurByMailU($mailU)) {
        $msg = "Cet e-mail existe déjà.";
    } elseif (!preg_match("/^[a-zA-Z]+$/", $pseudoU)) {
        $msg = "Le pseudo ne doit contenir que des lettres.";
    } else {
        // enregistrement des donnees
        $ret = addUtilisateur($mailU, $mdpU, $pseudoU);
        if ($ret) {
            $inscrit = true;
        } else {
            $msg = "l'utilisateur n'a pas été enregistré.";
        }
    }
} else {
    $msg = "Renseigner tous les champs...";
}


if ($inscrit) {
    // appel du script de vue qui permet de gerer l'affichage des donnees
    $titre = "Inscription confirmée";
    include "$racine/vue/entete.html.php";
    include "$racine/vue/vueConfirmationInscription.php";
    include "$racine/vue/pied.html.php";
} else {
    // appel du script de vue qui permet de gerer l'affichage des donnees
    $titre = "Inscription pb";
    include "$racine/vue/entete.html.php";
    include "$racine/vue/vueInscription.php";
    include "$racine/vue/pied.html.php";
}

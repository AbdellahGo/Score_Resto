<?php

function controleurPrincipal($action) {
    $lesActions = array();
    $lesActions["defaut"] = "listeRestos.php";
    $lesActions["liste"] = "listeRestos.php";
    $lesActions["detail"] = "detailResto.php";
    $lesActions["recherche"] = "rechercheResto.php";
    $lesActions["connexion"] = "connexion.php";
    $lesActions["deconnexion"] = "deconnexion.php";
    $lesActions["profil"] = "monProfil.php";
    $lesActions["cgu"] = "cgu.php";
    $lesActions["aimer"] = "aimer.php";
    $lesActions["inscription"] = "inscription.php";
    $lesActions["updProfil"] = "updateProfil.php";
    $lesActions["addCritiques"] = "addCritiques.php";
    $lesActions["supprimerCritique"] = "deleteComment.php";
    $lesActions["noter"] = "addNote.php";
    $lesActions["moderateurCritiques"] = "moderateurC.php";
    $lesActions["gererCritique"] = "gererCritique.php";
    $lesActions["moderateurResto"] = "moderateurR.php";
    

    if (array_key_exists($action, $lesActions)) {
        return $lesActions[$action];
    } 
    else {
        return $lesActions["defaut"];
    }
}

?>
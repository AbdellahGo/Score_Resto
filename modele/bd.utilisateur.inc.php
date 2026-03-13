<?php

include_once "bd.inc.php";

function getUtilisateurs()
{
    $resultat = array();
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("select * from utilisateur");
        $req->execute();

        $resultat = $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("DB Error: " . $e->getMessage());
        return $resultat;
    }
    return $resultat;
}
//? change pseudo
function updatePseudoByMailU($mailU, $newPseudo)
{
    try {
        $cnx = connexionPDO();

        $req = $cnx->prepare("
            UPDATE utilisateur 
            SET pseudoU = :pseudo 
            WHERE mailU = :mail
        ");

        $req->bindParam(':pseudo', $newPseudo);
        $req->bindParam(':mail', $mailU);

        $req->execute();

        return $req->rowCount();

    } catch (PDOException $e) {
        error_log("DB Error: " . $e->getMessage());
        return false;
    }
}

//? change password
function updateMdp($mailU, $newMdp)
{
    try {
        $cnx = connexionPDO();
        $mdpUCrypt = password_hash($newMdp, PASSWORD_DEFAULT);
        $req = $cnx->prepare("
            UPDATE utilisateur 
            SET mdpU = :mdp 
            WHERE mailU = :mail
        ");

        $req->bindParam(':mdp', $mdpUCrypt);
        $req->bindParam(':mail', $mailU);

        $req->execute();

        return $req->rowCount();

    } catch (PDOException $e) {
        error_log("DB Error: " . $e->getMessage());
        return false;
    }
}


function getUtilisateurByMailU($mailU)
{
    $resultat = array();
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("select * from utilisateur where mailU=:mailU");
        $req->bindValue(':mailU', $mailU, PDO::PARAM_STR);
        $req->execute();

        $resultat = $req->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("DB Error: " . $e->getMessage());
        return $resultat;
    }
    return $resultat;
}

function addUtilisateur($mailU, $mdpU, $pseudoU)
{
    $resultat = [];
    try {
        $cnx = connexionPDO();

        $mdpUCrypt = password_hash($mdpU, PASSWORD_DEFAULT);

        $req = $cnx->prepare("insert into utilisateur (mailU, mdpU, pseudoU) values(:mailU,:mdpU,:pseudoU)");
        $req->bindValue(':mailU', $mailU, PDO::PARAM_STR);
        $req->bindValue(':mdpU', $mdpUCrypt, PDO::PARAM_STR);
        $req->bindValue(':pseudoU', $pseudoU, PDO::PARAM_STR);

        $resultat = $req->execute();
    } catch (PDOException $e) {
        error_log("DB Error: " . $e->getMessage());
        return $resultat;
    }
    return $resultat;
}


if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    // prog principal de test
    header('Content-Type:text/plain');

    echo "getUtilisateurs() : \n";
    print_r(getUtilisateurs());

    echo "getUtilisateurByMailU(\"mathieu.capliez@gmail.com\") : \n";
    print_r(getUtilisateurByMailU("mathieu.capliez@gmail.com"));

    echo "addUtilisateur('mathieu.capliez3@gmail.com', 'azerty', 'mat') : \n";
    addUtilisateur("mathieu.capliez3@gmail.com", "azerty", "mat");
}

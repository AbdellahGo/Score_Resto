<?php

include_once "bd.inc.php";

function getCritiquerByIdR($idR)
{
    $resultat = array();

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("select * from critiquer where idR=:idR");
        $req->bindValue(':idR', $idR, PDO::PARAM_INT);

        $req->execute();

        $resultat = $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

function getNoteMoyenneByIdR($idR)
{

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("select avg(note) from critiquer where idR=:idR");
        $req->bindValue(':idR', $idR, PDO::PARAM_INT);

        $req->execute();

        $resultat = $req->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    if ($req->rowCount() > 0) {
        return $resultat["avg(note)"];
    } else {
        return 0;
    }
}

// ? add Critiques
function addCritiquesByUser($idR, $mailU, $note, $critique)
{

    try {
        $cnx = connexionPDO();

        $selectStmt = $cnx->prepare('SELECT idR, mailU FROM critiquer WHERE idR = :idR AND mailU = :mailU');
        $updateStmt = $cnx->prepare('UPDATE critiquer SET note = :note, commentaire = :critique WHERE idR = :idR AND mailU = :mailU');
        $addStmt    = $cnx->prepare('INSERT INTO critiquer (idR, mailU, note, commentaire) VALUES (:idR, :mailU, :note, :critique)');

        $selectStmt->bindValue(':idR',   $idR,   PDO::PARAM_INT);
        $selectStmt->bindValue(':mailU', $mailU, PDO::PARAM_STR);
        $selectStmt->execute();

        $existing = $selectStmt->fetch(PDO::FETCH_ASSOC);
        if ($existing !== false) {
            $updateStmt->bindValue(':idR',     $idR,     PDO::PARAM_INT);
            $updateStmt->bindValue(':mailU',   $mailU,   PDO::PARAM_STR);
            $updateStmt->bindValue(':note',    $note,    PDO::PARAM_INT);
            $updateStmt->bindValue(':critique', $critique, PDO::PARAM_STR);
            $updateStmt->execute();
        } else {
            $addStmt->bindValue(':idR',     $idR,     PDO::PARAM_INT);
            $addStmt->bindValue(':mailU',   $mailU,   PDO::PARAM_STR);
            $addStmt->bindValue(':note',    $note,    PDO::PARAM_INT);
            $addStmt->bindValue(':critique', $critique, PDO::PARAM_STR);
            $addStmt->execute();
        }

        return true;
    } catch (PDOException $e) {
        return false;
    }
}

//? delete comment
function deleteCritiquesByUser($idR, $mailU)
{
    try {
        $cnx = connexionPDO();
        $selectStmt = $cnx->prepare('DELETE FROM critiquer WHERE idR = :idR AND mailU = :mailU');

        $selectStmt->bindValue(':idR',   $idR,   PDO::PARAM_INT);
        $selectStmt->bindValue(':mailU', $mailU, PDO::PARAM_STR);
        $selectStmt->execute();

        return true;
    } catch (PDOException $e) {
        return false;
    }
}

if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    // prog principal de test
    header('Content-Type:text/plain');

    echo "\n getCritiquerByIdR(1) : \n";
    print_r(getCritiquerByIdR(1));

    echo "\n getNoteMoyenneByIdR(1) : \n";
    print_r(getNoteMoyenneByIdR(1));
}

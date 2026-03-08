<?php

include_once "bd.inc.php";

function getAimerById($mailU, $idR){
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("select * from aimer where mailU=:mailU and  idR=:idR");
        $req->bindValue(':idR', $idR, PDO::PARAM_INT);
        $req->bindValue(':mailU', $mailU, PDO::PARAM_STR);
        
        $req->execute();
        $resultat = $req->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

function addAimer($mailU, $idR) {
    $resultat = -1;
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("insert into aimer (mailU, idR) values(:mailU,:idR)");
        $req->bindValue(':idR', $idR, PDO::PARAM_INT);
        $req->bindValue(':mailU', $mailU, PDO::PARAM_STR);
        
        $resultat = $req->execute();
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

function delAimer($mailU, $idR) {
    $resultat = -1;
    try {
        $cnx = connexionPDO();

        $req = $cnx->prepare("delete from aimer where idR=:idR and mailU=:mailU");
        $req->bindValue(':idR', $idR, PDO::PARAM_INT);
        $req->bindValue(':mailU', $mailU, PDO::PARAM_STR);
        
        $resultat = $req->execute();
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

function updateAimer($mailU, $selectedRestos) {
    try {
        $cnx = connexionPDO();

        $insertStmt = $cnx->prepare("INSERT INTO aimer (mailU, idR) VALUES (:mailU, :idR)");
        $deleteStmt = $cnx->prepare("DELETE FROM aimer WHERE mailU = :mailU AND idR = :idR");

        $stmt = $cnx->prepare("SELECT idR FROM aimer WHERE mailU = :mailU");
        $stmt->bindValue(':mailU', $mailU, PDO::PARAM_STR);
        $stmt->execute();
        $existing = $stmt->fetchAll(PDO::FETCH_COLUMN); 

        foreach ($existing as $idRExist) {
            if (!in_array($idRExist, $selectedRestos)) {
                $deleteStmt->bindValue(':mailU', $mailU, PDO::PARAM_STR);
                $deleteStmt->bindValue(':idR', (int)$idRExist, PDO::PARAM_INT);
                $deleteStmt->execute();
            }
        }

        foreach ($selectedRestos as $idR) {
            if (!in_array($idR, $existing)) {
                $insertStmt->bindValue(':mailU', $mailU, PDO::PARAM_STR);
                $insertStmt->bindValue(':idR', (int)$idR, PDO::PARAM_INT);
                $insertStmt->execute();
            }
        }

        return true;

    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}


if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    // prog principal de test
    header('Content-Type:text/plain');

    echo "\n getAimerById(mailU, idR) : \n";
    print_r(getAimerById("mathieu.capliez@gmail.com", 1));

    echo "\n addAimer(\"mathieu.capliez@gmail.com\",1) : \n";
    print_r(addAimer("mathieu.capliez@gmail.com", 1));

    
}
?>
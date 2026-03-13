<?php

include_once "bd.inc.php";

function getTypesCuisine()
{
    $resultat = array();

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("select * from typeCuisine");
        $req->execute();

        $resultat = $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("DB Error: " . $e->getMessage());
        return $resultat;
    }
    return $resultat;
}

function getTypesCuisinePreferesByMailU($mailU)
{
    $resultat = array();

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("select typeCuisine.* from typeCuisine,preferer where typeCuisine.idTC = preferer.idTC and preferer.mailU = :mailU");
        $req->bindValue(':mailU', $mailU, PDO::PARAM_STR);
        $req->execute();

        $resultat = $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("DB Error: " . $e->getMessage());
        return $resultat;
    }
    return $resultat;
}

function getTypesCuisineNonPreferesByMailU($mailU)
{
    $resultat = array();

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("select * from typeCuisine where idTC not in (select typeCuisine.idTC from typeCuisine,preferer where typeCuisine.idTC = preferer.idTC and preferer.mailU = :mailU)");
        $req->bindValue(':mailU', $mailU, PDO::PARAM_STR);
        $req->execute();

        $resultat = $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("DB Error: " . $e->getMessage());
        return $resultat;
    }
    return $resultat;
}

function getTypesCuisineByIdR($idR)
{
    $resultat = array();

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("select typeCuisine.* from typeCuisine,proposer where typeCuisine.idTC = proposer.idTC and proposer.idR = :idR");
        $req->bindValue(':idR', $idR, PDO::PARAM_INT);
        $req->execute();

        $resultat = $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("DB Error: " . $e->getMessage());
        return $resultat;
    }
    return $resultat;
}

function updateTypeCuisinePrefere($mailU, $selectedTypes)
{
    try {
        $cnx = connexionPDO();


        $insertStmt = $cnx->prepare("INSERT INTO preferer (mailU, idTC) VALUES (:mailU, :idTC)");
        $deleteStmt = $cnx->prepare("DELETE FROM preferer WHERE mailU = :mailU AND idTC = :idTC");

        $stmt = $cnx->prepare("SELECT idTC FROM preferer WHERE mailU = :mailU");
        $stmt->bindValue(':mailU', $mailU, PDO::PARAM_STR);
        $stmt->execute();
        $existing = $stmt->fetchAll(PDO::FETCH_COLUMN);

        foreach ($existing as $idTCExist) {
            if (!in_array($idTCExist, $selectedTypes)) {
                $deleteStmt->bindValue(':mailU', $mailU, PDO::PARAM_STR);
                $deleteStmt->bindValue(':idTC', (int) $idTCExist, PDO::PARAM_INT);
                $deleteStmt->execute();
            }
        }

        foreach ($selectedTypes as $idTC) {
            if (!in_array($idTC, $existing)) {
                $insertStmt->bindValue(':mailU', $mailU, PDO::PARAM_STR);
                $insertStmt->bindValue(':idTC', (int) $idTC, PDO::PARAM_INT);
                $insertStmt->execute();
            }
        }

    } catch (PDOException $e) {
        error_log("DB Error: " . $e->getMessage());
        return false;
    }
    return true;

}

if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    // prog principal de test
    header('Content-Type:text/plain');

    echo "getTypesCuisine() : \n";
    print_r(getTypesCuisine());

    echo "getTypesCuisinePreferesByMailU(mailU) : \n";
    print_r(getTypesCuisinePreferesByMailU("test@bts.sio"));

    echo "getTypesCuisineNonPreferesByMailU(mailU) : \n";
    print_r(getTypesCuisineNonPreferesByMailU("test@bts.sio"));

    echo "getTypesCuisineByIdR(idR) : \n";
    print_r(getTypesCuisineByIdR(4));
}

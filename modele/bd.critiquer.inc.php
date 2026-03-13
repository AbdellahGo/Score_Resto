<?php

include_once "bd.inc.php";

function getCritiquerByIdR($idR)
{
    $resultat = array();

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT * FROM critiquer 
                      WHERE idR = :idR 
                      AND statut = 'approuve'");
        $req->bindValue(':idR', $idR, PDO::PARAM_INT);

        $req->execute();

        $resultat = $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("DB Error: " . $e->getMessage());
        return $resultat;
    }
    return $resultat;
}


function getNoteMoyenneByIdR($idR)
{

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT avg(note) as moyenne FROM critiquer WHERE idR = :idR AND statut = 'approuve'");
        $req->bindValue(':idR', $idR, PDO::PARAM_INT);

        $req->execute();

        $resultat = $req->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("DB Error: " . $e->getMessage());
        return 0;
    }
    if ($req->rowCount() > 0) {
        return $resultat["moyenne"];
    } else {
        return 0;
    }
}

// ? add Critiques and note or update 
function addOrUpdateCritiquer($idR, $mailU, $note = null, $critique = null)
{
    try {
        $cnx = connexionPDO();
        $stmt = $cnx->prepare('INSERT INTO critiquer (idR, mailU, note, commentaire, statut) 
                       VALUES (:idR, :mailU, :note, :critique, "en_attente")
                       ON DUPLICATE KEY UPDATE
                       note = IF(:note IS NOT NULL, :note, note),
                       commentaire = IF(:critique IS NOT NULL, :critique, commentaire),
                       statut = IF(:critique IS NOT NULL, "en_attente", statut)');

        $stmt->bindValue(':idR', $idR, PDO::PARAM_INT);
        $stmt->bindValue(':mailU', $mailU, PDO::PARAM_STR);
        $stmt->bindValue(':note', $note, PDO::PARAM_INT);
        $stmt->bindValue(':critique', $critique, PDO::PARAM_STR);
        $stmt->execute();

        return true;
    } catch (PDOException $e) {
        return false;
    }
}

// ? select all comment whit status = en_attente
function getCritiquesEnAttente()
{
    try {
        $cnx = connexionPDO();
        $stmt = $cnx->prepare('SELECT cr.*, u.pseudoU, r.nomR
                               FROM critiquer cr
                               INNER JOIN utilisateur u ON cr.mailU = u.mailU
                               INNER JOIN resto r ON cr.idR = r.idR
                               WHERE cr.statut = "en_attente"');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("DB Error: " . $e->getMessage());
        return [];
    }
}

function approveCritique($idR, $mailU)
{
    try {
        $cnx = connexionPDO();
        $stmt = $cnx->prepare('UPDATE critiquer
                               SET statut = "approuve"
                               WHERE idR = :idR
                               AND mailU = :mailU');
        $stmt->bindValue(':idR', $idR, PDO::PARAM_INT);
        $stmt->bindValue(':mailU', $mailU, PDO::PARAM_STR);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        error_log("DB Error: " . $e->getMessage());
        return false;
    }
}

function rejectCritique($idR, $mailU)
{
    try {
        $cnx = connexionPDO();
        $stmt = $cnx->prepare('UPDATE critiquer
                               SET statut = "rejete"
                               WHERE idR = :idR
                               AND mailU = :mailU');
        $stmt->bindValue(':idR', $idR, PDO::PARAM_INT);
        $stmt->bindValue(':mailU', $mailU, PDO::PARAM_STR);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        error_log("DB Error: " . $e->getMessage());
        return false;
    }
}

// ? get note
function getNoteByUser($idR, $mailU)
{
    try {
        $cnx = connexionPDO();
        $selectStmt = $cnx->prepare('SELECT note FROM critiquer 
                              WHERE idR = :idR 
                              AND mailU = :mailU
                              AND statut = "approuve"');
        $selectStmt->bindValue(':idR', $idR, PDO::PARAM_INT);
        $selectStmt->bindValue(':mailU', $mailU, PDO::PARAM_STR);
        $selectStmt->execute();
        $resultat = $selectStmt->fetch(PDO::FETCH_ASSOC);
        if ($resultat && isset($resultat["note"])) {
            return $resultat["note"];
        }
        return 0;
    } catch (PDOException $e) {
        error_log("DB Error: " . $e->getMessage());
        return 0;
    }
}

//? delete comment
function deleteCritiquesByUser($idR, $mailU)
{
    try {
        $cnx = connexionPDO();
        $selectStmt = $cnx->prepare('DELETE FROM critiquer WHERE idR = :idR AND mailU = :mailU');

        $selectStmt->bindValue(':idR', $idR, PDO::PARAM_INT);
        $selectStmt->bindValue(':mailU', $mailU, PDO::PARAM_STR);
        $selectStmt->execute();

        return true;
    } catch (PDOException $e) {
        error_log("DB Error: " . $e->getMessage());
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

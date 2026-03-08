<?php

include_once "bd.inc.php";

function getRestoByIdR($idR)
{

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("select * from resto where idR=:idR");
        $req->bindValue(':idR', $idR, PDO::PARAM_INT);

        $req->execute();

        $resultat = $req->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}


function getRestos()
{
    $resultat = array();

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("select * from resto");
        $req->execute();

        $resultat = $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

function getTop4Resto()
{
    $resultat = array();

    try {
        $cnx = connexionPDO();
$req = $cnx->prepare("SELECT re.*, AVG(cr.note) as noteF
                      FROM resto re, critiquer cr
                      WHERE re.idR = cr.idR
                      GROUP BY re.idR
                      ORDER BY noteF DESC
                      LIMIT 4");
        $req->execute();

        $resultat = $req->fetchAll(PDO::FETCH_ASSOC);   
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

function getRestosByNomR($nomR)
{
    $resultat = array();

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("select * from resto where lower(nomR) like lower(:nomR)");
        $req->bindValue(':nomR', "%" . $nomR . "%", PDO::PARAM_STR);

        $req->execute();

        $resultat = $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

function getRestosByAdresse($voieAdrR, $cpR, $villeR)
{
    $resultat = array();

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("select * from resto where voieAdrR like :voieAdrR and cpR like :cpR and villeR like :villeR");
        $req->bindValue(':voieAdrR', "%" . $voieAdrR . "%", PDO::PARAM_STR);
        $req->bindValue(':cpR', $cpR . "%", PDO::PARAM_STR);
        $req->bindValue(':villeR', "%" . $villeR . "%", PDO::PARAM_STR);
        $req->execute();

        // $resultat = $req->fetchAll(PDO::FETCH_ASSOC);
        return $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

function getRestosAimesByMailU($mailU)
{
    $resultat = array();

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("select resto.* from resto,aimer where resto.idR = aimer.idR and mailU = :mailU");
        $req->bindValue(':mailU', $mailU, PDO::PARAM_STR);
        $req->execute();

        $resultat = $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

//? git all resto by id type cuisine
function getRestosByIdtc($idTC)
{

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("select re.* 
                                    from resto re, proposer pr 
                                    where re.idR = pr.idR 
                                    and pr.idTC = :idTC");
        $req->bindValue(':idTC', $idTC, PDO::PARAM_INT);
        $req->execute();

        return $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("DB Error: " . $e->getMessage());
        return [];
    }
}

//? git all resto by id type cuisine
function getRestosByRAvancee($idTC, $voieAdrR, $cpR, $villeR)
{

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("select re.* 
                                    from resto re, proposer pr 
                                    where re.idR = pr.idR 
                                    and pr.idTC = :idTC
                                    AND LOWER(re.voieAdrR) LIKE LOWER(:voieAdrR)
                                    AND LOWER(re.cpR) LIKE LOWER(:cpR)
                                    AND LOWER(re.villeR) LIKE LOWER(:villeR)");

        $req->bindValue(':idTC', $idTC, PDO::PARAM_INT);
        $req->bindValue(':voieAdrR', "%" . $voieAdrR . "%", PDO::PARAM_STR);
        $req->bindValue(':cpR', $cpR . "%", PDO::PARAM_STR);
        $req->bindValue(':villeR', "%" . $villeR . "%", PDO::PARAM_STR);
        $req->execute();

        return $req->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("DB Error: " . $e->getMessage());
        return [];
    }
}

if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    // prog principal de test
    header('Content-Type:text/plain');

    echo "getRestos() : \n";
    print_r(getRestos());

    echo "getRestoByIdR(1) : \n";
    print_r(getRestoByIdR(1));

    echo "getRestosByNomR('charcut') : \n";
    print_r(getRestosByNomR("charcut"));

    echo "getRestosByAdresse(voieAdrR, cpR, villeR) : \n";
    print_r(getRestosByAdresse("Ravel", "33000", "Bordeaux"));

    echo "getRestosAimesByMailU(mailU) : \n";
    print_r(getRestosAimesByMailU("test@bts.sio"));
}
?>
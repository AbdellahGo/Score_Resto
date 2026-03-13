<?php

function connexionPDO()
{
    $login = "root";
    $mdp = "";
    $bd = "bd_resto_view";
    $serveur = "localhost";

    try {
        $conn = new PDO("mysql:host=$serveur;dbname=$bd;charset=UTF8", $login, $mdp);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        error_log("DB Error: " . $e->getMessage());
        return false;
    }
}

if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    // prog de test
    header('Content-Type:text/plain');

    echo "connexionPDO() : \n";
    print_r(connexionPDO());
}
?>
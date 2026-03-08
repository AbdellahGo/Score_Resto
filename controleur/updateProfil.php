<?php
include_once "$racine/modele/authentification.inc.php";
include_once "$racine/modele/bd.utilisateur.inc.php";
include_once "$racine/modele/bd.aimer.inc.php";
include_once "$racine/modele/bd.typecuisine.inc.php";
include_once "$racine/modele/bd.resto.inc.php";

$menuBurger = array();
$menuBurger[] = array("url" => "./?action=profil", "label" => "Consulter mon profil");
$menuBurger[] = array("url" => "./?action=updProfil", "label" => "Modifier mon profil");



if (isLoggedOn()) {
    $mailU = getMailULoggedOn();
    $util = getUtilisateurByMailU($mailU);

    $mesRestosAimes = getRestosAimesByMailU($mailU);
    $mesTypeCuisineAimes = getTypesCuisinePreferesByMailU($mailU);

    $msgPseudo = "";
    $msgMdp = "";
    $msgCuisines = "";
    $msgRestos = "";
    $restos = getRestos();
    $typeCuisine = getTypesCuisine();


    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        // Modifier pseudo
        if (isset($_POST['submitPseudo'])) {
            if (!empty($_POST["pseudoU"])) {
                $pseudoU = $_POST["pseudoU"];
                if (preg_match("/^[a-zA-Z]+$/", $pseudoU)) {
                    updatePseudoByMailU($mailU, $pseudoU);
                    $msgPseudo = "Pseudo mis à jour avec succès.";
                } else {
                    $msgPseudo = "Le pseudo ne doit contenir que des lettres.";
                }
            } else {
                $msgPseudo = "Aucune saisie n'a été effectuée.";
            }
        }

        // Modifier mot de passe
        if (isset($_POST['submitMdp'])) {
            if (!empty($_POST["ancienMdp"]) && !empty($_POST["newMdp"]) && !empty($_POST["confiMdp"])) {
                $ancienMdp = $_POST["ancienMdp"];
                $newMdpU = $_POST["newMdp"];
                $confiMdp = $_POST["confiMdp"];
                if (password_verify($ancienMdp, $util["mdpU"])) {
                    if ($newMdpU === $confiMdp) {
                        if (password_verify($newMdpU, $util["mdpU"])) {
                            $msgMdp = "Le nouveau mot de passe doit être différent de l'ancien.";
                        } else {
                            $ret = updateMdp($mailU, $newMdpU);
                            if ($ret) {
                                $msgMdp = "Mot de passe modifié avec succès !";
                                header("refrech:2, url: /");
                                logout();
                                session_destroy();
                                header("Location: ./?action=connexion");
                                exit;
                            } else {
                                $msgMdp = "Erreur lors de la modification du mot de passe.";
                            }
                        }
                    } else {
                        $msgMdp = "Le nouveau mot de passe ne correspond pas à la confirmation.";
                    }
                } else {
                    $msgMdp = "L'ancien mot de passe est incorrect.";
                }
            } else {
                $msgMdp = "Veuillez remplir tous les champs.";
            }
        }

        // Modifier types de cuisines
        if (isset($_POST['submitCuisines'])) {
            $selectedCuisines = $_POST["typeCuisine"] ?? [];
            $ret = updateTypeCuisinePrefere($mailU, $selectedCuisines);

            if ($ret) {
                $msgCuisines = "Vos choix ont été modifiés avec succès !";

                $mesTypeCuisineAimes = getTypesCuisinePreferesByMailU($mailU);
            } else {
                $msgCuisines = "Erreur lors de l'enregistrement.";
            }
        }

        // Modifier restaurants
        if (isset($_POST['submitRestos'])) {
            $selectedRestos = $_POST["restos"] ?? [];
            $ret = updateAimer($mailU, $selectedRestos);

            if ($ret) {
                $msgRestos = "Vos restaurants préférés ont été modifiés avec succès !";

                $mesRestosAimes = getRestosAimesByMailU($mailU);
            } else {
                $msgRestos = "Erreur lors de l'enregistrement.";
            }
        }
    }







    $titre = "Update profil";
    include "$racine/vue/entete.html.php";
    include "$racine/vue/vueUpdateProfil.php";
    include "$racine/vue/pied.html.php";
} else {
    $titre = "Update profil";
    include "$racine/vue/entete.html.php";
    include "$racine/vue/pied.html.php";
}

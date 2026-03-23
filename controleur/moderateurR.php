<?php
include_once "$racine/modele/authentification.inc.php";
include_once "$racine/modele/bd.resto.inc.php";
include_once "$racine/modele/bd.typeCuisine.inc.php";
include_once "$racine/modele/bd.photo.inc.php";
$mailU = getMailULoggedOn();
$listTypesCuisine = getTypesCuisine();
$roleU = $_SESSION['roleU'] ?? 'user';

if ($roleU !== 'moderateur') {
    header('Location: ./?action=accueil');
    exit();
}

$msg = '';
if ($mailU !== '') {
    if (
        !empty($_POST["nomR"]) &&
        !empty($_POST["numAdrR"]) &&
        !empty($_POST["voieAdrR"]) &&
        !empty($_POST["cpR"]) &&
        !empty($_POST["villeR"]) &&
        !empty($_POST["descR"]) &&
        !empty($_POST["latitudeDegR"]) &&
        !empty($_POST["longitudeDegR"]) &&
        !empty($_POST["horaires"]) &&
        !empty($_POST["typesCuisine"])
    ) {
 
        $nomR = isset($_POST["nomR"]) ? htmlspecialchars(trim($_POST["nomR"]), ENT_QUOTES, 'UTF-8') : '';
        $numAdrR = isset($_POST["numAdrR"]) ? htmlspecialchars(trim($_POST["numAdrR"]), ENT_QUOTES, 'UTF-8') : '';
        $voieAdrR = isset($_POST["voieAdrR"]) ? htmlspecialchars(trim($_POST["voieAdrR"]), ENT_QUOTES, 'UTF-8') : '';
        $cpR = isset($_POST["cpR"]) ? htmlspecialchars(trim($_POST["cpR"]), ENT_QUOTES, 'UTF-8') : '';
        $villeR = isset($_POST["villeR"]) ? htmlspecialchars(trim($_POST["villeR"]), ENT_QUOTES, 'UTF-8') : '';
        $descR = isset($_POST["descR"]) ? htmlspecialchars(trim($_POST["descR"]), ENT_QUOTES, 'UTF-8') : '';
        $latitudeDegR = (float) $_POST["latitudeDegR"];
        $longitudeDegR = (float) $_POST["longitudeDegR"];
        $listIdTC = array_map('intval', $_POST["typesCuisine"]);

        $h = $_POST["horaires"];
        $rows = [
            'Midi' => ['midi_semaine', 'midi_weekend'],
            'Soir' => ['soir_semaine', 'soir_weekend'],
            'À emporter' => ['emporter_semaine', 'emporter_weekend'],
        ];

        $tbody = '';
        foreach ($rows as $label => $keys) {
            $debut1 = $h[$keys[0]]['debut'];
            $fin1 = $h[$keys[0]]['fin'];
            $debut2 = $h[$keys[1]]['debut'];
            $fin2 = $h[$keys[1]]['fin'];
            $tbody .= "
                <tr>
                    <td class='label'>{$label}</td>
                    <td class='cell'>de {$debut1} à {$fin1}</td>
                    <td class='cell'>de {$debut2} à {$fin2}</td>
                </tr>";
        }

        $horairesR = "
        <table>
            <thead>
                <tr>
                    <th>Ouverture</th>
                    <th>Semaine</th>
                    <th>Week-end</th>
                </tr>
            </thead>
            <tbody>{$tbody}</tbody>
        </table>";

        $newIdR = addResto($nomR, $numAdrR, $voieAdrR, $cpR, $villeR, $descR, $horairesR, $latitudeDegR, $longitudeDegR);
        if ($newIdR) {
            // add types cuisine
            addProposer($newIdR, $listIdTC);

            // handle photos upload
            if (!empty($_FILES["photos"]["name"][0])) {
                $uploadDir = dirname(__DIR__) . "/photos/";
                ;
                foreach ($_FILES["photos"]["tmp_name"] as $key => $tmpName) {
                    if ($_FILES["photos"]["error"][$key] === 0) {
                        $extension = pathinfo($_FILES["photos"]["name"][$key], PATHINFO_EXTENSION);
                        $filename = uniqid('resto_') . '.' . $extension;

                        $moved = move_uploaded_file($tmpName, $uploadDir . $filename);

                        if ($moved) {
                            addPhoto($filename, $newIdR);
                        } else {
                            $msg = "Erreur lors de l'upload de la photo.";
                        }
                    }
                }
            }

            $msg = "Restaurant ajouté avec succès.";
        } else {
            $msg = "Erreur lors de l'ajout du restaurant.";
        }
    } elseif (!empty($_POST)) {
        $msg = "Veuillez remplir tous les champs.";
    }
}

$titre = "Ajouter un restaurant";
include "$racine/vue/entete.html.php";
include "$racine/vue/vueModerateurR.php";
include "$racine/vue/pied.html.php";
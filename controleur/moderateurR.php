<?php
include_once "$racine/modele/authentification.inc.php";
include_once "$racine/modele/bd.resto.inc.php";
include_once "$racine/modele/bd.typeCuisine.inc.php";

$mailU = getMailULoggedOn();
$listTypesCuisine = getTypesCuisine();
$roleU = $_SESSION['roleU'] ?? 'user';

if ($roleU !== 'moderateur') {
    header('Location: ./?action=accueil');
    exit();
}

$msg = '';
$listTypesCuisine = getTypesCuisine();

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
        $nomR = trim($_POST["nomR"]);
        $numAdrR = trim($_POST["numAdrR"]);
        $voieAdrR = trim($_POST["voieAdrR"]);
        $cpR = trim($_POST["cpR"]);
        $villeR = trim($_POST["villeR"]);
        $descR = trim($_POST["descR"]);
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
            $tbody .= "
                <tr>
                    <td class='label'>{$label}</td>
                    <td class='cell'>{$h[$keys[0]]}</td>
                    <td class='cell'>{$h[$keys[1]]}</td>
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
            <tbody>
                {$tbody}
            </tbody>
        </table>";

        $newIdR = addResto($nomR, $numAdrR, $voieAdrR, $cpR, $villeR, $descR, $horairesR, $latitudeDegR, $longitudeDegR);
        if ($newIdR) {
            $req = addProposer($newIdR, $listIdTC);
            $msg = $req ? "Restaurant ajouté avec succès." : "Erreur lors de l'ajout des types de cuisine.";
        } else {
            $msg = "Erreur lors de l'ajout du restaurant.";
        }
    } else {
        $msg = "Veuillez remplir tous les champs.";
    }
}

$titre = "Ajouter un restaurant";
include "$racine/vue/entete.html.php";
include "$racine/vue/vueModerateurR.php";
include "$racine/vue/pied.html.php";
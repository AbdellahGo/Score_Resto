<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$msgAdd = $_SESSION['msgAdd'] ?? '';
$msgDelete = $_SESSION['msgDelete'] ?? '';

// Clear it so it doesn't show again on refresh
unset($_SESSION['msgAdd'], $_SESSION['msgDelete']);
?>

<h1><?= $unResto['nomR']; ?>

    <?php if ($aimer != false) { ?>
        <a href="./?action=aimer&idR=<?= $unResto['idR']; ?>"><img class="aimer" src="images/aime.png" alt="j'aime ce restaurant"></a>
    <?php } else { ?>
        <a href="./?action=aimer&idR=<?= $unResto['idR']; ?>"><img class="aimer" src="images/aimepas.png" alt="je n'aime pas encore ce restaurant"></a>
    <?php } ?>

</h1>

<span id="note">
    <?php for ($i = 1; $i <= 5; $i++) { ?>
        <a class="aimer" href="./?action=noter&note=<?= $i ?>&idR=<?= $unResto['idR']; ?>">
            <?php if ($i <= $noteMoy) { ?>
                <img class="note" src="images/like.png" alt="">
            <?php } else {
            ?>
                <img class="note" src="images/neutre.png" alt="line neutre">
            <?php } ?>
        </a>
    <?php } ?>
</span>
<section>
    Cuisine <br />
    <ul id="tagFood">
        <?php for ($j = 0; $j < count($lesTypesCuisine); $j++) { ?>
            <li class="tag"><span class="tag">#</span><?= $lesTypesCuisine[$j]["libelleTC"] ?></li>
        <?php } ?>
    </ul>

</section>
<p id="principal">
    <?php if (count($lesPhotos) > 0) { ?>
        <img src="photos/<?= $lesPhotos[0]["cheminP"] ?>" alt="photo du restaurant" />
    <?php } ?>
    <br />
    <?= $unResto['descR']; ?>
</p>
<h2 id="adresse">
    Adresse
</h2>
<p>
    <?= $unResto['numAdrR']; ?>
    <?= $unResto['voieAdrR']; ?><br />
    <?= $unResto['cpR']; ?>
    <?= $unResto['villeR']; ?>

</p>

<h2 id="photos">
    Photos
</h2>
<ul id="galerie">
    <?php for ($i = 0; $i < count($lesPhotos); $i++) { ?>
        <li> <img class="galerie" src="photos/<?= $lesPhotos[$i]["cheminP"] ?>" alt="" /></li>
    <?php } ?>

</ul>

<h2 id="horaires">
    Horaires
</h2>
<?= $unResto['horairesR']; ?>


<h2 id="crit">Critiques</h2>

<ul id="critiques">
    <span style="font-weight: bold; color: #888;"><?= $msgDelete ?></span>
    <?php for ($i = 0; $i < count($critiques); $i++) { ?>
        <li>
            <span>
                <?= $critiques[$i]["mailU"] ?>
                <?php if ($critiques[$i]["mailU"] == $mailU) { ?>
                    <a href='./?action=supprimerCritique&idR=<?= $unResto['idR']; ?>'>Supprimer</a>
                <?php } ?>
            </span>
            <div>
                <span>
                    <?php
                    if ($critiques[$i]["note"]) {
                        echo $critiques[$i]["note"] . "/5";
                    }
                    ?>
                </span>
                <span><?= $critiques[$i]["commentaire"] ?> </span>
            </div>

        </li>
    <?php } ?>

</ul>

<form action="./?action=addCritiques&idR=<?= $unResto['idR']; ?>" method="post">
    <div style="display: flex; flex-direction: column; gap: 8px;">
        <span style="font-weight: bold; color: #888;"><?= $msgAdd ?></span>
        <label style="font-size: 18px; font-weight: bold;" for="note">
            Ajouter un note
        </label>
        <input style="margin: 0; width: 400px; padding: 5px;" type="number" name="noteU" id="noteU" placeholder="Entrez votre note">
        <label style="font-size: 18px; font-weight: bold;" for="pseudonyme">
            Ajouter un critiques
        </label>
        <input style="margin: 0;" type="text" name="critiquesU" id="critiquesU" placeholder="Entrez votre Critiques">
        <input style="margin: 5px 0 0; width: fit-content;" type="submit" value="enregistré">
    </div>
</form>
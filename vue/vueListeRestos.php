<div style="display: flex; justify-content: center; flex-direction: column; align-items: center; height: 200px;">
    <h1 style="background: none; font-size: 40px;">Bienvenue</h1>
    <p style="font-size: 20px; color: #888;">Vous trouverez ici les quatre meilleurs restaurants</p>
</div>
<h1>Top 4 restaurants</h1>
<?php
for ($i = 0; $i < count($listeRestos); $i++) {

    $lesPhotos = getPhotosByIdR($listeRestos[$i]['idR']);
    ?>

    <div class="card">
        <div class="photoCard">
            <?php if (count($lesPhotos) > 0) { ?>
                <img src="photos/<?= $lesPhotos[0]["cheminP"] ?>" alt="photo du restaurant" />
            <?php } ?>


        </div>
        <div class="descrCard"><?php echo "<a href='./?action=detail&idR=" . $listeRestos[$i]['idR'] . "'>" . $listeRestos[$i]['nomR'] . "</a>"; ?>
            <br />
            <?= $listeRestos[$i]["numAdrR"] ?>
            <?= $listeRestos[$i]["voieAdrR"] ?>
            <br />
            <?= $listeRestos[$i]["cpR"] ?>
            <?= $listeRestos[$i]["villeR"] ?>
        </div>
        <div class="tagCard">
            <ul id="tagFood">		


            </ul>


        </div>

    </div>





    <?php
}
?>



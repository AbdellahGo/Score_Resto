<h1>Recherche d'un restaurant</h1>
<form action="./?action=recherche&critere=<?php echo $critere ?>" method="POST">


    <?php
    switch ($critere) {
        case "nom":
            ?>
            Recherche par nom : <br />
            <input type="text" name="nomR" placeholder="nom" value="<?php echo $nomR ?>" /><br />
            <?php
            break;
        case "adresse":
            ?>
            Recherche par adresse : <br />
            <input type="text" name="villeR" placeholder="ville" value="<?php echo $villeR ?>" /><br />
            <input type="text" name="cpR" placeholder="code postal" value="<?php echo $cpR ?>" /><br />
            <input type="text" name="voieAdrR" placeholder="rue" value="<?php echo $voieAdrR ?>" /><br />
            <?php
            break;
        case "typecuisine":
            ?>
            Recherche par typecuisine : <br />
            <div>
                <?php foreach ($listTypesCuisine as $tc): ?>
                    <input type="checkbox" name="typesCuisine[]" value="<?= $tc['idTC'] ?>" id="tc_<?= $tc['idTC'] ?>">
                    <label for="<?= $tc['idTC'] ?>"><?= $tc['libelleTC'] ?></label>
                <?php endforeach; ?>
            </div>
            <?php
            break;
        case "rechercheavancee":
            ?>
            Recherche par adresse et typecuisine : <br />
            <input type="text" name="villeR" placeholder="ville" value="<?php echo $villeR ?>" />
            <br />
            <input type="text" name="cpR" placeholder="code postal" value="<?php echo $cpR ?>" />
            <br />
            <input type="text" name="voieAdrR" placeholder="rue" value="<?php echo $voieAdrR ?>" />
            <br />
            <br />
            <div>
                <?php foreach ($listTypesCuisine as $tc): ?>
                    <input type="checkbox" name="typesCuisine[]" value="<?= $tc['idTC'] ?>" id="tc_<?= $tc['idTC'] ?>">
                    <label for="tc_<?= $tc['idTC'] ?>"><?= $tc['libelleTC'] ?></label>
                <?php endforeach; ?>
            </div>
            <?php
            break;
    }
    ?>
    <br />
    <input type="submit" value="Rechercher" />

</form>
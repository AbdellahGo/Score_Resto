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
            //? not needed START ---------------------
            // case "adresse":
            //     ?>
            // Recherche par adresse : <br />
            // <input type="text" name="villeR" placeholder="ville" value="<?php echo $villeR ?>" /><br />
            // <input type="text" name="cpR" placeholder="code postal" value="<?php echo $cpR ?>" /><br />
            // <input type="text" name="voieAdrR" placeholder="rue" value="<?php echo $voieAdrR ?>" /><br />
            // <?php
            //     break;
            // case "typecuisine":
            //     ?>
            // Recherche par typecuisine : <br />
            // <select name="idTC" id="idTC">
                // <?php foreach ($listTypesCuisine as $tc): ?>
                    // <option value="<?php echo $tc['idTC'] ?>"><?php echo $tc['libelleTC'] ?></option>
                    // <?php endforeach; ?>
                // </select>
            // <?php
        //     break;
        //? not needed END ---------------------
        case "rechercheavancee":
            ?>
            Recherche par adresse : <br />
            <input type="text" name="villeR" placeholder="ville" value="<?php echo $villeR ?>" />
            <br />
            <input type="text" name="cpR" placeholder="code postal" value="<?php echo $cpR ?>" />
            <br />
            <input type="text" name="voieAdrR" placeholder="rue" value="<?php echo $voieAdrR ?>" />
            <br />
            Recherche par typecuisine : <br />
            <select name="idTC" id="idTC">
                <option value="0">-- Sélectionnez un type de cuisine --</option>
                <?php foreach ($listTypesCuisine as $tc): ?>
                    <option value="<?php echo $tc['idTC'] ?>"><?php echo $tc['libelleTC'] ?></option>
                <?php endforeach; ?>
            </select>
            <?php
            break;
    }
    ?>
    <br /><br />
    <input type="submit" value="Rechercher" />

</form>
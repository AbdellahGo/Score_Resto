<h1>Modifier vous profil</h1>
<form action="./?action=updProfil" method="POST">
    <!--  modifier pseudo  -->
    <div style="display: flex; flex-direction: column; gap: 8px;">
        <label style="font-size: 18px; font-weight: bold;" for="pseudonyme">modifier pseudonyme:</label>
        <?php if ($msgPseudo) : ?>
            <span style="font-weight: bold; color: #888;"><?= $msgPseudo ?></span>
        <?php endif; ?>
        <input style="margin: 0;" type="text" name="pseudoU" id="pseudonyme" placeholder="Nouveau pseudonyme">
        <input style="width: fit-content; margin: 0;" type="submit" name="submitPseudo" value="enregistré">
    </div>
    <!--  modifier mot de pass  -->
    <div style="display: flex; flex-direction: column; gap: 8px;">
        <h2 style="margin-bottom: 10px; font-size: 25px; padding: 8;">modifier mot de passe</h2>
        <?php if ($msgMdp) : ?>
            <span style="font-weight: bold; color: #888;"><?= $msgMdp ?></span>
        <?php endif; ?>
        <label style="font-size: 18px; font-weight: bold;" for="ancienMdp">Saisir l'ancien mot de passe:</label>
        <input style="margin: 0;" type="text" name="ancienMdp" id="ancienMdp" placeholder="l'ancien mot de passe">

        <label style="font-size: 18px; font-weight: bold;" for="nouveauMdp">Saisir nouveau mot de passe:</label>
        <input style="margin: 0;" type="text" name="newMdp" id="nouveauMdp" placeholder="Nouveau mot de pass">

        <label style="font-size: 18px; font-weight: bold;" for="confiMdp">Confirmez le mot de passe:</label>
        <input style="margin: 0;" type="text" name="confiMdp" id="confiMdp" placeholder="Confirmez le mot de passe">
        <input style="width: fit-content; margin: 0;" type="submit" name="submitMdp" value="enregistré">
    </div>

    <!--  modifier types de cuisines préférés -->
    <div>
        <h2 style="margin-bottom: 10px; font-size: 25px; padding: 8;">modifier types de cuisines préférés</h2>
        <?php if ($msgCuisines) : ?>
            <span style="font-weight: bold; color: #888;"><?= $msgCuisines ?></span>
        <?php endif; ?>
            <ul style="padding: 0;">
                <?php foreach ($typeCuisine as $tc):
                    $checked = false;
                    foreach ($mesTypeCuisineAimes as $pref) {
                        if ($pref['idTC'] == $tc['idTC']) {
                            $checked = true;
                            break;
                        }
                    }
                ?>
                    <input
                        type="checkbox"
                        name="typeCuisine[]"
                        value="<?= $tc['idTC'] ?>"
                        id="tc_<?= $tc['idTC'] ?>"
                        <?= $checked ? 'checked' : '' ?>>
                    <label for="tc_<?= $tc['idTC'] ?>"><?= htmlspecialchars($tc['libelleTC']) ?></label>
                <?php endforeach; ?>
            </ul>
        <input style="width: fit-content; margin: 0;" type="submit" name="submitCuisines" value="enregistré">
    </div>

    <!--  modifier les restaurants aimés-->
    <div>
        <h2 style="margin-bottom: 10px; font-size: 25px; padding: 8;">modifier les restaurants aimer</h2>
        <?php if ($msgRestos) : ?>
            <span style="font-weight: bold; color: #888;"><?= $msgRestos ?></span>
        <?php endif; ?>
        <ul style="padding: 0;">
            <ul style="padding: 0;">
                <ul style="padding: 0;">
                    <?php foreach ($restos as $resto):
                        $checked = false;
                        foreach ($mesRestosAimes as $aime) {
                            if ($aime['idR'] == $resto['idR']) {
                                $checked = true;
                                break;
                            }
                        }
                    ?>
                        <input
                            type="checkbox"
                            name="restos[]"
                            value="<?= $resto['idR'] ?>"
                            id="r_<?= $resto['idR'] ?>"
                            <?= $checked ? 'checked' : '' ?>>
                        <label for="r_<?= $resto['idR'] ?>"><?= htmlspecialchars($resto['nomR']) ?></label>
                    <?php endforeach; ?>
                </ul>
            </ul>
        </ul>
        <input style="width: fit-content; margin: 0;" type="submit" name="submitRestos" value="enregistré">
    </div>
</form>
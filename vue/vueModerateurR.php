<h1>Ajouter un restaurant</h1>

<?php if (!empty($msg)): ?>
    <span style="color: green;"><?= $msg ?></span>
<?php endif; ?>

<form action="./?action=moderateurResto" method="post" enctype="multipart/form-data">
    <?php
    $fields = [
        'nomR' => ['label' => 'Nom du restaurant', 'type' => 'text'],
        'numAdrR' => ['label' => 'Numéro de rue', 'type' => 'text'],
        'voieAdrR' => ['label' => 'Rue', 'type' => 'text'],
        'cpR' => ['label' => 'Code postal', 'type' => 'text'],
        'villeR' => ['label' => 'Ville', 'type' => 'text'],
        'descR' => ['label' => 'Description', 'type' => 'textarea'],
        'latitudeDegR' => ['label' => 'Latitude', 'type' => 'text'],
        'longitudeDegR' => ['label' => 'Longitude', 'type' => 'text'],
    ];

    foreach ($fields as $name => $field): ?>
        <label><?= $field['label'] ?></label>
        <?php if ($field['type'] === 'textarea'): ?>
            <textarea name="<?= $name ?>" required></textarea>
        <?php else: ?>
            <input type="<?= $field['type'] ?>" name="<?= $name ?>" required>
        <?php endif; ?>
        <br>
    <?php endforeach; ?>

    <hr>
    <h3>Types Cuisine</h3>
    <div>
        <?php foreach ($listTypesCuisine as $tc): ?>
            <input type="checkbox" name="typesCuisine[]" value="<?= $tc['idTC'] ?>" id="tc_<?= $tc['idTC'] ?>">
            <label for="tc_<?= $tc['idTC'] ?>"><?= $tc['libelleTC'] ?></label>
        <?php endforeach; ?>
    </div>

    <hr>
    <h3>Photos</h3>
    <input type="file" name="photos[]" accept="image/*" multiple>
    <br>

    <hr>
    <h3>Horaires</h3>

    <?php
    $horaires = [
        'midi_semaine' => 'Midi - Semaine',
        'midi_weekend' => 'Midi - Week-end',
        'soir_semaine' => 'Soir - Semaine',
        'soir_weekend' => 'Soir - Week-end',
        'emporter_semaine' => 'À emporter - Semaine',
        'emporter_weekend' => 'À emporter - Week-end',
    ];
    foreach ($horaires as $key => $label): ?>
        <label><?= $label ?></label>
        <input type="time" name="horaires[<?= $key ?>][debut]" requiredd>
        à
        <input type="time" name="horaires[<?= $key ?>][fin]" required>
        <br>
    <?php endforeach; ?>



    <input type="submit" value="Ajouter le restaurant">
</form>
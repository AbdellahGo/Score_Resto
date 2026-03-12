

<h1>Mon profil</h1>

Mon adresse électronique : <?= $util["mailU"] ?> <br />
Mon pseudo : <?= $util["pseudoU"] ?> <br />

<hr>

les restaurants que j'aime : <br />
<?php for ($i = 0; $i < count($mesRestosAimes); $i++) { ?>
    <a href="./?action=detail&idR=<?= $mesRestosAimes[$i]["idR"] ?>"><?= $mesRestosAimes[$i]["nomR"] ?></a><br />
<?php } ?>
<hr>
les types de cuisine que j'aime :
<ul id="tagFood">
    <?php for ($i = 0; $i < count($mesTypeCuisineAimes); $i++) { ?>
        <li class="tag"><span class="tag">#</span><?= $mesTypeCuisineAimes[$i]["libelleTC"] ?></li>
    <?php } ?>
</ul>
<hr>

<?php if (($_SESSION['roleU'] ?? 'user') === 'moderateur'): ?>
    <div style="display: flex; gap: 10px; margin-bottom: 10px;">
        <a href="./?action=moderateurCritiques">Gerer Les Critique</a>
        <a href="./?action=moderateurResto">Ajouter des restaurant</a>
    </div>
<?php endif; ?>
<a href="./?action=deconnexion">se deconnecter</a>
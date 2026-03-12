<h1>Critiques en attente</h1>

<?php if (!empty($msg)): ?>
    <span><?= $msg ?></span>
<?php endif; ?>

<?php if (empty($critiquesEnAttente)): ?>
    <p>Aucune critique en attente.</p>
<?php else: ?>
    <?php foreach ($critiquesEnAttente as $critique): ?>
        <div style="border: 1px solid #ccc; padding: 16px; margin: 10px 0;">
            <p><strong>Restaurant:</strong> <?= $critique['nomR'] ?></p>
            <p><strong>Utilisateur:</strong> <?= $critique['pseudoU'] ?></p>
            <p><strong>Note:</strong> <?= $critique['note'] ?? 'Aucune note' ?></p>
            <p><strong>Commentaire:</strong> <?= $critique['commentaire'] ?? 'Aucun commentaire' ?></p>

            <form action="./?action=gererCritique" method="post">
                <input type="hidden" name="idR" value="<?= $critique['idR'] ?>">
                <input type="hidden" name="mailU" value="<?= $critique['mailU'] ?>">
                <button type="submit" name="approve" value="1">✅ Approuver</button>
                <button type="submit" name="reject" value="1">❌ Rejeter</button>
            </form>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

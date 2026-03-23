<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$msg = $_SESSION['msg'] ?? '';
$commentEffected = $_SESSION['commentEffected'] ?? '';
// Clear it so it doesn't show again on refresh
unset($_SESSION['msg'], $_SESSION['commentEffected']);
?>
<?php if (empty($critiquesEnAttente)): ?>
    <p>Aucune critique en attente.</p>
<?php else: ?>
    <?php foreach ($critiquesEnAttente as $critique): ?>
        <div style="border: 1px solid #ccc; padding: 16px; margin: 10px 0;">
            <?php if (
                !empty($commentEffected['idR']) && !empty($commentEffected['mailU'])
                && $commentEffected['idR'] == $critique['idR']
                && $commentEffected['mailU'] == $critique['mailU']
            ): ?>
                <span style="font-weight: bold; color: #888;"><?= $msg ?></span>
            <?php endif; ?>

            <p><strong>Restaurant:</strong> <?= $critique['nomR'] ?></p>
            <p><strong>Utilisateur:</strong> <?= $critique['pseudoU'] ?></p>
            <p><strong>Commentaire:</strong> <?= htmlspecialchars($critique['commentaire']) ?? 'Aucun commentaire' ?></p>

            <form action="./?action=gererCritique" method="post">
                <input type="hidden" name="idR" value="<?= $critique['idR'] ?>">
                <input type="hidden" name="mailU" value="<?= $critique['mailU'] ?>">
                <button type="submit" name="approve" value="1">✅ Approuver</button>
                <button type="submit" name="reject" value="1">❌ Rejeter</button>
            </form>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
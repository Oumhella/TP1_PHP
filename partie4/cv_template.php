<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="cv_template.css">
</head>
<body>
<a href="?" class="back-btn">← Retour à la liste</a>


<div class="cv-container">
    <table class="top-row">
        <tr>
            <td class="photo">
                <?php if (!empty($base64)): ?>
                    <img src="data:image/jpeg;base64,<?= $base64 ?>" alt="Photo">
                <?php else: ?>
                    <div style="width: 150px; height: 150px; background-color: #ddd; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 48px;">👤</div>
                <?php endif; ?>
            </td>
            <td class="personal-info">
                <h1><?= $prenom ?> <?= $nom ?></h1>
                <p><strong>Âge:</strong> <?= $age ?> ans</p>
                <p><strong>Tel:</strong> <?= $numero ?></p>
                <p><strong>Email:</strong> <?= $email ?></p>
            </td>
        </tr>
    </table>

    <div class="section">
        <h2>Formations</h2>
        <p><?= nl2br($formations) ?></p>
    </div>

    <div class="section">
        <h2>Stages</h2>
        <p><?= nl2br($stages) ?></p>
    </div>

    <div class="section">
        <h2>Compétences</h2>
        <?php $competenceItems = array_filter(array_map('trim', explode(',', (string)$competences))); ?>
        <?php if (!empty($competenceItems) && count($competenceItems) > 1): ?>
            <ul class="cv-list">
                <?php foreach ($competenceItems as $item): ?>
                    <li><?= htmlspecialchars($item) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p><?= nl2br($competences) ?></p>
        <?php endif; ?>
    </div>

    <div class="section">
        <h2>Langues</h2>
        <?php $langueItems = array_filter(array_map('trim', explode(',', (string)$langues))); ?>
        <?php if (!empty($langueItems) && count($langueItems) > 1): ?>
            <ul class="cv-list">
                <?php foreach ($langueItems as $item): ?>
                    <li><?= htmlspecialchars($item) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p><?= nl2br($langues) ?></p>
        <?php endif; ?>
    </div>

    <div class="section">
        <h2>Centres d'intérêts</h2>
        <?php $centreItems = array_filter(array_map('trim', explode(',', (string)$centres_interets))); ?>
        <?php if (!empty($centreItems) && count($centreItems) > 1): ?>
            <ul class="cv-list">
                <?php foreach ($centreItems as $item): ?>
                    <li><?= htmlspecialchars($item) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p><?= nl2br($centres_interets) ?></p>
        <?php endif; ?>
    </div>
</div>

<div class="action-buttons">
    <form method="post" action="?" style="display: inline;">
        <input type="hidden" name="email" value="<?= $candidat['email'] ?>">
        <input type="hidden" name="action" value="valider">
        <button type="submit" class="btn btn-validate"
                onclick="return confirm('Valider cette candidature?')">Valider</button>
    </form>

    <form method="post" action="?" style="display: inline;">
        <input type="hidden" name="email" value="<?= $candidat['email'] ?>">
        <input type="hidden" name="action" value="refuser">
        <button type="submit" class="btn btn-warning"
                onclick="return confirm('Êtes-vous sûr de vouloir refuser cette candidature?')">Refuser</button>
    </form>

    <form method="post" action="?" style="display: inline;">
        <input type="hidden" name="email" value="<?= $candidat['email'] ?>">
        <input type="hidden" name="action" value="supprimer">
        <button type="submit" class="btn btn-delete"
                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette candidature?')">Supprimer</button>
    </form>
</div>
</body>
</html>
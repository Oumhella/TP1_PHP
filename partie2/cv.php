<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        .cv-container { width: 700px; margin: auto; }
        .top-row { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .top-row td { vertical-align: top; }
        .photo {
            width: 180px;
            padding-right: 30px;
        }
        .photo img {
            border-radius: 50%;
            width: 150px;
            display: block;
        }
        .personal-info {
            margin-top: 0;
            padding-left: 100px;
        }
        h1 { margin-bottom: 6px; font-size: 28px; letter-spacing: 0.5px; }
        h2 {
            margin-top: 25px;
            padding: 8px 10px;
            font-size: 16px;
            letter-spacing: 1px;
            background: #f0f0f0;
            border-left: 4px solid #333;
        }
        .section {
            margin-bottom: 8px;
            padding: 8px 4px 0 4px;
        }
        .section p { margin: 10px 10px 14px 14px; line-height: 1.4; }
        .cv-list { margin: 10px 10px 14px 28px; padding: 0; }
        .cv-list li { margin: 4px 0; }
        .personal-info p { margin: 3px 0; }
    </style>
</head>
<body>
    <div class="cv-container">
        <table class="top-row">
            <tr>
                <td class="photo">
                    <img src="data:image/jpeg;base64,<?= $base64 ?>">
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
            <p><?= $formations ?></p>
        </div>
        <div class="section">
            <h2>Stages</h2>
            <p><?= $stages ?></p>
        </div>
        <div class="section">
            <h2>Compétences</h2>
            <?php $competenceItems = array_filter(array_map('trim', explode(',', (string)$competences))); ?>
            <?php if (!empty($competenceItems)): ?>
            <ul class="cv-list">
                <?php foreach ($competenceItems as $item): ?>
                <li><?= htmlspecialchars($item) ?></li>
                <?php endforeach; ?>
            </ul>
            <?php else: ?>
            <p><?= $competences ?></p>
            <?php endif; ?>
        </div>
        <div class="section">
            <h2>Langues</h2>
            <?php $langueItems = array_filter(array_map('trim', explode(',', (string)$langues))); ?>
            <?php if (!empty($langueItems)): ?>
            <ul class="cv-list">
                <?php foreach ($langueItems as $item): ?>
                <li><?= htmlspecialchars($item) ?></li>
                <?php endforeach; ?>
            </ul>
            <?php else: ?>
            <p><?= $langues ?></p>
            <?php endif; ?>
        </div>
        <div class="section">
            <h2>Centres d'intérêts</h2>
            <?php $centreItems = array_filter(array_map('trim', explode(',', (string)$centres_interets))); ?>
            <?php if (!empty($centreItems)): ?>
            <ul class="cv-list">
                <?php foreach ($centreItems as $item): ?>
                <li><?= htmlspecialchars($item) ?></li>
                <?php endforeach; ?>
            </ul>
            <?php else: ?>
            <p><?= $centres_interets ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

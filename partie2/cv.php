<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<title>CV - <?= $prenom ?> <?= $nom ?></title>
<style>


html, body {
    margin: 0;
    padding: 0;
    height: 100%;
    font-family: Arial, sans-serif;
    color: #333;
}

/* Container pleine page */
.container {
    width: 100%;
    height: 100%;
}

/* Sidebar */
.sidebar {
    float: left;
    width: 30%;
    height: 100%;
    background-color: #f4f4f4;
    text-align: center;
    padding: 30px;
    box-sizing: border-box;
}

.sidebar img {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border-radius: 50%;
    margin-bottom: 20px;
}

.sidebar h2 {
    margin: 10px 0;
}

/* Main content */
.main {
    float: left;
    width: 70%;
    height: 100%;
    background-color: #fff;
    padding: 30px;
    box-sizing: border-box;
}

.section {
    margin-bottom: 20px;
}

.section h3 {
    background-color: #007BFF;
    color: #fff;
    padding: 5px 10px;
    font-size: 16px;
    margin-bottom: 10px;
}

.section p, .section ul {
    margin: 0 0 5px 0;
    font-size: 14px;
}

.skills ul, .languages ul, .interests ul {
    list-style: none;
    padding: 0;
}

.skills ul li, .languages ul li, .interests ul li {
    margin: 3px 0;
}
</style>
</head>
<body>
<div class="container">
    <!-- Sidebar -->
    <div class="sidebar">
        <img src="data:image/jpeg;base64,<?= $base64 ?>" alt="Photo">
        <h2><?= $prenom ?> <?= $nom ?></h2>
        <p>Âge: <?= $age ?> ans</p>
        <p>Téléphone: <?= $numero ?></p>
        <p>Email: <?= $email ?></p>

        <div class="languages">
            <h3>Langues</h3>
            <ul>
                <?php foreach(explode(',', $langues) as $lang): ?>
                    <li><?= trim($lang) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="interests">
            <h3>Centres d'intérêts</h3>
            <ul>
                <?php foreach(explode(',', $centres_interets) as $interet): ?>
                    <li><?= trim($interet) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <!-- Main content -->
    <div class="main">
        <div class="section">
            <h3>Formations</h3>
            <p><?= $formations ?></p>
        </div>

        <div class="section">
            <h3>Stages</h3>
            <p><?= $stages ?></p>
        </div>

        <div class="section skills">
            <h3>Compétences</h3>
            <ul>
                <?php foreach(explode(',', $competences) as $comp): ?>
                    <li><?= trim($comp) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
</body>
</html>

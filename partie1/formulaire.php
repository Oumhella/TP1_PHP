<?php

$nom = $prenom = $age = $telephone = $email = "";
$filiere = $annee = "";
$modules = [];
$nbrP = $projets = $interets = $langues = $remarques = "";
$file = "";


if (isset($_POST['modifier'])) {
    $nom       = $_POST['nom'] ?? "";
    $prenom    = $_POST['prenom'] ?? "";
    $age       = $_POST['age'] ?? "";
    $telephone = $_POST['telephone'] ?? "";
    $email     = $_POST['email'] ?? "";
    $filiere   = $_POST['filiere'] ?? "";
    $annee     = $_POST['annee'] ?? "";
    $modules   = $_POST['modules'] ?? [];
    $nbrP      = $_POST['nbrP'] ?? "";
    $projets   = $_POST['projets'] ?? "";
    $interets  = $_POST['interets'] ?? "";
    $langues   = $_POST['langues'] ?? "";
    $remarques = $_POST['remarque'] ?? "";
    if (isset($_POST['file']) && $_POST['file'] !== "") {
        $file = $_POST['file'];
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Formulaire étudiant</title>
</head>
<body>
<h1>Formulaire étudiant</h1>

<form action="recap.php" method="post" enctype="multipart/form-data">

    <!-- Renseignements personnels -->
    <fieldset>
        <legend>Renseignements personnels</legend>
        Nom: <input type="text" name="nom" value="<?= $nom ?>" required><br>
        Prénom: <input type="text" name="prenom" value="<?= $prenom ?>" required><br>
        Âge: <input type="number" name="age" value="<?= $age ?>" required><br>
        Téléphone: <input type="tel" name="telephone" value="<?= $telephone ?>" required><br>
        Email: <input type="email" name="email" value="<?= $email ?>" required><br>
    </fieldset>

    <!-- Renseignements académiques -->
    <fieldset>
        <legend>Renseignements académiques</legend>
        Filière:<br>
        <?php foreach (["2AP","GSTR","GI","SCM","GC","MS"] as $f) { ?>
            <label><input type="radio" name="filiere" value="<?= $f ?>" <?= $filiere==$f?"checked":"" ?>> <?= $f ?></label>
        <?php } ?>
        <br>
        Année:<br>
        <?php foreach (["1er","2eme","3eme"] as $a) { ?>
            <label><input type="radio" name="annee" value="<?= $a ?>" <?= $annee==$a?"checked":"" ?>> <?= $a ?> année</label>
        <?php } ?>
        <br>
        Modules:<br>
        <?php foreach (["Pro Av","Compilation","Réseau Av.","Web Avancé","POO","BD"] as $m) { ?>
            <label><input type="checkbox" name="modules[]" value="<?= $m ?>" <?= in_array($m,$modules)?"checked":"" ?>> <?= $m ?></label>
        <?php } ?>
        <br>
        Nombre de projets: <input type="number" name="nbrP" value="<?= $nbrP ?>"><br>
    </fieldset>

    <!-- Compétences et intérêts -->
    <fieldset>
        <legend>Compétences et intérêts</legend>
        Projets et stages:<br><textarea name="projets"><?= $projets ?></textarea><br>
        Centres d'intérêt:<br><textarea name="interets"><?= $interets ?></textarea><br>
        Langues:<br><textarea name="langues"><?= $langues ?></textarea><br>
    </fieldset>

    <!-- Remarques et fichier -->
    <fieldset>
        <legend>Remarques et fichier</legend>
        <textarea name="remarque"><?= $remarques ?></textarea><br>
        Fichier: <input type="file" name="file"><br>
        <?php if (!empty($file)) : ?>
            Fichier précédent: <a href="uploads/<?= $file ?>" target="_blank"><?= $file ?></a>
            <input type="hidden" name="file" value="<?= $file ?>">
        <?php endif; ?>

    </fieldset>

    <input type="submit" name="form" value="Envoyer">
</form>
</body>
</html>
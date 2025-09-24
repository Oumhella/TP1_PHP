<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Formulaire pour générer CV PDF</title>
</head>
<body>
    <h1>Génération de CV en PDF</h1>
    <form action="generate_cv.php" method="post" enctype="multipart/form-data">
        <!-- Nom et coordonnées -->
        <fieldset>
            <legend>Nom et coordonnées</legend>
            <label>Nom : <input type="text" name="nom" required></label><br>
            <label>Prénom : <input type="text" name="prenom" required></label><br>
            <label>Téléphone : <input type="tel" name="telephone" required></label><br>
            <label>Email : <input type="email" name="email" required></label><br>
        </fieldset>

        <!-- Photo -->
        <label>Photo : <input type="file" name="photo" accept="image/*" required></label><br>

        <!-- Stages et formations -->
        <label>Stages et formations : <textarea name="stages_formations" required></textarea></label><br>

        <!-- Compétences et langues -->
        <label>Compétences et langues : <textarea name="competences_langues" required></textarea></label><br>

        <!-- Centres d'intérêts -->
        <label>Centres d'intérêts : <textarea name="interets" required></textarea></label><br>

        <input type="submit" value="Générer CV PDF">
    </form>
</body>
</html>
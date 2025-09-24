<?php
// Ce fichier affiche le formulaire pour saisir les informations personnelles et académiques de l'étudiant.
// Les valeurs sont remplies automatiquement si on revient de la page recap.php pour modification (via $_POST).

// Récupération des valeurs POST pour les rendre "sticky" (persistantes)
$nom = isset($_POST['nom']) ? $_POST['nom'] : '';
$prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
$age = isset($_POST['age']) ? $_POST['age'] : '';
$telephone = isset($_POST['telephone']) ? $_POST['telephone'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$filiere = isset($_POST['filiere']) ? $_POST['filiere'] : '';
$annee = isset($_POST['annee']) ? $_POST['annee'] : '';
$modules = isset($_POST['modules']) ? $_POST['modules'] : array(); // Tableau pour checkboxes
$projets = isset($_POST['projets']) ? $_POST['projets'] : '';
$stages = isset($_POST['stages']) ? $_POST['stages'] : '';
$interets = isset($_POST['interets']) ? $_POST['interets'] : '';
$langues = isset($_POST['langues']) ? $_POST['langues'] : '';
$remarques = isset($_POST['remarques']) ? $_POST['remarques'] : '';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Formulaire d'informations de l'étudiant</title>
</head>
<body>
    <h1>Formulaire pour les informations de l'étudiant</h1>
    <form action="recap.php" method="post">
        <!-- Renseignements Personnels -->
        <fieldset>
            <legend>Renseignements Personnels</legend>
            <label>Nom : <input type="text" name="nom" value="<?php echo htmlspecialchars($nom); ?>" required></label><br>
            <label>Prénom : <input type="text" name="prenom" value="<?php echo htmlspecialchars($prenom); ?>" required></label><br>
            <label>Âge : <input type="number" name="age" value="<?php echo htmlspecialchars($age); ?>" required></label><br>
            <label>Numéro de Téléphone : <input type="tel" name="telephone" value="<?php echo htmlspecialchars($telephone); ?>" required></label><br>
            <label>Email : <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required></label><br>
        </fieldset>

        <!-- Renseignements Académiques -->
        <fieldset>
            <legend>Renseignements Académiques</legend>
            <p>Filière :</p>
            <label><input type="radio" name="filiere" value="JAP" <?php if ($filiere == 'JAP') echo 'checked'; ?>> JAP</label>
            <label><input type="radio" name="filiere" value="GSTR" <?php if ($filiere == 'GSTR') echo 'checked'; ?>> GSTR</label>
            <label><input type="radio" name="filiere" value="GI" <?php if ($filiere == 'GI') echo 'checked'; ?>> GI</label>
            <label><input type="radio" name="filiere" value="SCM" <?php if ($filiere == 'SCM') echo 'checked'; ?>> SCM</label>
            <label><input type="radio" name="filiere" value="GC" <?php if ($filiere == 'GC') echo 'checked'; ?>> GC</label><br>

            <p>Année :</p>
            <label><input type="radio" name="annee" value="1er" <?php if ($annee == '1er') echo 'checked'; ?>> 1er année</label>
            <label><input type="radio" name="annee" value="2eme" <?php if ($annee == '2eme') echo 'checked'; ?>> 2ème année</label>
            <label><input type="radio" name="annee" value="3eme" <?php if ($annee == '3eme') echo 'checked'; ?>> 3ème année</label><br>

            <p>Modules suivis cette année :</p>
            <label><input type="checkbox" name="modules[]" value="Réseau Av." <?php if (in_array('Réseau Av.', $modules)) echo 'checked'; ?>> Réseau Av.</label>
            <label><input type="checkbox" name="modules[]" value="Web Avancé" <?php if (in_array('Web Avancé', $modules)) echo 'checked'; ?>> Web Avancé</label>
            <label><input type="checkbox" name="modules[]" value="POO" <?php if (in_array('POO', $modules)) echo 'checked'; ?>> POO</label>
            <label><input type="checkbox" name="modules[]" value="BD" <?php if (in_array('BD', $modules)) echo 'checked'; ?>> BD</label><br>
        </fieldset>

        <!-- Ajouts pour point 2 -->
        <fieldset>
            <legend>Informations supplémentaires</legend>
            <label>Liste des projets réalisés : <textarea name="projets"><?php echo htmlspecialchars($projets); ?></textarea></label><br>
            <label>Stages réalisés par l'étudiant : <textarea name="stages"><?php echo htmlspecialchars($stages); ?></textarea></label><br>
            <label>Centres d'intérêt : <textarea name="interets"><?php echo htmlspecialchars($interets); ?></textarea></label><br>
            <label>Langues parlées : <textarea name="langues"><?php echo htmlspecialchars($langues); ?></textarea></label><br>
        </fieldset>

        <!-- Remarques -->
        <label>Vos remarques : <textarea name="remarques"><?php echo htmlspecialchars($remarques); ?></textarea></label><br>

        <input type="submit" value="Envoyer">
    </form>
</body>
</html>
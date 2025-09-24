<?php
// Commentaires : Ce fichier affiche le récapitulatif des informations et gère l'insertion dans la base de données.
// Il gère les boutons VALIDER (enregistre dans BD) et MODIFIER (renvoie au formulaire avec données).

// Connexion à la base de données avec PDO
try {
    $pdo = new PDO("mysql:host=localhost;dbname=ensa_db", "root", ""); // Remplacez par vos identifiants
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données POST
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $age = $_POST['age'] ?? '';
    $telephone = $_POST['telephone'] ?? '';
    $email = $_POST['email'] ?? '';
    $filiere = $_POST['filiere'] ?? '';
    $annee = $_POST['annee'] ?? '';
    $modules = isset($_POST['modules']) ? implode(', ', $_POST['modules']) : '';
    $projets = $_POST['projets'] ?? '';
    $stages = $_POST['stages'] ?? '';
    $interets = $_POST['interets'] ?? '';
    $langues = $_POST['langues'] ?? '';
    $remarques = $_POST['remarques'] ?? '';

    // Gestion du bouton VALIDER
    if (isset($_POST['valider'])) {
        try {
            // Vérification si l'email existe déjà
            $stmt_check = $pdo->prepare("SELECT email FROM etudiants WHERE email = :email");
            $stmt_check->execute(['email' => $email]);
            if ($stmt_check->rowCount() > 0) {
                echo "<p>L'email existe déjà. Veuillez utiliser un autre email ou modifier l'existant.</p>";
            } else {
                // Insertion des données dans la base de données
                $stmt = $pdo->prepare("INSERT INTO etudiants (email, nom, prenom, age, telephone, filiere, annee, modules, projets, stages, interets, langues, remarques) VALUES (:email, :nom, :prenom, :age, :telephone, :filiere, :annee, :modules, :projets, :stages, :interets, :langues, :remarques)");
                $stmt->execute([
                    'email' => $email,
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'age' => $age,
                    'telephone' => $telephone,
                    'filiere' => $filiere,
                    'annee' => $annee,
                    'modules' => $modules,
                    'projets' => $projets,
                    'stages' => $stages,
                    'interets' => $interets,
                    'langues' => $langues,
                    'remarques' => $remarques
                ]);
                echo "<p>Informations enregistrées avec succès dans la base de données.</p>";
            }
        } catch (PDOException $e) {
            echo "<p>Erreur lors de l'insertion : " . $e->getMessage() . "</p>";
        }
    }
} else {
    // Si pas de POST, rediriger vers formulaire
    header('Location: formulaire.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Récapitulatif des informations</title>
</head>
<body>
    <h1>Récapitulatif des informations</h1>
    <p><strong>Nom :</strong> <?php echo htmlspecialchars($nom); ?></p>
    <p><strong>Prénom :</strong> <?php echo htmlspecialchars($prenom); ?></p>
    <p><strong>Âge :</strong> <?php echo htmlspecialchars($age); ?></p>
    <p><strong>Téléphone :</strong> <?php echo htmlspecialchars($telephone); ?></p>
    <p><strong>Email :</strong> <?php echo htmlspecialchars($email); ?></p>
    <p><strong>Filière :</strong> <?php echo htmlspecialchars($filiere); ?></p>
    <p><strong>Année :</strong> <?php echo htmlspecialchars($annee); ?></p>
    <p><strong>Modules suivis :</strong> <?php echo htmlspecialchars($modules); ?></p>
    <p><strong>Projets réalisés :</strong> <?php echo nl2br(htmlspecialchars($projets)); ?></p>
    <p><strong>Stages réalisés :</strong> <?php echo nl2br(htmlspecialchars($stages)); ?></p>
    <p><strong>Centres d'intérêt :</strong> <?php echo nl2br(htmlspecialchars($interets)); ?></p>
    <p><strong>Langues parlées :</strong> <?php echo nl2br(htmlspecialchars($langues)); ?></p>
    <p><strong>Remarques :</strong> <?php echo nl2br(htmlspecialchars($remarques)); ?></p>

    <!-- Bouton VALIDER : enregistre dans BD -->
    <form action="recap.php" method="post">
        <!-- Champs hidden pour conserver les données -->
        <input type="hidden" name="nom" value="<?php echo htmlspecialchars($nom); ?>">
        <input type="hidden" name="prenom" value="<?php echo htmlspecialchars($prenom); ?>">
        <input type="hidden" name="age" value="<?php echo htmlspecialchars($age); ?>">
        <input type="hidden" name="telephone" value="<?php echo htmlspecialchars($telephone); ?>">
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
        <input type="hidden" name="filiere" value="<?php echo htmlspecialchars($filiere); ?>">
        <input type="hidden" name="annee" value="<?php echo htmlspecialchars($annee); ?>">
        <?php foreach (explode(', ', $modules) as $mod) { ?>
            <input type="hidden" name="modules[]" value="<?php echo htmlspecialchars($mod); ?>">
        <?php } ?>
        <input type="hidden" name="projets" value="<?php echo htmlspecialchars($projets); ?>">
        <input type="hidden" name="stages" value="<?php echo htmlspecialchars($stages); ?>">
        <input type="hidden" name="interets" value="<?php echo htmlspecialchars($interets); ?>">
        <input type="hidden" name="langues" value="<?php echo htmlspecialchars($langues); ?>">
        <input type="hidden" name="remarques" value="<?php echo htmlspecialchars($remarques); ?>">
        <input type="submit" name="valider" value="VALIDER">
    </form>

    <!-- Bouton MODIFIER : renvoie au formulaire avec données -->
    <form action="formulaire.php" method="post">
        <!-- Même champs hidden -->
        <input type="hidden" name="nom" value="<?php echo htmlspecialchars($nom); ?>">
        <input type="hidden" name="prenom" value="<?php echo htmlspecialchars($prenom); ?>">
        <input type="hidden" name="age" value="<?php echo htmlspecialchars($age); ?>">
        <input type="hidden" name="telephone" value="<?php echo htmlspecialchars($telephone); ?>">
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
        <input type="hidden" name="filiere" value="<?php echo htmlspecialchars($filiere); ?>">
        <input type="hidden" name="annee" value="<?php echo htmlspecialchars($annee); ?>">
        <?php foreach (explode(', ', $modules) as $mod) { ?>
            <input type="hidden" name="modules[]" value="<?php echo htmlspecialchars($mod); ?>">
        <?php } ?>
        <input type="hidden" name="projets" value="<?php echo htmlspecialchars($projets); ?>">
        <input type="hidden" name="stages" value="<?php echo htmlspecialchars($stages); ?>">
        <input type="hidden" name="interets" value="<?php echo htmlspecialchars($interets); ?>">
        <input type="hidden" name="langues" value="<?php echo htmlspecialchars($langues); ?>">
        <input type="hidden" name="remarques" value="<?php echo htmlspecialchars($remarques); ?>">
        <input type="submit" value="MODIFIER">
    </form>
</body>
</html> 
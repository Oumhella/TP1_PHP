<?php

$nom = $prenom = $age = $telephone = $email = $filiere = $annee = "";
$modules = [];
$nbrP = $projets = $interets = $langues = $remarques = $file = "";


if (isset($_POST['form'])) {
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


    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $file = basename($_FILES['file']['name']);
        move_uploaded_file($_FILES['file']['tmp_name'], $uploadDir . $file);
    } else {
        $file = $_POST['file'] ?? "";
    }



    if (isset($_POST['valider'])) {
        $fichier = fopen("fichier.txt", "a");
        if ($fichier) {
            fwrite($fichier, "Nom: $nom\n");
            fwrite($fichier, "Prénom: $prenom\n");
            fwrite($fichier, "Âge: $age\n");
            fwrite($fichier, "Téléphone: $telephone\n");
            fwrite($fichier, "Email: $email\n");
            fwrite($fichier, "Filière: $filiere\n");
            fwrite($fichier, "Année: $annee\n");
            fwrite($fichier, "Modules: " . implode(", ", $modules) . "\n");
            fwrite($fichier, "Nombre de projets: $nbrP\n");
            fwrite($fichier, "Projets et stages: $projets\n");
            fwrite($fichier, "Centres d'intérêt: $interets\n");
            fwrite($fichier, "Langues: $langues\n");
            fwrite($fichier, "Remarques: $remarques\n");
            fwrite($fichier, "Fichier: " . ($file ?: "Aucun") . "\n");
            fwrite($fichier, "-------------------------\n");
            fclose($fichier);
            $Message = "Les informations ont été enregistrées dans fichier.txt.";
        } else {
            $Message = "Impossible d'ouvrir le fichier pour écrire.";
        }
    }
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

<p><strong>Nom :</strong> <?php echo $nom; ?></p>
<p><strong>Prénom :</strong> <?php echo $prenom; ?></p>
<p><strong>Âge :</strong> <?php echo $age; ?></p>
<p><strong>Téléphone :</strong> <?php echo $telephone; ?></p>
<p><strong>Email :</strong> <?php echo $email; ?></p>
<p><strong>Filière :</strong> <?php echo $filiere; ?></p>
<p><strong>Année :</strong> <?php echo $annee; ?></p>
<p><strong>Modules suivis :</strong> <?php echo implode(", ", $modules); ?></p>
<p><strong>Nombre de Projets réalisés :</strong> <?php echo $nbrP; ?></p>
<p><strong>Projets et stages réalisés :</strong> <?php echo $projets; ?></p>
<p><strong>Centres d'intérêt :</strong> <?php echo $interets; ?></p>
<p><strong>Langues :</strong> <?php echo $langues; ?></p>
<p><strong>Remarques :</strong> <?php echo $remarques; ?></p>
<p><strong>Fichier :</strong>
    <?php echo $file ? "<a href='uploads/$file' target='_blank'>$file</a>" : "Aucun fichier"; ?>
</p>

<?php if (!empty($Message)) { echo "<p style='color:green;'><strong>$Message</strong></p>"; } ?>


<form action="" method="post" enctype="multipart/form-data">
    <input type="hidden" name="nom" value="<?php echo $nom; ?>">
    <input type="hidden" name="prenom" value="<?php echo $prenom; ?>">
    <input type="hidden" name="age" value="<?php echo $age; ?>">
    <input type="hidden" name="telephone" value="<?php echo $telephone; ?>">
    <input type="hidden" name="email" value="<?php echo $email; ?>">
    <input type="hidden" name="filiere" value="<?php echo $filiere; ?>">
    <input type="hidden" name="annee" value="<?php echo $annee; ?>">
    <?php foreach ($modules as $mod) { ?>
        <input type="hidden" name="modules[]" value="<?php echo $mod; ?>">
    <?php } ?>
    <input type="hidden" name="nbrP" value="<?php echo $nbrP; ?>">
    <input type="hidden" name="projets" value="<?php echo $projets; ?>">
    <input type="hidden" name="interets" value="<?php echo $interets; ?>">
    <input type="hidden" name="langues" value="<?php echo $langues; ?>">
    <input type="hidden" name="remarque" value="<?php echo $remarques; ?>">
    <input type="hidden" name="file" value="<?php echo $file; ?>">
    <input type="hidden" name="form" value="1">

    <button type="submit" name="valider">Valider</button>
</form>


<form action="formulaire.php" method="post">
    <input type="hidden" name="nom" value="<?php echo $nom; ?>">
    <input type="hidden" name="prenom" value="<?php echo $prenom; ?>">
    <input type="hidden" name="age" value="<?php echo $age; ?>">
    <input type="hidden" name="telephone" value="<?php echo $telephone; ?>">
    <input type="hidden" name="email" value="<?php echo $email; ?>">
    <input type="hidden" name="filiere" value="<?php echo $filiere; ?>">
    <input type="hidden" name="annee" value="<?php echo $annee; ?>">
    <?php foreach ($modules as $mod) { ?>
        <input type="hidden" name="modules[]" value="<?php echo $mod; ?>">
    <?php } ?>
    <input type="hidden" name="nbrP" value="<?php echo $nbrP; ?>">
    <input type="hidden" name="projets" value="<?php echo $projets; ?>">
    <input type="hidden" name="interets" value="<?php echo $interets; ?>">
    <input type="hidden" name="langues" value="<?php echo $langues; ?>">
    <input type="hidden" name="remarque" value="<?php echo $remarques; ?>">
    <input type="hidden" name="file" value="<?php echo $file; ?>">
    <input type="submit" name="modifier" value="Modifier">
</form>
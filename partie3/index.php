<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Formulaire étudiant</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
<div class="container">
<h1>Formulaire étudiant</h1>

<form action="index.php" method="post" enctype="multipart/form-data">

    <!-- Renseignements personnels -->
    <fieldset>
        <legend>Renseignements personnels</legend>
        <div class="row">
            <div>
                <label>Nom</label>
                <input type="text" name="nom" required>
            </div>
            <div>
                <label>Prénom</label>
                <input type="text" name="prenom" required>
            </div>
            <div>
                <label>Âge</label>
                <input type="number" name="age" required>
            </div>
            <div>
                <label>Téléphone</label>
                <input type="tel" name="numero" required>
            </div>
            <div>
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div>
                <label>Photo</label>
                <input type="file" name="fileToUpload" id="fileToUpload">
            </div>
        </div>
    </fieldset>

    <!-- Compétences et intérêts -->
    <fieldset>
      <legend>Formations et Stages</legend>
      <label>Formations</label>
      <textarea name="formations"></textarea>
      <label>Stages</label>
      <textarea name="stages"></textarea>
    </fieldset>
    <fieldset>
      <legend>Compétences et intérêts</legend>
      <label>Compétences (séparées par des virgules)</label>
      <textarea name="competences" placeholder="Ex: PHP, JavaScript, SQL"></textarea>
      <label>Langues (séparées par des virgules)</label>
      <textarea name="langues" placeholder="Ex: Français, Anglais, Espagnol"></textarea>
      <label>Centres d'intérêts (séparés par des virgules)</label>
      <textarea name="centres_interets" placeholder="Ex: Lecture, Sport, Voyage"></textarea>
    </fieldset>

    <div class="actions">
        <input type="submit" name="submit" value="Envoyer">
    </div>
</form>
<div>
</body>
</html>

<?php

use Dompdf\Dompdf;

require __DIR__ . '/vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require 'vendor/autoload.php';


if (isset($_POST["submit"])) {
  $nom       = $_POST['nom'] ?? "";
  $prenom    = $_POST['prenom'] ?? "";
  $age       = $_POST['age'] ?? "";
  $numero = $_POST['numero'] ?? "";
  $email     = $_POST['email'] ?? "";
  $centres_interets  = $_POST['centres_interets'] ?? "";
  $langues   = $_POST['langues'] ?? "";
  $stages = $_POST['stages'] ?? "";
  $formations = $_POST['formations'] ?? "";
  $competences = $_POST['competences'] ?? "";

  // Read the uploaded file into a variable
  $imageData = file_get_contents($_FILES["fileToUpload"]["tmp_name"]);


  $base64 = base64_encode($imageData);



$conn = new PDO(
    "{$_ENV['DB_CONNECTION']}:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_DATABASE']};charset={$_ENV['DB_CHARSET']}",
    $_ENV['DB_USERNAME'],
    $_ENV['DB_PASSWORD']
);

    $data =$conn->prepare('INSERT INTO etudiants(email,nom,prenom,age,telephone,formations,competences,stages,interets,langues,photo,etat) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)');
    $data->execute(array($email,$nom,$prenom,$age,$numero,$formations,$competences,$stages,$centres_interets,$langues,$base64,"En cours de traitement"));



  // instantiate and use the dompdf class
  $dompdf = new Dompdf();

  // Capture the template output
  ob_start();
  include "cv.php"; 
  $html = ob_get_clean();

  $dompdf->loadHtml($html);

  // (Optional) Setup the paper size and orientation
  $dompdf->setPaper('A4', 'portrait');

  // Render the HTML as PDF
  $dompdf->render();

  // Output the generated PDF to Browser
  //$dompdf->stream();

  $pdf = $dompdf -> output();
  file_put_contents("test.pdf",$pdf);



}
?>

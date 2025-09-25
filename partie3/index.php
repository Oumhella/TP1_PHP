<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Formulaire étudiant</title>
</head>
<body>
<h1>Formulaire étudiant</h1>

<form action="index.php" method="post" enctype="multipart/form-data">

    <!-- Renseignements personnels -->
    <fieldset>
        <legend>Renseignements personnels</legend>
        Nom: <input type="text" name="nom" required><br>
        Prénom: <input type="text" name="prenom" required><br>
        Âge: <input type="number" name="age" required><br>
        Téléphone: <input type="tel" name="numero" required><br>
        Email: <input type="email" name="email" required><br>
        Photo: <input type="file" name="fileToUpload" id="fileToUpload"><br>
    </fieldset>

    <!-- Compétences et intérêts -->
    <fieldset>
      <legend>Formations et Stages</legend>
      Formations:<br><textarea name="formations"></textarea><br>
      Stages:<br><textarea name="stages"></textarea><br>
    </fieldset>
    <fieldset>
      <legend>Competences et intérêts</legend>
      Competences:<br><textarea name="competences"></textarea><br>
      Centres d'intérêts:<br><textarea name="centres_interets"></textarea><br>
      Langues:<br><textarea name="langues"></textarea><br>

    </fieldset>

    <input type="submit" name="submit" value="Envoyer">
</form>
</body>
</html>

<?php

use Dompdf\Dompdf;

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



  $conn = new PDO('mysql:host=localhost; dbname=tp1_php; charset=utf8', 'root', '');


    $data =$conn->prepare('INSERT INTO etudiants(email,nom,prenom,age,telephone,formations,competences,stages,interets,langues,photo) VALUES (?,?,?,?,?,?,?,?,?,?,?)');
    $data->execute(array($email,$nom,$prenom,$age,$numero,$formations,$competences,$stages,$centres_interets,$langues,$base64));



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

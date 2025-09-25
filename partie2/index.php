<!DOCTYPE html>
<html>
<body>

<form action="index.php" method="post" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>
<?php

use Dompdf\Dompdf;

require 'vendor/autoload.php';

if (isset($_POST["submit"])) {
  $nom = "Lyamani";
  $prenom = "Ismail";
  $age = 21;
  $numero = "0612345678";
  $email = "ismail@gmail.com";
  $stages = "Stage de développement web chez XYZ";
  $formations = "ENSA Tétouan - Génie Informatique";
  $competences = "PHP, Java, C, Laravel, Angular";
  $langues = "Arabe, Français, Anglais";
  $centres_interets = "Lecture, Jeux vidéo, Voyage";
  // Read the uploaded file into a variable
  $imageData = file_get_contents($_FILES["fileToUpload"]["tmp_name"]);

  // Now $imageData contains the binary content of the image
  echo "Image has been stored in a variable.<br>";

  // Example: show its size
  echo "Image size: " . strlen($imageData) . " bytes<br>";

  // If you want to display it directly in HTML
  $base64 = base64_encode($imageData);
  echo '<img src="data:image/jpeg;base64,' . $base64 . '" width="200">';

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

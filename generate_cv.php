<?php
// Ce fichier gère l'upload de la photo et génère le CV en PDF à l'aide de FPDF.
// Assurez-vous que fpdf.php est dans le même dossier.

require('fpdf/fpdf.php'); // Inclusion de la bibliothèque FPDF

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo'])) {
    // Récupération des données
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $telephone = $_POST['telephone'] ?? '';
    $email = $_POST['email'] ?? '';
    $stages_formations = $_POST['stages_formations'] ?? '';
    $competences_langues = $_POST['competences_langues'] ?? '';
    $interets = $_POST['interets'] ?? '';

    // Gestion de l'upload de la photo
    $photo = $_FILES['photo'];
    if ($photo['error'] === 0) {
        $photo_path = 'uploads/' . basename($photo['name']);
        if (!is_dir('uploads')) mkdir('uploads');
        move_uploaded_file($photo['tmp_name'], $photo_path);
    } else {
        die("Erreur lors de l'upload de la photo.");
    }

    // Création du PDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Curriculum Vitae', 0, 1, 'C');
    $pdf->Ln(10);

    // Photo
    $pdf->Image($photo_path, 150, 20, 30); // Position et taille de l'image

    // Nom et coordonnées
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, "Nom : $nom", 0, 1);
    $pdf->Cell(0, 10, "Prénom : $prenom", 0, 1);
    $pdf->Cell(0, 10, "Téléphone : $telephone", 0, 1);
    $pdf->Cell(0, 10, "Email : $email", 0, 1);
    $pdf->Ln(10);

    // Stages et formations
    $pdf->Cell(0, 10, 'Stages et formations :', 0, 1);
    $pdf->MultiCell(0, 10, $stages_formations);
    $pdf->Ln(10);

    // Compétences et langues
    $pdf->Cell(0, 10, 'Compétences et langues :', 0, 1);
    $pdf->MultiCell(0, 10, $competences_langues);
    $pdf->Ln(10);

    // Centres d'intérêts
    $pdf->Cell(0, 10, 'Centres d\'intérêts :', 0, 1);
    $pdf->MultiCell(0, 10, $interets);

    // Output du PDF (téléchargement)
    $pdf->Output('D', 'cv.pdf'); // D pour download
} else {
    header('Location: cv_form.php');
    exit;
}
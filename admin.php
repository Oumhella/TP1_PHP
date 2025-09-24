<?php
// Page admin pour visualiser les candidatures (lire depuis informations.txt ou BD).

echo "<h1>Gestion des candidatures de stage</h1>";

// Exemple lecture depuis fichier
if (file_exists('informations.txt')) {
    $contenu = file_get_contents('informations.txt');
    echo "<pre>" . htmlspecialchars($contenu) . "</pre>";
} else {
    echo "<p>Aucune candidature.</p>";
}

// Pour BD : Connectez PDO et SELECT * FROM etudiants;
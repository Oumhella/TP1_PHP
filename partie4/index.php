<?php

require_once 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

function envoyerMail ($email,$resultat,$nom,$prenom){

    $temp=

    $mail = new PHPMailer(true);
        $sujet="Reponse a votre candidature de stage - Entreprise";
        if ($resultat == true){ //si le cv est accepté resultat = true
            $corps="Bonjour {$prenom} {$nom},\n\nAprès consultation de votre candidature et de votre CV, nous avons le plaisir de vous informer que votre profil a été retenu pour un stage au sein de notre organisation.\nNous reviendrons vers vous prochainement pour vous communiquer les détails pratiques concernant le déroulement du stage.\n\nCordialement,\nL'équipe Recrutement";
        } else { //si le cv n'est accepté resultat = false
            $corps ="Bonjour {$prenom} {$nom},\n\nAprès consultation de votre candidature et de votre CV, nous regrettons de vous informer que votre profil n'a pas été retenu pour le stage proposé.\nNous vous remercions pour l'intérêt porté à notre organisation et vous souhaitons beaucoup de succès dans vos recherches futures.\n\nCordialement,\nL'équipe Recrutement";
        }
            try {
                //Server settings
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = $_ENV["HOST"];                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->SMTPSecure = 'tls';   
                $mail->Username   = $_ENV["USERNAME"];                     //SMTP username
                $mail->Password   = $_ENV["API_KEY"];                              //SMTP password
                $mail->Port       = $_ENV["PORT"];
                $mail->From       = $_ENV["FROM"]; 
                $mail->FromName   = $_ENV["FROM_NAME"];
                $mail->addReplyTo($_ENV["REPLY_TO"]); //l'adresse à répondre
                $mail->addAddress($email);
                $mail->Body    = $corps;
                $mail->Subject = $sujet;
                $mail->send();
            } catch(Exception $e){
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }


}


$conn = new PDO(
    "{$_ENV['DB_CONNECTION']}:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_DATABASE']};charset={$_ENV['DB_CHARSET']}",
    $_ENV['DB_USERNAME'],
    $_ENV['DB_PASSWORD']
);

if (isset($_POST['action']) && isset($_POST['email'])) {
    $email = $_POST['email'];
    $stmt = $conn->prepare('SELECT * FROM etudiants WHERE email = ?');
    $stmt->execute([$email]);
    $candidat = $stmt->fetch();

    $nom = $candidat['nom'];
    $prenom = $candidat['prenom'];

    if ($_POST['action'] === 'valider') {
        envoyerMail($email,true,$nom,$prenom);
        $message = "Candidature validée avec succès!";
        $data = $conn->prepare('UPDATE etudiants SET etat=? WHERE email=?;');
        $data->execute(["Accépté",$email]);
    } elseif ($_POST['action'] === 'refuser') {
        envoyerMail($email,false,$nom,$prenom);
        $data = $conn->prepare('UPDATE etudiants SET etat=? WHERE email=?;');
        $data->execute(["Refusé",$email]);
        $message = "Candidature Refusé!";
    } elseif ($_POST['action'] === 'supprimer') {
        envoyerMail($email,false,$nom,$prenom);
        $data = $conn->prepare('DELETE FROM etudiants WHERE email=?;');
        $data->execute([$email]);
        $message = "Candidature Supprimé avec succées!";
    }
}

if (isset($_GET['voir_cv'])) {
    $email = $_GET['voir_cv'];
    $stmt = $conn->prepare('SELECT * FROM etudiants WHERE email = ?');
    $stmt->execute([$email]);
    $candidat = $stmt->fetch();

    if ($candidat) {
        $nom = htmlspecialchars($candidat['nom']);
        $prenom = htmlspecialchars($candidat['prenom']);
        $age = htmlspecialchars($candidat['age']);
        $numero = htmlspecialchars($candidat['telephone']);
        $email = htmlspecialchars($candidat['email']);
        $formations = htmlspecialchars($candidat['formations']);
        $stages = htmlspecialchars($candidat['stages']);
        $competences = htmlspecialchars($candidat['competences']);
        $langues = htmlspecialchars($candidat['langues']);
        $centres_interets = htmlspecialchars($candidat['interets']);
        $etat = htmlspecialchars($candidat['etat']);
        

        $base64 = '';
        if (!empty($candidat['photo'])) {
            if (is_resource($candidat['photo'])) {
                $base64 = base64_encode(stream_get_contents($candidat['photo']));
            } else {
                $base64 = $candidat['photo'];
            }
        }

        include 'cv_template.php';
        exit;
    }
}

$data = $conn->prepare("SELECT * FROM etudiants ORDER BY FIELD(etat, 'En cours de traitment','Accépté','Refusé');");
$data->execute();
$result = $data->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Candidatures</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
<div class="container">
    <h1>Gestion des Candidatures</h1>

    <?php if (isset($message)): ?>
        <div class="message"><?= $message ?></div>
    <?php endif; ?>

    <?php if (count($result) > 0): ?>
        <table>
            <thead>
            <tr>
                <th>Photo</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Âge</th>
                <th>Etat</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($result as $row): ?>
                <tr>
                    <td class="photo-cell">
                        <?php if (!empty($row['photo'])): ?>
                            <img src="data:image/jpeg;base64,<?= $row['photo'] ?>"   class="photo-thumb" alt="Photo">
                        <?php else: ?>
                            <div class="photo-placeholder">👤</div>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($row['nom']) ?></td>
                    <td><?= htmlspecialchars($row['prenom']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['telephone']) ?></td>
                    <td><?= htmlspecialchars($row['age']) ?></td>
                    <td><?= htmlspecialchars($row['etat']) ?></td>
                    <td class="actions">
                        <a href="?voir_cv=<?= urlencode($row['email']) ?>" class="btn btn-view">Voir CV</a>

                        <form method="post" style="display: inline;">
                            <input type="hidden" name="email" value="<?= htmlspecialchars($row['email']) ?>">
                            <input type="hidden" name="action" value="valider">
                            <button type="submit" class="btn btn-validate"
                                    onclick="return confirm('Valider cette candidature?')">Valider</button>
                        </form>

                        <form method="post" style="display: inline;">
                            <input type="hidden" name="email" value="<?= htmlspecialchars($row['email']) ?>">
                            <input type="hidden" name="action" value="refuser">
                            <button type="submit" class="btn btn-warning"
                                    onclick="return confirm('Êtes-vous sûr de vouloir refuser cette candidature?')">Refuser</button>
                        </form>

                        <form method="post" style="display: inline;">
                            <input type="hidden" name="email" value="<?= htmlspecialchars($row['email']) ?>">
                            <input type="hidden" name="action" value="supprimer">
                            <button type="submit" class="btn btn-delete"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette candidature?')">Supprimer</button>
                        </form>

                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Aucune candidature trouvée.</p>
    <?php endif; ?>
</div>
</body>
</html>
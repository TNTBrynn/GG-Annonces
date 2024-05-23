<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

session_start();

require_once ('connect.php');

$success = false;

//vérifie que le email et mdp ont bien été reçus en POST
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = strip_tags($_POST['email']);
    $mdp = strip_tags($_POST['password']);

    $_SESSION["Courriel"] = $email;

    // Vérifie si le courriel est déja enregistré dans la base de données
    $sql = "SELECT * FROM `utilisateurs` WHERE `Courriel` = :email";
    $query = $db->prepare($sql);
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($result)) {
        // Des résultats ont été trouvés, le courriel est déjà enregistré
        echo "nosuccess";
    } else {
        //Le courriel n'existe pas dans la base de données, on crée un nouvel utilisateur
        $dateCreation = date("Y-m-d H:i:s");
        $nbConnexions = 0;
        $statut = 0;

        $sql = "INSERT INTO `utilisateurs` (`Courriel`, `MotDePasse`, `Creation`, `NbConnexions`, `Statut`) VALUES (:email, :password, :dateCreation, :nbConnexions, :statut);";
        $query = $db->prepare($sql);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->bindValue(':password', $mdp, PDO::PARAM_STR);
        $query->bindValue(':dateCreation', $dateCreation, PDO::PARAM_STR);
        $query->bindValue(':nbConnexions', $nbConnexions, PDO::PARAM_INT);
        $query->bindValue(':statut', $statut, PDO::PARAM_INT);

        $query->execute();
        // $_SESSION('session') = session_id();
        echo "success";
        $success = true;
    }
} else {
    echo 'Veuillez remplir tous les champs';
}


if ($success) {
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com;';
        $mail->SMTPAuth = true;
        $mail->Username = 'projetweb3glms@gmail.com';
        $mail->Password = 'elmg lfae ccyw tbom';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('projetweb3glms@gmail.com', 'Projet Web 3');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Confirmation d\'inscription';
        $mail->Body = '<b>Confirmation d\'inscription pour Les petites annonces GG</b> <br>Voici le lien a suivre : <br>
        <a href="http://localhost:3000/traitement_confirmation_inscription.php?email=' . $email . '">Confirmer votre compte!</a>';
        $mail->send();

    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
    }
}

require_once ('close.php');
?>
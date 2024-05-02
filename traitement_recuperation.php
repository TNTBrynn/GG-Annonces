<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require_once ('connect.php');

$email = strip_tags($_POST['email']);

$sql = "SELECT `MotDePasse` FROM `utilisateurs` WHERE `Courriel` = :email";
$query = $db->prepare($sql);
$query->bindValue(':email', $email, PDO::PARAM_STR);
$query->execute();
$result = $query->fetch(PDO::FETCH_ASSOC);

if ($result) {
    //envoyer le mdp au courriel
    $mdpUtilisateur = $result['MotDePasse'];
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
        $mail->Subject = 'Recuperation du mot de passe';
        $mail->Body = '<b>Recuperation du mot de passe pour Les petites annonces GG</b> <br>Voici votre mot de passe : ' . $mdpUtilisateur;
        $mail->send();

        echo "success";

    } catch (Exception $e) {
        echo "nosuccess";
    }
} else {
    echo 'Aucun utilisateur trouvé, veuillez vous inscrire';
}

require_once ('close.php');
?>
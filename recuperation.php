<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

require_once ("navigation.php");
require_once ('connect.php');

//quand bouton est clické
if (isset($_POST['btnEnvoyer'])) {
    //quand boutton est clické et que le email est rempli
    if (isset($_POST['email']) && !empty($_POST['email'])) {
        $exprReg = '/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,})$/i';
        $email = strip_tags($_POST['email']);

        //vérifie si le courriel match le regex
        if (preg_match($exprReg, $email) == 1) {

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
                    $mail->Username = 'user@gmail.com';
                    $mail->Password = 'password';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    $mail->setFrom('from@gmail.com', 'Name');
                    $mail->addAddress($email);

                    $mail->isHTML(true);
                    $mail->Subject = 'Récupération du mot de passe';
                    $mail->Body = '<b>Récupération du mot de passe pour Les petites annonces GG</b>';
                    $mail->AltBody = 'Voici votre mot de passe : ' . $mdpUtilisateur;
                    $mail->send();
                    echo "Le courriel a été envoyé avec succès!";
                } catch (Exception $e) {
                    echo "Le courriel n'a pas pu être envoyé. Mailer Error: {$mail->ErrorInfo}";
                }

            } else {
                echo '<script>alert("Aucun utilisateur trouvé, veuillez vous inscrire")</script>';
            }
        } else {
            echo '<script>alert("Veuillez remplir tous les champs")</script>';
        }
    } else {
        echo '<script>alert("Veuillez remplir tous les champs")</script>';
    }
}

require_once ('close.php');
?>

<br>

<div class="container col-md-6 jumbotron">
    <h2 class="text-center">Récupération du mot de passe</h2>
    <h5 class="text-center">Veuillez entrez votre adresse courriel, votre mot de passe vous sera par la suite envoyer
    </h5>
    <form method="POST" id="formConnexion">
        <div class="form-row">
            <div class="form-group col-md-12">
                <label>Courriel</label>
                <input class="form-control" id="tbEmail" placeholder="Courriel @" required="required" name="email">
            </div>
            <div class="invalid-feedback">Veuillez entrer votre Courriel</div>
        </div>

        <input type="submit" value="Envoyer" class="btn btn-primary col-md-12" id="btnEnvoyer" name="btnEnvoyer">
    </form>
</div>


<?php
require_once ("Footer.php");
?>
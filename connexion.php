<?php
session_start();
require_once ("navigation.php");
require_once ('connect.php');

$_SESSION["Courriel"] = null;

//quand bouton est clické
if (isset($_POST['bouton'])) {
    //quand boutton clické et que email et mdp sont remplis
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $exprReg = '/^$/';
        $email = $_POST['email'];
        $mdp = $_POST['password'];

        if (preg_match($exprReg, $email) && preg_match($exprReg, $mdp)) {

            $_SESSION["Courriel"] = $_POST['email'];

            if (isset($_SESSION["Nom"]) && isset($_SESSION["Prenom"])) {
                //envoie nom et prenom dans la table utilisateur
                $nom = strip_tags($_POST['Nom']);
                $prenom = strip_tags($_POST['Prenom']);

                $sql = "INSERT INTO `utilisateurs` (`Nom`, `Prenom`) VALUES (:nom, :prenom);";

                $query = $db->prepare($sql);

                $query->bindValue(':nom', $nom, PDO::PARAM_STR);
                $query->bindValue(':prenom', $prenom, PDO::PARAM_STR);

                $query->execute();
            } else {
                //si aucun nom et prenom est défini, renvoie l'utilisateur à Profil utilisateur
                header('Location: profil.php');
            }
        }

    } else {
        header('Location: connexion.php');
    }
} else {
    $_SESSION["Courriel"] = null;
    echo 'btnConnexion marche pas';
}

require_once ('close.php');
?>

<script type="text/javascript">
    /*$(document).ready(function () {
        $("#btnConnexion").click(function () {
            var exprReg = /^$/;
            var strEmail = $("#tbEmail").val();
            var strMDP = $("#tbMDP").val();

            if (exprReg.test(strEmail) == true || exprReg.test(strMDP) == true)
                alert("Veuillez remplir tous les champs");
            else {
                var strDateHeure = new Date(); //table connexions

                $.ajax({
                    url: 'traitement_connexion.php',
                    type: 'post',
                    data: {
                        email: strEmail,
                        password: strMDP
                    },
                    success: function (response) {
                        if (response === 'success') {
                            window.location.href = 'Entreprise.php';
                        } else {
                            alert(response);
                        }
                    }
                });
            }
        });
    });*/
</script>

<br>

<div class="container col-md-6 jumbotron">
    <h2 class="text-center">Connexion</h2>
    <form method="POST" id="formConnexion">
        <div class="form-row">
            <div class="form-group col-md-12">
                <label>Courriel</label>
                <input type="email" class="form-control" id="tbEmail" placeholder="Courriel @" required="required"
                    name="email">
            </div>
            <div class="invalid-feedback">Veuillez entrer votre Courriel</div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-12">
                <label>Mot de passe</label>
                <input type="password" class="form-control" id="tbMDP" placeholder="Mot de passe" required="required"
                    name="password">
                <div class="invalid-feedback">Veuillez entrer votre mot de passe</div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <a href="recuperation.php">Mot de passe oublié?</a>
                </div>
            </div>
        </div>
        <input type="submit" value="Connexion" class="btn btn-primary col-md-12" id="btnConnexion" name="bouton">
    </form>
</div>


<?php
require_once ("Footer.php");
?>
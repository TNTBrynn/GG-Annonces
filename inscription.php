<style>
    .bouton {
        background-color: #FF63E9;
        width: 73%;
        margin-bottom: 10px;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        border: none;
    }
</style>

<?php
session_start();
require_once "navigationConn.php";
require_once "Ressources.php";
?>

<script type="text/javascript">
    $(document).ready(function () {
        $("#btnInscription").click(function () {
            var exprRegEmail = /^[a-zA-Z0-9]+@[a-zA-Z]+\.[a-zA-Z]{3}$/;
            var exprRegMDP = /^[a-z0-9]{5,15}$/;

            var strEmail = $("#tbEmail").val();
            var strConfirmEmail = $("#tbConfirmEmail").val();
            var strMDP = $("#tbPassword").val();
            var strConfirmMDP = $("#tbConfirmPassword").val();

            if (exprRegEmail.test(strEmail) == false)
                alert("Veuillez entrer un courriel valide");
            else if (exprRegMDP.test(strMDP) == false)
                alert("Veuillez entrer un mot de passe valide");
            else if ((strEmail != strConfirmEmail))
                alert("Le courriel n'est pas le même");
            else if (strMDP != strConfirmMDP)
                alert("Le mot de passe n'est pas le même");
            else {
                $.ajax({
                    url: 'traitement_inscription.php',
                    type: 'post',
                    data: {
                        email: strEmail,
                        password: strMDP
                    },
                    success: function (response) {
                        if (response === 'nosuccess') {
                            alert("Ce courriel est déja enregistré. Veuillez vous connecter.");
                        } else {
                            document.getElementById("confirmation").style.display = "block";
                            document.getElementById("inscription").style.display = "none";
                        }
                    }
                });
            }
        });
    });
</script>

<title>Inscription</title>

<div id="inscription" class="container col-md-6 jumbotron">
    <h2 class="text-center">Inscription</h2>
    <form id="formInscription" method="POST" action="">
        <div class="form-row">
            <div class="form-group col-md-12">
                <label>Courriel</label>
                <input type="email" class="form-control" id="tbEmail" name="email" required="required">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label>Confirmer le courriel</label>
                <input type="email" class="form-control" id="tbConfirmEmail" name="confirmEmail" required="required">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label>Mot de passe</label>
                <input type="password" class="form-control" id="tbPassword" required="" name="password">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-12">
                <label>Confirmer le mot de passe</label>
                <input type="password" class="form-control" id="tbConfirmPassword" required="" name="confirmPassword">
            </div>
        </div>
        <input type="button" value="S'inscrire" class="bouton col-md-12" id="btnInscription">
    </form>
</div>

<div id="confirmation" class="container col-md-6 jumbotron" style="display : none">
    <h2 class="text-center">Inscription</h2>
    <form id="formInscription" method="POST" action="">
        <div class="form-row">
            <div class="text-center col-md-12">
                <h4>Un courriel vous a été envoyé pour confirmer votre inscription!</h4>
                <a href="connexion.php">Connectez vous dès maintenant</a>
            </div>
        </div>

    </form>
</div>

<?php
require_once "footer.php";
?>

</html>
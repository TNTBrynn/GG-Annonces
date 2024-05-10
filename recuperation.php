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
if (!isset($_SESSION['session']) || $_SESSION['session'] != session_id()) {
    //On redirige vers la page de connexion si la session n'existe pas ou si la session n'est pas égale à la session_id()
    header('Location: connexion.php');
} else {

    require_once ("navigationConn.php");
    require_once ("Ressources.php");
    ?>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#btnEnvoyer").click(function () {
                var exprReg = /^$/ ///^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,})$/i;
                var strEmail = $("#tbEmail").val();

                if (exprReg.test(strEmail) == true)
                    alert("Veuillez remplir tous les champs");
                else {
                    $.ajax({
                        url: 'traitement_recuperation.php',
                        type: 'post',
                        data: {
                            email: strEmail
                        },
                        success: function (response) {
                            if (response === 'success') {
                                alert("Le courriel a été envoyé avec succès!");
                            } else if (response === 'nosuccess') {
                                alert("Le courriel n'a pas pu être envoyé.");
                            } else {
                                //alert(response);
                            }
                        }
                    });
                }
            });
        });
    </script>

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

            <input type="submit" value="Envoyer" class="bouton col-md-12" id="btnEnvoyer" name="btnEnvoyer">
        </form>
    </div>


    <?php
    require_once ("Footer.php");
}
?>
<style>
    .bouton {
        background-color: #FF63E9;
        width:73%;
        margin-bottom: 10px;
        color:white;
        padding: 10px 20px;
        border-radius: 5px; 
        border: none;
    }
</style>

<?php
require_once ("Ressources.php");
require_once ("navigationConn.php");
?>


<script type="text/javascript">
    $(document).ready(function () {
        $("#btnConnexion").click(function () {
            var exprReg = /^$/ ///^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,})$/i;
            var strEmail = $("#tbEmail").val();
            var strMDP = $("#tbMDP").val();

            if (exprReg.test(strEmail) == true || exprReg.test(strMDP) == true)
                alert("Veuillez remplir tous les champs");
            else {
                $.ajax({
                    url: 'traitement_connexion.php',
                    type: 'post',
                    data: {
                        email: strEmail,
                        password: strMDP
                    },
                    success: function (response) {
                        if (response === 'annonces') {
                            window.location.href = 'annonces.php';
                        } else if (response === 'profil') {
                            window.location.href = 'profil.php';
                        } else {
                            alert(response);
                        }
                    }
                });
            }
        });
    });
</script>

<br>

<div class="container col-md-6 jumbotron">
    <h2 class="text-center">Connexion</h2>
    <form method="POST" id="formConnexion">
        <div class="form-row">
            <div class="form-group col-md-12">
                <label>Courriel</label>
                <input class="form-control" id="tbEmail" placeholder="Courriel @" required="required" name="email">
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
        <input type="submit" value="Connexion" class="bouton col-md-12" id="btnConnexion" name="btnConnexion">
    </form>
</div>


<?php
require_once ("Footer.php");
?>
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
require_once ("navigationAdmin.php");
?>

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
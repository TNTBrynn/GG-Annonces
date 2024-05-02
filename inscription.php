<!DOCTYPE html>
<html>
  <?php
      require_once "navigationConn.php";
      require_once "Ressources.php";
  ?>

<script>
    $(document).ready(function() {
      $("#btnInscription").click(function() {
          if ($("#formInscription")[0].checkValidity()) {
              $("#formInscription").submit();
          } else {
              $("#formInscription").addClass("was-validated");
          }
      });
  });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#btnEnvoyer").click(function () {
            var exprReg = /^$/ ///^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,})$/i;
            var strEmail = $("#tbEmail").val();

            if (exprReg.test(strEmail) == true)
                alert("Veuillez remplir tous les champs");
            else {
                $.ajax({
                    url: 'traitement_inscription.php',
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
                            alert(response);
                        }
                    }
                });
            }
        });
    });
</script>

  <title>Inscription</title>

  <div class="container col-md-5 jumbotron">
      <h2 class="text-center">Inscription</h2><br>
      <form id="formInscription" method="post" action="" oninput="password2.setCustomValidity(password2.value != password.value ? &quot;Veuillez entrer votre Mot de passe&quot; : &quot;&quot;)">
        <div class="form-row">
          <div class="form-group col-md-12">
            <label>Courriel</label>
            <input type="email" class="form-control" id="txtEmailIns" name="email" required="required">
            <div class="valid-feedback">Valide</div>
            <div class="invalid-feedback">Veuillez entrer votre Courriel</div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-12">
            <label>Mot de passe</label> 
            <input type="password" class="form-control" id="txtPassIns" required="" name="password">
            <div class="valid-feedback">Valide</div>
            <div class="invalid-feedback">Veuillez entrer votre Mot de passe</div>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-12">
            <label>Confirmer le Mot de passe</label> 
            <input type="password" class="form-control" id="txtPassInsConfirm" required="" name="password2">
            <div class="valid-feedback">Valide</div>
            <div id="confirmMessage" class="invalid-feedback">Veuillez entrer le même mot de passe</div>
          </div>
        </div>
            <input type="button" value="S'inscrire" class="btn btn-primary col-md-12" id="btnInscription">
      </form>
    </div>

    <?php
    try{
        // Connexion à la bdd
        $db = new PDO('mysql:host=mysql-progweb.alwaysdata.net;dbname=progweb_pjf_glms', 'progweb','ProjetWeb3');
        $db->exec('SET NAMES "UTF8"');
    } catch (PDOException $e){
        echo 'Erreur : '. $e->getMessage();
        die();
    }
?>
<?php
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];

        $sql = "INSERT INTO utilisateurs (Courriel, MotDePasse) VALUES (:email, :password)";
        $stmt = $db->prepare($sql);
        $stmt->execute([':email' => $email, ':password' => $password]);

        header("Location: connexion.php");
    }
    require_once "footer.php";
?>
</html>
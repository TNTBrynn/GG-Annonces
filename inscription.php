<!DOCTYPE html>
<html>
  <?php
      require_once "navigation.php";
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
      if($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];
        require_once "connexionBD.php";
        $sql = "INSERT INTO user (email, password) VALUES ('$email', '$password')";
        $result = mysqli_query($cBD, $sql);
        
        header("Location: inscriptionConfirmee.php");
      }
      require_once "footer.php";
  ?>
</html>
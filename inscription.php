<!DOCTYPE html>
<html>

  <?php
    require_once 'navigation.php';
    require_once 'ressources.php';
  ?>

<script>
    $(document).ready(function() {
      $("#btnEnregistrement").click(function() {
          if ($("#formEnregistrement")[0].checkValidity()) {
              $("#formEnregistrement").submit();
          } else {
              $("#formEnregistrement").addClass("was-validated");
          }
      });
  });
</script>

  <title>Enregistrement</title>

  <div class="container col-md-5 jumbotron">
      <h2 class="text-center">Enregistrement</h2><br>
      <form id="formEnregistrement" method="post" action="" oninput="password2.setCustomValidity(password2.value != password.value ? &quot;Veuillez entrer votre Mot de passe&quot; : &quot;&quot;);
      email2.setCustomValidity(email2.value != email.value ? &quot;Veuillez entrer votre Courriel&quot; : &quot;&quot;)">
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
            <label>Confirmer le courriel</label>
            <input type="email" class="form-control" id="txtEmailInsConfirm" required="" name="email2">
            <div class="valid-feedback">Valide</div>
            <div id="confirmMessage" class="invalid-feedback">Veuillez entrer le même courriel</div>
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
            <input type="button" value="Soumettre" class="btn btn-primary col-md-12" id="btnEnregistrement">
      </form>
    </div>

  <?php
      if($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = strip_tags($_POST["email"]);
        $password = strip_tags($_POST["password"]);

        require_once "connect.php";
        $sql = "INSERT INTO 'utilisateurs' ('Courriel', 'MotDePasse') VALUES (:email, :password);";
        $query = $db->prepare($sql);

        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->bindValue(':password', $password, PDO::PARAM_STR);

        $query->is_execute();
        //header("Location: inscriptionConfirmee.php");
      }
  ?>
</html>
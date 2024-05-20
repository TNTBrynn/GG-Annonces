<?php
require_once ('Ressources.php');
require_once ('connect.php');

$dejaConnecter = false;
$connectionSuccess = false;

$email = strip_tags($_GET['email']);

// Vérifie si le courriel est déja confirmé dans la base de données
$sql = "SELECT `Statut` FROM `utilisateurs` WHERE `Courriel` = :email";
$query = $db->prepare($sql);
$query->bindValue(':email', $email, PDO::PARAM_STR);
$query->execute();
$result = $query->fetch(PDO::FETCH_ASSOC);

//echo $result['Statut'];

if ($result['Statut'] != 0)
    $dejaConnecter = true;
// echo '<script>alert("Ce courriel a déjà été confirmé. Veuillez vous connecter.")</script>';
else {
    // Change le statut de l'utilisateur à confirmé
    $nouvStatut = 9;
    $sql = "UPDATE `utilisateurs` SET `Statut`=:nouvStatut WHERE `Courriel`=:email;";
    $query = $db->prepare($sql);
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->bindValue(':nouvStatut', $nouvStatut, PDO::PARAM_INT);

    $query->execute();
    $connectionSuccess = true;
}

require_once ('close.php');
?>

<title>Confirmation de l'inscription</title>


<div id="confirmation" class="container col-md-6 jumbotron">
    <h2 class="text-center">Inscription</h2>
    <form id="formInscription" method="POST" action="">
        <div class="form-row">
            <div class="text-center col-md-12">

                <?php
                if ($connectionSuccess) {
                    ?>
                    <h4>Votre inscription a été comfirmer avec succès !</h4>
                    <a href="connexion.php">Connectez vous dès maintenant</a>
                    <?php
                } else if ($dejaConnecter) {
                    ?>
                        <h4>Ce courriel a déjà été confirmer...</h4>
                        <a href="connexion.php">Connectez vous dès maintenant</a>
                    <?php
                }
                ?>

            </div>
        </div>

    </form>
</div>


<?php
require_once "footer.php";
?>

</html>
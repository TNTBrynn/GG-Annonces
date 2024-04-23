<?php
    require_once "ressources.php";
    require_once "connect.php";

    $index = $_GET['index'];

    //Get l'email
    $sql = 'SELECT `Courriel` FROM `utilisateurs` WHERE `NoUtilisateur`=:index';
    $query = $db->prepare($sql);
    $query->bindValue(':index', $index, PDO::PARAM_INT);
    $query->execute();
    $emails = $query->fetch();  //dupliqués?

    $email = $emails[0];

    //mail('leaevraire@hotmail.com', 'message', 'header');
?>

     <div style="display: flex; align-items: center; flex-direction: column;">
        </br></br>
        <h3 style="background-color: yellow; width: 500px; text-align: center;">Confirmation</h3>
        <div style="width: 500px;">
            Merci de votre enregistrement. Un courriel a été envoyé à l'adresse '<?php echo $email; ?>' pour confirmer l'enregistrement.
        </div>
     </div>     


<?php
?>
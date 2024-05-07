<style>
    body {
        display: flex;
        flex-direction: column;
        align-items: center;
        background-image: url("./background.jpg");
    }

    .confirm {
        display: flex;
        flex-direction: column;
        width: 100vw;
        height: 30vh;
        background-color: #E8ECEF;
        align-items: center;
    }

    .info {
        display: flex;
        flex-direction: column;
        width: 100vw;
        height: 30vh;
        align-items: center;
    }

    .caseJaune {
        display: flex;
        width: 20%;
        height: 30px;
        background-color: #FCC106;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 20px;
        margin: 50px;
    }

    form {
        margin-left: 10%;
        align-items: center;
        width: 40%;
    }

    .bouton {
        background-color: #007BFF;
        width: 73%;
        margin-bottom: 10px;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        border: none;
    }

    .email {
        width: 70%;
        margin-right: 0px;
        border-color: lightgray;
        border-radius: 5px;
        border-width: 1px;
        padding: 10px;
    }

    label {
        margin-bottom: 10px;
        font-weight: bold;
    }
</style>

<?php
session_start();
if (!isset($_SESSION['session']) || $_SESSION['session'] != session_id()) {
    //On redirige vers la page de connexion si la session n'existe pas ou si la session n'est pas égale à la session_id()
    header('Location: connexion.php');
} else {
    require_once ("connect.php");
    $email = $_SESSION['Courriel'];

    // Regarde si le bouton est clické/si le formulaire est envoyé en post
    if (isset($_POST) && isset($_POST['btnSauvegarder'])) {
        // Récolte les informations du form (saisie de l'utilisateur dans les textbox)
        $statut = strip_tags($_POST['statut']);
        $noEmp = strip_tags($_POST['noEmp']);
        $nom = strip_tags($_POST['nom']);
        $prenom = strip_tags($_POST['prenom']);
        $mdp = strip_tags($_POST['mdp']);
        $telM = strip_tags($_POST['telM']);
        $telT = strip_tags($_POST['telT']);
        $cell = strip_tags($_POST['cell']);

        $sql = "UPDATE `utilisateurs` SET `Statut`=:statut, `NoEmpl`=:noEmp, `Nom`=:nom, `Prenom`=:prenom, 
    `MotDePasse`=:mdp, `NoTelMaison`=:telM, `NoTelTravail`=:telT, `NoTelCellulaire`=:cell WHERE `Courriel`=:email;";

        $query = $db->prepare($sql);

        $query->bindValue(':statut', $statut, PDO::PARAM_STR);
        $query->bindValue(':noEmp', $noEmp, PDO::PARAM_STR);
        $query->bindValue(':nom', $nom, PDO::PARAM_STR);
        $query->bindValue(':prenom', $prenom, PDO::PARAM_STR);
        $query->bindValue(':mdp', $mdp, PDO::PARAM_STR);
        $query->bindValue(':telM', $telM, PDO::PARAM_STR);
        $query->bindValue(':telT', $telT, PDO::PARAM_STR);
        $query->bindValue(':cell', $cell, PDO::PARAM_STR);
        $query->bindValue(':email', $email, PDO::PARAM_STR);

        $query->execute();

        // Redirige l'utilisateur sur la page profil après la mise a jour
        header('Location: profil.php');
    }

    // Récolte les informations de l'utilisateur selon le courriel (variable de session)
    $sql = "SELECT * FROM `utilisateurs` WHERE `Courriel`=:email;";
    $query = $db->prepare($sql);
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch();

    require_once ('close.php');
    ?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Votre Profil</title>

        <?php require_once ('navigation.php'); ?>

    </head>

    <body>
        <h1>Votre Profil</h1>

        <form method="POST" action="">

            <input type="hidden" name="id" value="<?php echo $id; ?>">

            <label for="name">Statut d'employé:</label><br>
            <input class='email' type="text" name="statut" value="<?php echo $result['Statut']; ?>"><br>

            <label for="name">Numéro d'employée:</label><br>
            <input class='email' type="text" name="noEmp" value="<?php echo $result['NoEmpl']; ?>"><br>

            <label for="name">Nom de famille:</label><br>
            <input class='email' type="text" name="nom" value="<?php echo $result['Nom']; ?>" required><br>

            <label for="name">Prénom:</label><br>
            <input class='email' type="text" name="prenom" value="<?php echo $result['Prenom']; ?>" required><br>

            <label for="email">Email:</label><br>
            <input class='email' type="email" name="email" value="<?php echo $result['Courriel']; ?>" readonly><br>

            <label for="name">Mot de passe:</label><br>
            <input class='email' type="text" name="mdp" value="<?php echo $result['MotDePasse']; ?>"><br>

            <label for="address">Téléphone maison:</label><br>
            <input class='email' type="text" name="telM" value="<?php echo $result['NoTelMaison']; ?>"><br>

            <label for="address">Téléphone travail:</label><br>
            <input class='email' type="text" name="telT" value="<?php echo $result['NoTelTravail']; ?>"><br>

            <label for="address">Cellulaire:</label><br>
            <input class='email' type="text" name="cell" value="<?php echo $result['NoTelCellulaire']; ?>"><br> <br>

            <input type="checkbox" id="cbDonneePublic" name="cbDonneePublic" value="RendrePublic">
            <label for="cbDonneePublic">Rendre ses données publiques lors de l’affichage de l’annonce</label><br> <br>

            <input class='bouton' name="btnSauvegarder" type="submit" value="Sauvegarder">
        </form>
    </body>

    </html>
    <?php
}
?>
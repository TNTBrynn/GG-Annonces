<?php
session_start();
require_once ("Ressources.php");
require_once ("navigationConn.php");
require_once ('connect.php');

$_SESSION["Courriel"] = null;

$_SESSION["Nom"] = null;
$_SESSION["Prenom"] = null;

//quand bouton est clické
if (isset($_POST['bouton'])) {
    //quand boutton est clické et que le email et mdp sont remplis
    if (isset($_POST['email']) && isset($_POST['password']) && !empty($_POST['email']) && !empty($_POST['password'])) {
        $exprReg = '/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,})$/i';
        $email = strip_tags($_POST['email']);
        $mdp = strip_tags($_POST['password']);

        //vérifie si le courriel match le regex
        if (preg_match($exprReg, $email) == 1) {
            $_SESSION["Courriel"] = $_POST['email'];

            $sql = "SELECT * FROM `utilisateurs` WHERE `Courriel` = :email AND `MotDePasse` = :mdp";
            $query = $db->prepare($sql);
            $query->bindValue(':email', $email, PDO::PARAM_STR);
            $query->bindValue(':mdp', $mdp, PDO::PARAM_STR);
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result as $user) {
                $idUtilisateur = $user['NoUtilisateur'];
                $nbConnexion = $user['NbConnexions'] + 1;
            }
            if ($result) {
                //envoie date/heure et nb de connexions dans la table connexions
                $sql = "UPDATE `utilisateurs` SET `NbConnexions`=:nbConnexion WHERE `NoUtilisateur`=:idUtilisateur;";
                $query = $db->prepare($sql);
                $query->bindValue(':nbConnexion', $nbConnexion, PDO::PARAM_STR);
                $query->bindValue(':idUtilisateur', $idUtilisateur, PDO::PARAM_STR);
                $query->execute();

                $dateHeure = date("Y-m-d H:i:s");
                $sql = "INSERT INTO `connexions` (`Connexion`, `NoUtilisateur`) VALUES (:dateHeure, :idUtilisateur);";
                $query = $db->prepare($sql);
                $query->bindValue(':dateHeure', $dateHeure, PDO::PARAM_STR);
                $query->bindValue(':idUtilisateur', $idUtilisateur, PDO::PARAM_STR);
                $query->execute();

                if (isset($_SESSION["Nom"]) && isset($_SESSION["Prenom"])) {
                    //envoie nom et prenom dans la table utilisateur
                    $nom = strip_tags($_POST['Nom']);
                    $prenom = strip_tags($_POST['Prenom']);

                    $sql = "INSERT INTO `utilisateurs` (`Nom`, `Prenom`) VALUES (:nom, :prenom);";
                    $query = $db->prepare($sql);
                    $query->bindValue(':nom', $nom, PDO::PARAM_STR);
                    $query->bindValue(':prenom', $prenom, PDO::PARAM_STR);
                    $query->execute();

                    // header('Location: annonces.php');
                } else {
                    //si aucun nom et prenom est défini (nouveau compte), renvoie l'utilisateur à Profil utilisateur
                    header('Location: profil.php');
                }
            } else {
                echo '<script>alert("Aucun utilisateur trouvé, veuillez vous inscrire")</script>';
            }
        } else {
            echo '<script>alert("Veuillez remplir tous les champs")</script>';
        }
    } else {
        echo '<script>alert("Veuillez remplir tous les champs")</script>';
    }
} else
    $_SESSION["Courriel"] = null;

require_once ('close.php');
?>


<!-- .btn {
            background - color: #FF63E9;
        }
 -->

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
        <input type="submit" value="Connexion" class="btn btn-primary col-md-12" id="btnConnexion" name="bouton">
    </form>
</div>


<?php
require_once ("Footer.php");
?>
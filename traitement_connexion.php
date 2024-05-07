<?php
session_start();
require_once ('connect.php');

$_SESSION["Courriel"] = null;

$_SESSION["Nom"] = 'null';
$_SESSION["Prenom"] = 'null';

//vérifie que le email et mdp ont bien été reçus en POST
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = strip_tags($_POST['email']);
    $mdp = strip_tags($_POST['password']);

    //Stocke le courriel dans la varaible de session
    $_SESSION["Courriel"] = $email;

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
            //Stocke le nom et prenom dans des variables de session
            $nom = $_SESSION["Nom"];
            $prenom = $_SESSION["Prenom"];

            //envoie nom et prenom dans la table utilisateur
            $sql = "INSERT INTO `utilisateurs` (`Nom`, `Prenom`) VALUES (:nom, :prenom);";
            $query = $db->prepare($sql);
            $query->bindValue(':nom', $nom, PDO::PARAM_STR);
            $query->bindValue(':prenom', $prenom, PDO::PARAM_STR);
            $query->execute();
            $_SESSION['Courriel'] = $_POST['email'];
            $_SESSION['session'] = session_id();

            if ($_SESSION['Courriel'] == 'admin@gmail.com')
                echo 'admin';
            else
                echo 'annonces';

        } else {
            //si aucun nom et prenom est défini (nouveau compte), renvoie l'utilisateur à Profil utilisateur
            $_SESSION['Courriel'] = $_POST['email'];
            $_SESSION['session'] = session_id();

            if ($_SESSION['Courriel'] == 'admin@gmail.com')
                echo 'admin';
            else
                echo 'profil';
        }
    } else {
        echo 'Aucun utilisateur trouvé, veuillez vous inscrire';
    }
} else {
    echo 'Veuillez remplir tous les champs 2';
}

require_once ('close.php');
?>
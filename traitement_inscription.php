<?php
session_start();
require_once ('connect.php');

// $_SESSION["Courriel"] = null;

// $_SESSION["Nom"] = 'null';
// $_SESSION["Prenom"] = 'null';

//vérifie que le email et mdp ont bien été reçus en POST
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = strip_tags($_POST['email']);
    $mdp = strip_tags($_POST['password']);

    $_SESSION["Courriel"] = $email;

    // Vérifie si le courriel est déja enregistré dans la base de données
    $sql = "SELECT * FROM `utilisateurs` WHERE `Courriel` = :email";
    $query = $db->prepare($sql);
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($result)) {
        // Des résultats ont été trouvés, le courriel est déjà enregistré
        echo "nosuccess";
    } else {
        //Le courriel n'existe pas dans la base de données, on crée un nouvel utilisateur
        $dateCreation = date("Y-m-d H:i:s");
        $nbConnexions = 0;
        $statut = 0;

        $sql = "INSERT INTO `utilisateurs` (`Courriel`, `MotDePasse`, `Creation`, `NbConnexions`, `Statut`) VALUES (:email, :password, :dateCreation, :nbConnexions, :statut);";
        $query = $db->prepare($sql);
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->bindValue(':password', $mdp, PDO::PARAM_STR);
        $query->bindValue(':dateCreation', $dateCreation, PDO::PARAM_STR);
        $query->bindValue(':nbConnexions', $nbConnexions, PDO::PARAM_INT);
        $query->bindValue(':statut', $statut, PDO::PARAM_INT);

        $query->execute();
        
        echo "success";
    }
} else {
    echo 'Veuillez remplir tous les champs';
}

require_once ('close.php');
?>
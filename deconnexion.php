<?php
session_start(); // Démarre la session

require_once ('connect.php');
$email = $_SESSION["Courriel"]; // Attribue la variable de session "Courriel" à la variable $email
$sql = "SELECT * FROM `utilisateurs` WHERE `Courriel` = :email";
$query = $db->prepare($sql);
$query->bindValue(':email', $email, PDO::PARAM_STR);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);

foreach ($result as $user) {
    $idUtilisateur = $user['NoUtilisateur'];
}
if ($result) {
    //envoie date/heure de la déconnexion et le id de l'utilisateur à la table connexions
    $dateHeure = date("Y-m-d H:i:s");
    $sql = "INSERT INTO `connexions` (`Deconnexion`, `NoUtilisateur`) VALUES (:dateHeure, :idUtilisateur);";
    $query = $db->prepare($sql);
    $query->bindValue(':dateHeure', $dateHeure, PDO::PARAM_STR);
    $query->bindValue(':idUtilisateur', $idUtilisateur, PDO::PARAM_STR);
    $query->execute();
}
require_once ('close.php');

// Efface toutes les variables de session
session_unset();

// Détruit la session
session_destroy();

// Redirige l'utilisateur vers la page de connexion
header("Location: connexion.php");
exit;
?>
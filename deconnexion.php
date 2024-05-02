<?php
session_start(); // Démarre la session

// Efface toutes les variables de session
session_unset();

// Détruit la session
session_destroy();

// Redirige l'utilisateur vers la page de connexion
header("Location: connexion.php");
exit;
?>
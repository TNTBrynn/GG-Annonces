<?php
try{
    // Connexion à la bdd
    $db = new PDO('mysql:host=mysql-progweb.alwaysdata.net;dbname=PJF_GLMS', 'progweb','ProjetWeb3');
    $db->exec('SET NAMES "UTF8"');
} catch (PDOException $e){
    echo 'Erreur : '. $e->getMessage();
    die();
}
?>
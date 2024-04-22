<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des produits</title>
    <?php require_once("Ressources.php") ?>  
    <?php require_once("Navigation.php"); ?>
</head>
<body>
</body>
</html>
<?php
    // Création de la base de données projet02_Patry
    try{
        // Connexion à la bdd
        $db = new PDO('mysql:host=localhost', 'root','');
        $db->exec('SET NAMES "UTF8"');
        //contient tout le SQL pour creer la base de données et les tables
        $query = file_get_contents("SQLQueryCreationTables.sql");
        // sql to create table
        $sql= $query;
        // use exec() because no results are returned
        $db->exec($sql);
        echo "La base de donnée projet02_Patry est créee avec succès";        

    } catch (PDOException $e){
        echo 'Erreur : '. $e->getMessage();
        die();
    }
    echo '<br>';
    //Création de la table liste dans la base de données projet02_Patry
    $db = null;
?>



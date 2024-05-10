<?php
session_start();
if (!isset($_SESSION['Courriel']) || $_SESSION['Courriel'] != 'admin@gmail.com') {
    //On redirige vers la page de connexion si la session n'existe pas ou si la session n'est pas égale à la session_id()
    header('Location: ../connexion.php');
} else {
    //si la variable de session courriel et MotDePasse sont ceux de l'administrateur alors la BD peut être créée
    ?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Créer BD</title>
        <?php
        require_once ("Ressources.php");
        require_once ("Navigation.php");
        $binCreer = false
            ?>
    </head>

    <body>
    </body>
    <form method="post" id="frmSaisie">
        <button type="submit" name="btnCreerBD" class="btn btn-primary" value="true">Créer la Base de Données</button>
    </form>

    </html>
    <?php
    //email: 2044087@cgodin.qc.ca
//username: progweb
//MDP: ProjetWeb3
// Création de la base de données projet02_Patry
    if (isset($_POST['btnCreerBD']) && $_POST['btnCreerBD'] == 'true') { //un autre check pour s'assurer que c'est toujours bien l'admin qui appuie avec les variables de session
        try {
            // Connexion à la bdd
            $db = new PDO('mysql:host=mysql-progweb.alwaysdata.net', 'progweb', 'ProjetWeb3');
            $db->exec('SET NAMES "UTF8"');

            //contient tout le SQL pour creer la base de données et les tables
            $query = file_get_contents("SQLQueryCreationTables.sql");
            // sql to create table
            $sql = $query;
            // use exec() because no results are returned
            $db->exec($sql);
            echo "La base de donnée progweb_pjf_glms est créée avec succès";

        } catch (PDOException $e) {
            echo 'Erreur : ' . $e->getMessage();
            die();
        }
        echo '<br>';
        require_once ("connect.php");
        $fp = fopen("insertionCategories.csv", "r");
        if ($fp) {
            fgetcsv($fp); //saute la première ligne
            while (!feof($fp)) {
                $ligne = fgetcsv($fp);
                $sql = "INSERT INTO categories (Description) VALUES (" . $ligne[0] . ")";
                $query = $db->prepare($sql);
                $query->execute();
            }
        } else {
            echo "Le fichier insertionCategories.csv n'existe pas";
        }
        fclose($fp);
        $fp = fopen("insertionUtilisateurs.csv", "r");
        if ($fp) {
            fgetcsv($fp); //saute la première ligne
            while (!feof($fp)) {
                $ligne = fgetcsv($fp);
                $sql = "INSERT INTO utilisateurs (Courriel, MotDePasse, NbConnexions, Statut,
         NoEmpl, Nom, Prenom, NoTelMaison, NoTelTravail, NoTelCellulaire, AutreInfos)
        VALUES (" . $ligne[0] . ", " . $ligne[1] . ", " . $ligne[2] . ", " . $ligne[3] . ", " . $ligne[4] . ", " . $ligne[5] .
                    ", " . $ligne[6] . ", " . $ligne[7] . ", " . $ligne[8] . ", " . $ligne[9] . ", " . $ligne[10] . ")";
                $query = $db->prepare($sql);
                $query->execute();
            }
        } else {
            echo "Le fichier insertionUtilisateurs.csv n'existe pas";
        }
        $fp = fopen("insertionAnnonces.csv", "r");
        if ($fp) {
            fgetcsv($fp); //saute la première ligne
            while (!feof($fp)) {
                $ligne = fgetcsv($fp);
                $sql = "INSERT INTO annonces (NoUtilisateur, Categorie, DescriptionAbregee, DescriptionComplete, Prix, Photo, Etat)
        VALUES (" . $ligne[0] . ", " . $ligne[1] . ", " . $ligne[2] . ", " . $ligne[3] . ", " . $ligne[4] . ", " . $ligne[5] .
                    ", " . $ligne[6] . ")";
                $query = $db->prepare($sql);
                $query->execute();
            }
        } else {
            echo "Le fichier insertionAnnonces.csv n'existe pas";
        }

        require_once ("close.php");
    }
}
?>
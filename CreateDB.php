<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des produits</title>
    <?php require_once ("Ressources.php") ?>
    <?php require_once ("Navigation.php"); ?>
</head>

<body>
</body>

</html>
<?php
//email: 2044087@cgodin.qc.ca
//username: progweb
//MDP: ProjetWeb3
// Création de la base de données projet02_Patry
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
$tValeurs = array();
$fichier = new fichier("insertionCategories.csv");
if ($fichier->existe()) {
    $fichier->chargeEnMemoire();
    $fichier->ouvre();
    while ($fichier->detecteFin()) {
        $fichier->litDonneesLigne($tValeurs, ";", "Description");
        $sql = "INSERT INTO categories (Description) VALUES ('" . $tValeurs[0] . "')";
        $db->exec($sql);
    }
    $fichier->ferme();
} else {
    echo "Le fichier insertionCategories.csv n'existe pas";
}
$fichier = new fichier("insertionUtilisateurs.csv");
if ($fichier->existe()) {
    $fichier->chargeEnMemoire();
    $fichier->ouvre();
    while (!$fichier->detecteFin()) {
        $fichier->litDonneesLigne($tValeurs, ';', "NoUtilisateur, Courriel, MotDePasse, Creation, NbConnexions, ville, Statut, NoEmpl, Nom, Prenom, NoTelMaison, NoTelTravail, NoTelCellulaire, Modification, AutreInfos");
        $db->insereEnregistrement($tValeurs['NoUtilisateur']
        ,$tValeurs['Courriel'],
        $tValeurs['MotDePasse'],
        $tValeurs['Creation'],
        $tValeurs['NbConnexions'],
        $tValeurs['ville'],
         $tValeurs['Statut'],
         $tValeurs['NoEmpl'],
         $tValeurs['Nom'],
         $tValeurs['Prenom'],
         $tValeurs['NoTelMaison'],
         $tValeurs['NoTelTravail'], 
         $tValeurs['NoTelCellulaire'],
         $tValeurs['Modification'],
         $tValeurs['AutreInfos']);
        $db->exec($sql);
    }
} else {
    echo "Le fichier insertionUtilisateurs.csv n'existe pas";
}
?>
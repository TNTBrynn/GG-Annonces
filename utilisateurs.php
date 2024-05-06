<style>
    .couleur {
        background-color: #ffccf8;
    }
</style>
<?php
require_once ("navigationAdmin.php");
require_once ("Ressources.php");

require_once ('connect.php');
$sql = "SELECT 
utilisateurs.*,
GROUP_CONCAT(connexions.Connexion ORDER BY connexions.Connexion DESC SEPARATOR ', ') AS DernieresConnexions,
COUNT(CASE WHEN annonces.Etat = 1 THEN 1 END) AS AnnoncesActives,
COUNT(CASE WHEN annonces.Etat = 2 THEN 1 END) AS AnnoncesInactives,
COUNT(CASE WHEN annonces.Etat = 3 THEN 1 END) AS AnnoncesRetirees
FROM utilisateurs
LEFT JOIN (
SELECT NoUtilisateur, Connexion
FROM connexions
ORDER BY Connexion DESC
LIMIT 5
) AS connexions ON utilisateurs.NoUtilisateur = connexions.NoUtilisateur
LEFT JOIN annonces ON utilisateurs.NoUtilisateur = annonces.NoUtilisateur
GROUP BY utilisateurs.NoUtilisateur
ORDER BY utilisateurs.Nom, utilisateurs.Prenom"
    /*"SELECT utilisateurs.*,
    GROUP_CONCAT(connexions.Connexion ORDER BY connexions.Connexion DESC SEPARATOR ', ') AS DernieresConnexions,
    COUNT(CASE WHEN annonces.Etat = 1 THEN 1 END) AS AnnoncesActives,
    COUNT(CASE WHEN annonces.Etat = 2 THEN 1 END) AS AnnoncesInactives,
    COUNT(CASE WHEN annonces.Etat = 3 THEN 1 END) AS AnnoncesRetirees
    FROM utilisateurs
    LEFT JOIN connexions ON utilisateurs.NoUtilisateur = connexions.NoUtilisateur
    LEFT JOIN annonces ON utilisateurs.NoUtilisateur = annonces.NoUtilisateur
    GROUP BY utilisateurs.NoUtilisateur
    ORDER BY utilisateurs.Nom, utilisateurs.Prenom
    "*/ ;

//$sql = 'SELECT * FROM `utilisateurs` ORDER BY `Nom` AND `Prenom`';
$query = $db->prepare($sql);
$query->execute();
$resultUtilisateurs = $query->fetchAll(PDO::FETCH_ASSOC);

require_once ('close.php');

$intNbActive = 0;
$intNbInactive = 0;
$intNbRetire = 0;

?>

<br>
<h1 class="text-center">Affichage de tous les utilisateurs</h1>
<br>

<div class="container-fluid">
    <div class="">
        <table class="table table-sm table-hover text-center">
            <tbody>
                <tr class="font-weight-bold couleur">
                    <td>No d'utilisateur</td>
                    <td>Courriel</td>
                    <td>Date de création</td>
                    <td>Nombre de connexions</td>
                    <td>Status</td>
                    <td>No d'employé</td>
                    <td>Nom</td>
                    <td>Prénom</td>
                    <td>No de téléphone maison</td>
                    <td>No de téléphone travail</td>
                    <td>No de téléphone cellulaire</td>
                    <td>Modification</td>
                    <td>Date/Heure des 5 dernières connexions</td>
                    <td>Nombre d'annonces actives</td>
                    <td>Nombre d'annonces inactives</td>
                    <td>Nombre d'annonces retirées</td>
                </tr>

                <?php
                foreach ($resultUtilisateurs as $utilisateur) {
                    ?>
                    <tr>
                        <td><?= $utilisateur['NoUtilisateur'] ?></td>
                        <td><?= $utilisateur['Courriel'] ?></td>
                        <td><?= $utilisateur['Creation'] ?></td>
                        <td><?= $utilisateur['NbConnexions'] ?></td>
                        <td><?= $utilisateur['Statut'] ?></td>
                        <td><?= $utilisateur['NoEmpl'] ?></td>
                        <td><?= $utilisateur['Nom'] ?></td>
                        <td><?= $utilisateur['Prenom'] ?></td>
                        <td><?= $utilisateur['NoTelMaison'] ?></td>
                        <td><?= $utilisateur['NoTelTravail'] ?></td>
                        <td><?= $utilisateur['NoTelCellulaire'] ?></td>
                        <td><?= $utilisateur['Modification'] ?></td>
                        <td><?= $utilisateur['DernieresConnexions'] ?></td>
                        <td><?= $utilisateur['AnnoncesActives'] ?></td>
                        <td><?= $utilisateur['AnnoncesInactives'] ?></td>
                        <td><?= $utilisateur['AnnoncesRetirees'] ?></td>

                    </tr>
                    <?php
                }
                ?>

            </tbody>
        </table>
    </div>
</div>
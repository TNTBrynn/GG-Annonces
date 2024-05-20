<style>
    .couleur {
        background-color: #ffccf8;
    }
</style>
<?php
require_once ("Ressources.php");
require_once ("navigationAdmin.php");

require_once ('connect.php');
$statut = 0;
$moisDernier = date('Y-m-d H:i:s', strtotime('-1 month'));
$sql = "SELECT * FROM `utilisateurs` WHERE `Statut`=:statut AND `Creation`<=:moisDernier;";
$query = $db->prepare($sql);
$query->bindValue(':statut', $statut, PDO::PARAM_STR);
$query->bindValue(':moisDernier', $moisDernier, PDO::PARAM_STR);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);

$etat = 3;
$sql = "SELECT * FROM `annonces` WHERE `Etat`=:etat;";
$query = $db->prepare($sql);
$query->bindValue(':etat', $etat, PDO::PARAM_STR);
$query->execute();
$resultAnnonces = $query->fetchAll(PDO::FETCH_ASSOC);

require_once ('close.php');

?>

<br><br>
<h1 class="text-center">Nettoyage de la base de données</h1>
<br><br>

<div class="container-fluid">
    <div id="retraitUtilisateurs">
        <table class="table table-sm table-hover text-center">
            <tbody>
                <tr class="font-weight-bold couleur">
                    <td>No d'utilisateur</td>
                    <td>Courriel</td>
                    <td>Date de création</td>
                    <td>Status</td>
                    <td>No d'employé</td>
                    <td>Nom</td>
                    <td>Prénom</td>
                </tr>
                <?php
                if (count($result) > 0) {
                    foreach ($result as $utilisateur) {
                        ?>
                        <tr>
                            <td><?= $utilisateur['NoUtilisateur'] ?></td>
                            <td><?= $utilisateur['Courriel'] ?></td>
                            <td><?= $utilisateur['Creation'] ?></td>
                            <td><?= $utilisateur['Statut'] ?></td>
                            <td><?= $utilisateur['NoEmpl'] ?></td>
                            <td><?= $utilisateur['Nom'] ?></td>
                            <td><?= $utilisateur['Prenom'] ?></td>

                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            <div class="text-center">
                <a class="btn btn-danger" style="background-color: #ff6188"
                    href="confirmationSupprimerUtilisateurs.php">Supprimer tout</a>
            </div>
            <?php
                } else {
                    ?>
            </tbody>
            </table>
            <h4 class="text-center">Aucun utilisateur à supprimer trouvé</h4>
            <?php
                }
                ?>
        <br>
    </div>
    <br><br>
    <div id="retraitAnnonces">
        <table class="table table-sm table-hover text-center">
            <tbody>
                <tr class="font-weight-bold couleur">
                    <td>No d'annonce</td>
                    <td>No d'utilisateur</td>
                    <td>Date de parution</td>
                    <td>Catégorie</td>
                    <td>Description abrégée</td>
                    <td>Prix</td>
                    <td>État</td>
                </tr>
                <?php
                if (count($resultAnnonces) > 0) {
                    foreach ($resultAnnonces as $annonces) {
                        ?>
                        <tr>
                            <td><?= $annonces['NoAnnonce'] ?></td>
                            <td><?= $annonces['NoUtilisateur'] ?></td>
                            <td><?= $annonces['Parution'] ?></td>
                            <td><?= $annonces['Categorie'] ?></td>
                            <td><?= $annonces['DescriptionAbregee'] ?></td>
                            <td><?= $annonces['Prix'] ?></td>
                            <td><?= $annonces['Etat'] ?></td>

                        </tr>
                        <?php
                    }
                    ?>

                </tbody>
            </table>
            <br>
            <div class="text-center">
                <a class="btn btn-danger" style="background-color: #ff6188"
                    href="confirmationSupprimerAnnonces.php">Supprimer tout</a>
            </div>
            <?php
                } else {
                    ?>
            </tbody>
            </table>
            <h4 class="text-center">Aucune annonce à supprimer trouvé</h4>
            <?php
                }
                ?>
    </div>
</div>
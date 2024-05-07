<?php
//Toujours commencer par session_start
session_start();
//On vérifie si la session et sa variables existe (Dans ce cas-ci on verifie si ce n'est pas le cas, pour ensuite le rediriger vers la page de connexion)
//On vérifie aussi si la variable de session est égale (pas égale dans ce cas) à la valeur de session_id(). Pour nous ce sera l'adresse courriel fournie avec POST que nous allons vérifier
//C //Si la session existe et est égale à la session_id() alors on affiche le contenu de la page et on traite les données

    // On inclut la connexion à la base
    require_once('../connect.php');

    // On écrit notre requête
    $sql = 'SELECT * FROM `employee_employee`';
    $sqlColonne = 'DESCRIBE `employee_employee`';

    // On prépare la requête
    $query = $db->prepare($sql);
    $queryColonne = $db->prepare($sqlColonne);

    // On exécute la requête
    $query->execute();
    $queryColonne->execute();

    // On stocke le résultat dans un tableau associatif
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    $resultColonne = $queryColonne->fetchAll(PDO::FETCH_COLUMN);

?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Liste des employés</title>
        <?php require_once("../Ressources.php") ?>

        <?php require_once("../Navigation.php"); ?>
    </head>

    <body>
        <br>
        <a href="addEmployee.php">Ajouter un employé</a>
        <br>
        <h3>Liste des employés</h3>
        <table class="table text-center">
            <thead>
                <th>Prénom</th>
                <th>Deuxième Prénom</th>
                <th>Nom de Famille</th>
                <th>Genre</th>
                <th>Adresse Email</th>
                <th>Titre</th>
                <th>Département</th>
                <th>Nom Entreprise</th>
                <th>Date Modification</th>
            </thead>
            <tbody>
                <?php
                //va permettre de récupérer les lignes de la table dynamiquement
                foreach ($result as $col) {
                    $tabColonne = array_keys($col);
                ?>
                    <tr>
                        <?php
                        for ($i = 2; $i < count($tabColonne); $i++) {
                            if ($i == 9) {
                                $sql = 'SELECT entreprise_entreprise.EntrepriseName from employee_employee inner join entreprise_entreprise on entreprise_entreprise.EntrepriseID = employee_employee.EntrepriseID';
                                $query = $db->prepare($sql);
                                $query->execute();
                                $result = $query->fetch(PDO::FETCH_ASSOC);
                                echo "<td>" . $result['EntrepriseName'] . "</td>";
                                echo "<td>" . $col[$tabColonne[$i]] . "</td>";
                            } else {
                                echo "<td>" . $col[$tabColonne[$i]] . "</td>";
                            }
                        }
                        ?>
                        <td><a class="btn btn-primary" type="button" href="editEmploye.php?id=<?= $col[$tabColonne[0]] ?>">Modifier</a>
                            <a class="btn btn-success" type="button" href="detailEmploye.php?id=<?= $col[$tabColonne[0]] ?>">Detail</a>
                            <a class="btn btn-danger" type="button" href="deleteEmploye.php?id=<?= $col[$tabColonne[0]] ?>">Supprimer<a>
                        </td>
                    </tr>
                <?php
                }
                require_once('../close.php');
                ?>
            </tbody>
        </table>

    </body>
<?php
    require_once('../footer.php');
//}
?>

    </html>
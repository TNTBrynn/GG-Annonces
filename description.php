<!DOCTYPE html>
<html>
<?php
require_once 'Ressources.php';
require_once 'navigation.php';
session_start();
if (!isset($_SESSION['session']) || $_SESSION['session'] != session_id()) {
    //On redirige vers la page de connexion si la session n'existe pas ou si la session n'est pas égale à la session_id()
    header('Location: ../connexion.php');
} else {
    require_once ('connect.php');
    $email = $_SESSION['Courriel'];

    $sql = "SELECT * FROM utilisateurs WHERE Courriel = :email";
    $stmt = $db->prepare($sql);
    $stmt->execute([':email' => $email]);

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (empty($row['Prenom']) || empty($row['Nom'])) {
            // header("Location: profil.php?id=$id");
            exit;
        }
    }

    // Check if the 'id' parameter is present in the URL
    // Fetch the 'id' value from the URL

    // Fetch the data from the database
    $sql = "SELECT * FROM `annonces` A 
            INNER JOIN `utilisateurs` U ON U.NoUtilisateur = A.NoUtilisateur 
            INNER JOIN `categories` C ON C.NoCategorie = A.Categorie
            WHERE A.noAnnonce = :id";

    $query = $db->prepare($sql);
    $query->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
    $query->execute();
    $items2 = $query->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <title>Annonces GG GMLS</title>
    <style>
        .ok {
            background: url("images/bliss.jpg") no-repeat center center fixed;
            font-family: Arial, sans-serif
        }

        .grid-container {
            display: grid;
            grid-template-columns: auto auto auto auto;
            padding: 10px;
        }

        .grid-item {
            border: 1px solid rgba(0, 0, 0, 0.8);
            padding: 20px;
            font-size: 30px;
            text-align: center;
            background: url("images/tuile.jpg");
        }

        .grid-item img {
            width: 300px;
            height: 300px;
        }

        h1 {
            font-size: 50px;
            text-align: center;
            margin: 50px auto;
        }
    </style>
    </head>

    <body class="ok">
        <h1>Description complète de l'annonce</h1>
        </div>
        <div class="grid-container">
            <?php
            foreach ($items2 as $index => $item) {
                // Fetch the author's full name
                $fullName = $item['Nom'] . ' ' . $item['Prenom'];

                echo '<div class="grid-item">';
                echo '<h2>Item ' . ($index + 1) . '</h2>';
                echo '<p>No Annonce: ' . $item['NoAnnonce'] . '</p>';
                echo '<p>Date d\'ajout: ' . $item['Parution'] . '</p>';
                echo '<p>Auteur: ' . $fullName . '</p>';
                echo '<p>Categorie: ' . $item['Description'] . '</p>';
                echo '<p><a href="description.php?id=' . $item['NoAnnonce'] . '">' . $item['DescriptionAbregee'] . '</a></p>';
                echo '<p>' . $item['DescriptionComplete'] . '</p>';
                echo '<p>Prix: ' . $item['Prix'] . ' $ CAD</p>';
                echo '<img src="' . $item['Photo'] . '" alt="' . $item['DescriptionComplete'] . '">';
                echo '</div>';
            }
}
require_once ('close.php');
?>
    </div>
</body>
<?php require_once 'footer.php'; ?>

</html>
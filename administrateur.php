<!DOCTYPE html>
<html>
<?php
require_once 'Ressources.php';
require_once 'navigationAdmin.php';
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

    //Initialise la prochaine page et la page précédente
    if (isset($_GET['page'])) {
        $page = intval($_GET['page']);
    } else {
        $page = 1;
    }
    $prevPage = max(1, $page - 1); // Ensure page doesn't go below 1

    if (isset($_GET['limit'])) {
        $limit = intval($_GET['limit']);
    } else {
        $_GET['limit'] = 10;
    }

    // Check if the 'id' parameter is present in the URL
    // Fetch the 'id' value from the URL

    // Fetch the data from the database
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $searchTerm = "%" . $search . "%";

        $sql = "SELECT * FROM `annonces` A 
            INNER JOIN `utilisateurs` U ON U.NoUtilisateur = A.NoUtilisateur 
            INNER JOIN `categories` C ON C.NoCategorie = A.Categorie
            WHERE A.DescriptionAbregee LIKE :searchTerm 
            OR A.DescriptionComplete LIKE :searchTerm 
            OR U.Nom LIKE :searchTerm  
            OR U.Prenom LIKE :searchTerm  
            OR C.Description LIKE :searchTerm";

        //Inscrit le nombre d'annonce
        $query = $db->prepare($sql);
        $query->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
        $query->execute();
        $count = $query->rowCount();
        //Le nombre de page qui seront nécessaires
        $nbPages = ceil($count / intval($_GET['limit']));

        $nextPage = min($nbPages, $page + 1);


        //Premier résultat de la page
        $premierResultat = ($page - 1) * intval($_GET['limit']);

        if (isset($_GET['orderBy'])) {
            $orderBy = $_GET['orderBy'];
            $sql .= " ORDER BY $orderBy";
        }
        if (isset($_GET['ordre'])) {
            $ordre = $_GET['ordre'];
            $sql .= " $ordre";
        }
        if (isset($_GET['limit'])) {
            $limit = intval($_GET['limit']);
            $sql .= " LIMIT $premierResultat, $limit";
        } else {
            $sql .= " LIMIT $premierResultat , 10";
        }

        $query = $db->prepare($sql);
        $query->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
        $query->execute();
        $items2 = $query->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $sql = "SELECT * FROM annonces A
                INNER JOIN `utilisateurs` U ON U.NoUtilisateur = A.NoUtilisateur 
                INNER JOIN `categories` C ON C.NoCategorie = A.Categorie";

        //Inscrit le nombre d'annonce
        $query = $db->prepare($sql);
        $query->execute();
        $count = $query->rowCount();
        //Le nombre de page qui seront nécessaires
        $nbPages = ceil($count / intval($_GET['limit']));

        $nextPage = min($nbPages, $page + 1);

        //Premier résultat de la page
        $premierResultat = ($page - 1) * intval($_GET['limit']);

        if (isset($_GET['orderBy'])) {
            $orderBy = $_GET['orderBy'];
            $sql .= " ORDER BY $orderBy";
        }
        if (isset($_GET['ordre'])) {
            $ordre = $_GET['ordre'];
            $sql .= " $ordre";
        }
        if (isset($_GET['limit'])) {
            $limit = intval($_GET['limit']);
            $sql .= " LIMIT $premierResultat, $limit";
        } else {
            $sql .= " LIMIT $premierResultat , 10";
        }

        $query = $db->prepare($sql);
        $query->execute();
        $items2 = $query->fetchAll(PDO::FETCH_ASSOC);
    }
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
    <?php require_once 'navigationAdmin.php'; ?>
    </head>

    <body class="ok">
        <h1>Annonces GG</h1>
        <div>
            <form method="get">
                <input type="text" name="search" placeholder="Rechercher...">
                <button type="submit">Rechercher</button>
                <div>
                    <!-- Tri par  date-->
                    <input type="checkbox" name="orderBy" value="Parution">
                    <label>Trier par date</label>
                    <!-- Tri par Nom et Prenom de l'auteur -->
                    <input type="checkbox" name="orderBy" value="Nom,Prenom">
                    <label>Trier par auteur</label>
                    <!-- Tri selon la catégorie -->
                    <input type="checkbox" name="orderBy" value="Categorie">
                    <label>Trier par catégorie</label>
                    <!-- Tri ascendant ou descendant -->
                    <input type="radio" name="ordre" value="ASC">
                    <label>Ascendant</label>
                    <input type="radio" name="ordre" value="DESC">
                    <label>Descendant</label>
                </div>
                <div>
                    <!-- Définir le nombre d'article par pages -->
                    <select name="limit">
                        <option <?php echo ($_GET['limit'] ?? '') == '5' ? 'selected' : '' ?> value="5">5</option>
                        <option <?php echo ($_GET['limit'] ?? '') == '10' ? 'selected' : '' ?> value="10">10</option>
                        <option <?php echo ($_GET['limit'] ?? '') == '15' ? 'selected' : '' ?> value="15">15</option>
                        <option <?php echo ($_GET['limit'] ?? '') == '20' ? 'selected' : '' ?> value="20">20</option>
                    </select>
                    <!-- Page suivante et précédente -->
                    <button type="submit">Appliquer</button>
                    <button type="submit" name="page" value="<?= $prevPage; ?>">Page précédente</button>
                    <button type="submit" name="page" value="<?= $nextPage; ?>">Page suivante</button>
                </div>
        </div>

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
                echo '<p>Prix: ' . $item['Prix'] . ' $ CAD</p>';
                echo '<img src="' . $item['Photo'] . '" alt="' . $item['DescriptionComplete'] . '">';
                echo '</div>';
            }
}
require_once ('close.php');
?>
    </div>
</body>
<footer>
    <div class="text-center">
        <p>
            <button name="page" value="1">
                << </button>
                    <?php
                    for ($i = 1; $i <= $nbPages; $i++) {
                        ?>
                        <button onclick="window.location.href='annonces.php?page=<?= $i ?>'" <?php if ($i == $page) {
                              echo 'style="color: blue;"';
                          } ?>>
                            <?= $i ?></button>
                        <?php
                    }
                    ?>
                    <button name="page" value="<?= $nbPages ?>"> >> </button>
        </p>
    </div>

</footer>
</form>
<?php require_once 'footer.php'; ?>

</html>
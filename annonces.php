<!DOCTYPE html>
<html>
<head>

<?php
require_once('connect.php');
session_start();
$email = $_SESSION['Courriel'];

$sql = "SELECT * FROM utilisateurs WHERE Courriel = :Courriel";
$stmt = $db->prepare($sql);
$stmt->execute([':Courriel' => $id]);

if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (empty($row['Prenom']) || empty($row['Nom'])) {
        // header("Location: profil.php?id=$id");
        exit;
    }
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
<?php require_once 'navigation.php'; ?>
</head>
<body class="ok">
    <h1>Annonces GG</h1>
    <div class="grid-container">
<?php
    // Check if the 'id' parameter is present in the URL
        // Fetch the 'id' value from the URL
        // $id = $_GET['id'];

        // Fetch the data from the database
        require_once 'connect.php';
         $sql = "SELECT * FROM annonces";
            $result = $db->query($sql);
            $items2 = $result->fetchAll(PDO::FETCH_ASSOC);

        // Display the data raw
        ?>
        <script>console.log(<?php var_dump($items2) ?>);</script>
        <?php
        
        // Assuming you have an array of images and descriptions
        $items = [
            ['img' => 'images/car.jpg', 'desc' => 'Voici ma voiture chéri, elle s\'appelle "La Bête", besoin d\'amour, mais en bonne condition'],
            ['img' => 'images/bryan.jpg', 'desc' => 'Enfant à vendre, très aimable, dort mal la nuit, mais très mignon'],
            ['img' => 'images/phone.jpg', 'desc' => 'Je vends mon nouveau Iphone 15 Pro Max, je veux un Samsung Galaxy S30 Ultra, échange possible'],
            ['img' => 'images/mur.jpg', 'desc' => 'Je vends mon mur, raison: je veux un mur plus grand'],
            ['img' => 'images/google.png', 'desc' => 'Je vends ma petite entreprise, elle s\'appelle "Google", elle a un bon potentiel de croissance'],
            ['img' => 'images/rock.jpg', 'desc' => 'Voici The Rock, il est cool']
        ];

foreach ($items2 as $index => $item) {
    // Fetch the author's full name
    $sql = "SELECT Nom, Prenom FROM utilisateurs WHERE NoUtilisateur = :NoUtilisateur";
    $stmt = $db->prepare($sql);
    $stmt->execute([':NoUtilisateur' => $item['NoUtilisateur']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $fullName = $user['Nom'] . ' ' . $user['Prenom'];

    // Fetch the category description
    $sql = "SELECT Description FROM categories WHERE NoCategorie = :NoCategorie";
    $stmt = $db->prepare($sql);
    $stmt->execute([':NoCategorie' => $item['Categorie']]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);

    echo '<div class="grid-item">';
    echo '<h2>Item ' . ($index + 1) . '</h2>';
    echo '<p>No Annonce: ' . $item['NoAnnonce'] . '</p>';
    echo '<p>Date d\'ajout: ' . $item['Parution'] . '</p>';
    echo '<p>Auteur: ' . $fullName . '</p>';
    echo '<p>Categorie: ' . $category['Description'] . '</p>';
    echo '<p><a href="description.php?id=' . $item['NoAnnonce'] . '">' . $item['DescriptionAbregee'] . '</a></p>';
    echo '<p>Prix: ' . $item['Prix'] . ' $ CAD</p>';
    echo '<img src="' . $item['Photo'] . '" alt="' . $item['DescriptionComplete'] . '">';
    echo '</div>';
}       
   
?>
    </div>
</body>
</html>
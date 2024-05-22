<!DOCTYPE html>
<html>
<head>
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
label {
    display: block;
    margin-bottom: 10px;
}
label input {
    width: 100%;
    box-sizing: border-box;
}
label textarea {
    width: 100%;
    box-sizing: border-box;
}
</style>

<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['session']) || $_SESSION['session'] != session_id()) {
    // Redirect the user to the login page or display an error message
    header('Location: connexion.php');
    exit;
}

if (empty($_SESSION['Prenom']) || empty($_SESSION['Nom'])) {
    header("Location: profil.php");
   exit;
}
require_once 'connect.php';

// Fetch the NoUtilisateur for the current user's email
$sql = "SELECT NoUtilisateur FROM utilisateurs WHERE Courriel = :email";
$stmt = $db->prepare($sql);
$stmt->execute([':email' => $_SESSION['Courriel']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    // Fetch the ads for the user
    $sql = "SELECT * FROM annonces WHERE NoUtilisateur = :noUtilisateur";
    $stmt = $db->prepare($sql);
    $stmt->execute([':noUtilisateur' => $user['NoUtilisateur']]);
    $items2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "No user found with email " . $_SESSION['Courriel'];
}
require_once 'navigation.php';
?>
</head>
<body class="ok">
    <h1>Vos Annonces</h1>
    <div class="grid-container">
    <?php
// Display the user's ads
foreach ($items2 as $index => $item) {
    // Fetch the author's full name
    $sql = "SELECT Nom, Prenom FROM utilisateurs WHERE NoUtilisateur = :NoUtilisateur";
    $stmt = $db->prepare($sql);
    $stmt->execute([':NoUtilisateur' => $item['NoUtilisateur']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $fullName = $user['Nom'] . ' ' . $user['Prenom'];

// Fetch all categories
$sql = "SELECT * FROM categories";
$stmt = $db->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<div class="grid-item">';
echo '<h2>Item ' . ($index + 1) . '</h2>';
echo '<form method="POST" action="">';
echo '<label>No Annonce: <input disabled type="text" name="NoAnnonce" value="' . $item['NoAnnonce'] . '" readonly></label>';
echo '<label>Date d\'ajout: <input disabled type="text" name="Parution" value="' . $item['Parution'] . '" readonly></label>';
echo '<label>Auteur: <input disabled type="text" name="Auteur" value="' . $fullName . '" readonly></label>';
echo '<input type="hidden" name="NoUtilisateur" value="' . $item['NoUtilisateur'] . '">'; // Hidden input field for NoUtilisateur
echo '<input type="hidden" name="NoAnnonce" value="' . $item['NoAnnonce'] . '">'; // Hidden input field for NoAnnonce

// Category dropdown
echo '<label>Categorie: ';
echo '<select name="Categorie">';
foreach ($categories as $category) {
    $selected = $category['NoCategorie'] == $item['Categorie'] ? 'selected' : '';
    echo '<option value="' . $category['NoCategorie'] . '" ' . $selected . '>' . $category['Description'] . '</option>';
}
echo '</select></label>';

echo '<label>Description: <input type="text" name="DescriptionAbregee" value="'. $item['DescriptionAbregee'] . '"></label>';
echo '<label>Prix: <input type="text" name="Prix" value="' . $item['Prix'] . '" readonly><span> $ CAD </span></label>';
echo '<label>Photo: <input type="text" name="Photo" value="' . $item['Photo'] . '" readonly></label>';
echo '<label>Description longue: <textarea name="DescriptionComplete" readonly>'. $item['DescriptionComplete'] . '</textarea></label>';
echo '<input type="submit" value="Update">';
echo '</form>';
echo '</div>';
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $NoAnnonce = $_POST['NoAnnonce'];
    $Categorie = $_POST['Categorie'];
    $DescriptionAbregee = $_POST['DescriptionAbregee'];
    $Prix = $_POST['Prix'];
    $Photo = $_POST['Photo'];
    $DescriptionComplete = $_POST['DescriptionComplete'];

    // Update the database
    $sql = "UPDATE annonces SET Categorie = :Categorie, DescriptionAbregee = :DescriptionAbregee, Prix = :Prix, Photo = :Photo, DescriptionComplete = :DescriptionComplete WHERE NoAnnonce = :NoAnnonce";
    $stmt = $db->prepare($sql);
    $stmt->execute([':Categorie' => $Categorie, ':DescriptionAbregee' => $DescriptionAbregee, ':Prix' => $Prix, ':Photo' => $Photo, ':DescriptionComplete' => $DescriptionComplete, ':NoAnnonce' => $NoAnnonce]);
}

// Close the database connection
$pdo = null;
?>

</div>
</body>
</html>
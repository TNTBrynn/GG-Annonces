<style>
 body {
        display: flex;
        flex-direction: column;
        align-items: center;
        background-image: url("./background.jpg"); 
    }
    .confirm {
        display: flex;
        flex-direction: column;
        width:100vw;
        height: 30vh;
        background-color: #E8ECEF;
        align-items:center;
    }
    .info {
        display: flex;
        flex-direction: column;
        width:100vw;
        height: 30vh;
        align-items:center;
    }
    .caseJaune {
        display:flex;
        width: 20%;
        height: 30px;
        background-color: #FCC106;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size:20px;
        margin:50px;
    }
    form {  
        margin-left:10%;
        align-items: center;
        width: 40%;
    }
    .bouton {
        background-color: #007BFF;
        width:73%;
        margin-bottom: 10px;
        color:white;
        padding: 10px 20px;
        border-radius: 5px; 
        border: none;
    }
    .email {
        width: 70%;
        margin-right: 0px;
        border-color: lightgray;
        border-radius: 5px;
        border-width: 1px;
        padding: 10px;
    }
    label {
        margin-bottom: 10px;
        font-weight:bold;
    }
</style>
<?php
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the updated user information from the form
    $id = $_POST['id'];
    $statut = $_POST['statut'];
    $noEmp = $_POST['noEmp'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $telM = $_POST['telM'];
    $telT = $_POST['telT'];
    $cell = $_POST['cell'];
    
    // TODO: Update the user information in the database or perform any other necessary actions

    require_once("connect.php");

    try {
        $sql = "UPDATE utilisateurs SET Statut = :statut, NoEmpl = :noEmp, Nom = :nom, Prenom = :prenom, Courriel = :email, MotDePasse = :mdp, NoTelMaison = :telM, NoTelTravail = :telT, NoTelCellulaire = :cell WHERE NoUtilisateur = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':statut' => $statut,
            ':noEmp' => $noEmp,
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':mdp' => $mdp,
            ':telM' => $telM,
            ':telT' => $telT,
            ':cell' => $cell,
            ':id' => $id
        ]);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Redirect the user back to the profile page after updating
    header('Location: profil.php?id=' . $id);
    exit;
}

// Retrieve the user information from the database

require_once("connect.php");

// Get the user ID from the query string
session_start();
$email = $_SESSION['Courriel'];

$sql = "SELECT * FROM utilisateurs WHERE Courriel = :Courriel";
$stmt = $db->prepare($sql);
$stmt->execute([':Courriel' => $email]);

if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    echo "No records found with Courriel = $email.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Votre Profil</title>

    <?php require_once('navigation.php'); ?>

</head>
<body>
    <h1>Votre Profil</h1>
    
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

        <input type="hidden" name="id" value="<?php echo $id; ?>">
        
        <label for="name">Statut d'employé:</label><br>
        <input class='email' type="text" name="statut" value="<?php echo $row['Statut']; ?>"><br>

        <label for="name">Numéro d'employée:</label><br>
        <input class='email' type="text" name="noEmp" value="<?php echo $row['NoEmpl']; ?>"><br>

        <label for="name">Nom de famille:</label><br>
        <input class='email' type="text" name="nom" value="<?php echo $row['Nom']; ?>"><br>
        
        <label for="name">Prénom:</label><br>
        <input class='email' type="text" name="prenom" value="<?php echo $row['Prenom']; ?>"><br>

        <label for="email">Email:</label><br>
        <input class='email' type="email" name="email" value="<?php echo $row['Courriel']; ?>"><br>

        <label for="name">Mot de passe:</label><br>
        <input class='email' type="text" name="mdp" value="<?php echo $row['MotDePasse']; ?>"><br>

        <label for="address">Téléphone maison:</label><br>
        <input class='email' type="text" name="telM" value="<?php echo $row['NoTelMaison']; ?>"><br>

        <label for="address">Téléphone travail:</label><br>
        <input class='email' type="text" name="TtlT" value="<?php echo $row['NoTelTravail']; ?>"><br>
        
        <label for="address">Cellulaire:</label><br>
        <input class='email' type="text" name="cell" value="<?php echo $row['NoTelCellulaire']; ?>"><br> <br>
        
        <input class='bouton' type="submit" value="Sauvegarder">
    </form>
</body>
</html>
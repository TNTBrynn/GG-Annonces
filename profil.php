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
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    
    // TODO: Update the user information in the database or perform any other necessary actions
    
    // Redirect the user back to the profile page after updating
    header('Location: profil.php?id=' . $_GET['id']);
    exit;
}

// Retrieve the user information from the database or any other data source
$nom = 'Coxlong';
$prenom = 'Mike';
$email = 'MikeC@example.com';
$statut = '9';
$noEmp = '69';
$mdp = 'minecraft';
$telHome = '(418) 123-4567';
$telWork = '(418) 123-4567';
$cell = '(418) 123-4567';

?>

<!DOCTYPE html>
<html>
<head>
    <title>Votre Profil</title>
</head>
<body>
    <h1>Votre Profil</h1>
    
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="name">Statut d'employé:</label><br>
        <input class='email' type="text" name="nom" value="<?php echo $statut; ?>"><br>

        <label for="name">Numéro d'employée:</label><br>
        <input class='email' type="text" name="nom" value="<?php echo $noEmp; ?>"><br>

        <label for="name">Nom de famille:</label><br>
        <input class='email' type="text" name="nom" value="<?php echo $nom; ?>"><br>
        
        <label for="name">Prénom:</label><br>
        <input class='email' type="text" name="prenom" value="<?php echo $prenom; ?>"><br>

        <label for="email">Email:</label><br>
        <input class='email' type="email" name="email" value="<?php echo $email; ?>"><br>

        <label for="name">Mot de passe:</label><br>
        <input class='email' type="text" name="nom" value="<?php echo $mdp; ?>"><br>

        <label for="address">Téléphone maison:</label><br>
        <input class='email' type="text" name="adresse" value="<?php echo $telHome; ?>"><br>

        <label for="address">Téléphone travail:</label><br>
        <input class='email' type="text" name="adresse" value="<?php echo $telWork; ?>"><br>
        
        <label for="address">Cellulaire:</label><br>
        <input class='email' type="text" name="adresse" value="<?php echo $cell; ?>"><br> <br>
        
        <input class='bouton' type="submit" value="Sauvegarder">
    </form>
</body>
</html>
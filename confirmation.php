<!DOCTYPE html>
<html>
<head>
    <title>Confirmation Page</title>
</head>
<?php
require_once("navigation.php");
?>
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
<body>
    <?php
    // Get the parameter value
    $origin = isset($_GET['origin']) ? $_GET['origin'] : '';

    ?>
    <div class="confirm">

        <?php
        if ($origin == 'inscription') {
            echo "<h1>Merci de votre inscription!</h1>";
        } else if ($origin == 'contact') {
            echo "<h1>Confirmation de la réception de votre message!</h1>";
        } else {
            echo "<h1>Ceci est la page de confirmation sans paramètre</h1>";
        }
        ?>
        <h2>Grégory Desjardins</h2>
    </div>

    <div class="info">
        <p class="caseJaune"><?php
        if ($origin == 'inscription') {
            echo "Inscription";
        } else if ($origin == 'contact') {
            echo "Contact";
        } else {
            echo "Aucune information disponible";
        }
        ?></p>
    </break>
    <p><?php
        if ($origin == 'inscription') {
            echo "Vous pouvez maintenant vous connectez à l'application.";
        } else if ($origin == 'contact') {
            echo "Nous vous répondrons dans les plus brefs délais.";
        } else {
            echo "Aucune information disponible";
        }
        ?></p>
    </div>
</body>
</html>
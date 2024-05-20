<!DOCTYPE html>
<html>
<head>
    <title>Module administrateur</title>
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #FF63E9;
            height: 50px;
            width: 100%;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            position: fixed;
            top: 0;
            z-index: 1030;
        }

        .navbar a {
            text-decoration: none;
            color: white;
            margin-right: 10px;
        }
        .connex {
            font-size: 20px;
        }
    </style>
</head>
<body>
<?php

?>
    <div class="navbar">
        <!-- Contenu de la barre de navigation -->
        <a class="connex" href="CreateDB.php">Base de données</a>
        <a class="connex" href="administrateur.php">Annonces GG</a>
        <a class="connex" href="utilisateurs.php">Utilisateurs</a>
        <a class="connex" href="nettoyageBD.php">Nettoyage</a>
        <a class="connex" href="deconnexion.php">Déconnexion</a>
    </div>
</body>
</html>
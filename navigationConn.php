<!DOCTYPE html>
<html>
<head>
    <title>Menu Principal</title>
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
            z-index: 1030; /* to prevent the navbar getting covered up by other content */
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
    <div class="navbar">
        <!-- Contenu de la barre de navigation -->
        <a class="connex" href="inscription.php">Inscription</a>
        <a class="connex" href="connexion.php">Connexion</a>
    </div>
</body>
</html>
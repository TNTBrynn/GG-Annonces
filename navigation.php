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
        <a class="connex" href="profil.php">Profil</a>
        <a class="connex" href="annonces.php?id=">Vos annonces</a>
        <a class="connex" href="annonces.php">Annonces GG</a>
    </div>
</body>
</html>
<!DOCTYPE html>
<html>
    <head>
        <title>Retrait de l'annonce</title>
    <head>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-image: url("./background.jpg");
            font-family: Arial, sans-serif;
        }

        form {
            margin-left: 10%;
            align-items: center;
            width: 40%;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            margin-bottom: 10px;
            font-weight: bold;
            display: block;
        }

        h1 {
            font-size: 50px;
            text-align: center;
            margin: 50px auto;
        }

        input, select, textarea {
            width: 100%;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            float: right;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<?php
    // Inclure les fichiers nécessaires
    require_once 'Ressources.php';
    require_once 'navigation.php';

    session_start();

    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['session']) || $_SESSION['session'] != session_id()) {
        header('Location: ../connexion.php');
        exit();
    }

    require_once 'connect.php';

    // Vérifier si l'identifiant de l'annonce est dans l'URL
    if (isset($_GET['id'])) {
        $annonce_id = $_GET['id'];

        // Récupérer les données de l'annonce
        $sql = "SELECT * FROM annonces WHERE NoAnnonce = :annonce_id";
        $stmt = $db->prepare($sql);
        $stmt->execute([':annonce_id' => $annonce_id]);
        $annonce = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si l'annonce existe
        if ($annonce) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
                // Mettre à jour l'état de l'annonce à "Retiré" (3)
                $sql_update = "UPDATE annonces SET Etat = '3' WHERE NoAnnonce = :annonce_id";
                $stmt_update = $db->prepare($sql_update);
                $stmt_update->execute([':annonce_id' => $annonce_id]);
                exit();
            }

?>
    <body>
        <h1>Retrait de l'annonce</h1>

        <form method="POST">
        <p>Détails de l'annonce :</p>
        <ul>
            <li>Description Abregée: <?php echo $annonce['DescriptionAbregee']; ?></li>
            <li>Description Complète: <?php echo $annonce['DescriptionComplete']; ?></li>
            <li>Prix: <?php echo $annonce['Prix']; ?></li>
            <img src="<?php echo $annonce['Photo']; ?>" alt="Image de l'annonce" style="width:300px; height:300px;">

        </ul>
            <p>Voulez-vous vraiment retirer cette annonce ?</p>
            <a href="vosAnnonces.php" style="display: inline-block; padding: 10px 20px; background-color: green; color: white; text-align: center; text-decoration: none; border-radius: 4px">Annuler</a>
            <button type="submit" name="confirm">Confirmer le retrait</button>
        </form>
    </body>
</html>
<?php
        }
    }
?>

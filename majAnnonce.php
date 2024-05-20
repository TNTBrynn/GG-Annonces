<!DOCTYPE html>
    <html>
        <head>
            <title>Mise à jour de l'annonce</title>
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

    // Récupérer les catégories
    $sql_categories = "SELECT * FROM categories";
    $stmt_categories = $db->prepare($sql_categories);
    $stmt_categories->execute();
    $categories = $stmt_categories->fetchAll(PDO::FETCH_ASSOC);

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
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // Récupérer les données du formulaire
                $categorie = $_POST['categorie'];
                $description_abregee = $_POST['description_abregee'];
                $description_complete = $_POST['description_complete'];
                $prix = $_POST['prix'];
                $etat = $_POST['etat'];

                // Téléversement de la photo
                $photo = $annonce['Photo'];
                if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
                    $upload_dir = 'images/';
                    $photo = $upload_dir . basename($_FILES['photo']['name']);
                    if (move_uploaded_file($_FILES['photo']['tmp_name'], $photo)) {
                        // Optionally create a thumbnail
                        // $thumbnail_path = $upload_dir . 'thumb_' . basename($_FILES['photo']['name']);
                        // Thumbnail creation error handling
                    } else {
                        $errors[] = "Erreur lors du téléversement de la photo.";
                    }
                }

                // Mettre à jour les données de l'annonce
                $sql_update = "UPDATE annonces SET Categorie = :categorie, DescriptionAbregee = :description_abregee, DescriptionComplete = :description_complete, Prix = :prix, Photo = :photo, Etat = :etat, MiseAJour = CURRENT_TIMESTAMP() WHERE NoAnnonce = :annonce_id";
                $stmt_update = $db->prepare($sql_update);
                $stmt_update->execute([
                    ':categorie' => $categorie,
                    ':description_abregee' => $description_abregee,
                    ':description_complete' => $description_complete,
                    ':prix' => $prix,
                    ':photo' => $photo,
                    ':etat' => $etat,
                    ':annonce_id' => $annonce_id
                ]);

                header("Location: vosAnnonces.php?message=Annonce mise à jour avec succès");
                exit();
            }

?>
    <body>
        <h1>Mise à Jour de l'annonce</h1>
        <form method="POST" enctype="multipart/form-data">
            <label>Catégorie:</label>
            <select name="categorie">
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['NoCategorie']; ?>" <?php echo ($annonce['Categorie'] == $category['NoCategorie']) ? 'selected' : ''; ?>><?php echo $category['Description']; ?></option>
                <?php endforeach; ?>
            </select><br>

            <label>Description Abrégée:</label>
            <input type="text" name="description_abregee" value="<?php echo $annonce['DescriptionAbregee']; ?>"><br>

            <label>Description Complète:</label>
            <textarea name="description_complete"><?php echo $annonce['DescriptionComplete']; ?></textarea><br>

            <label>Prix:</label>
            <input type="text" name="prix" value="<?php echo $annonce['Prix']; ?>"><br>

            <label>Photo actuelle:</label>
            <img src="<?php echo $annonce['Photo']; ?>" alt="Image de l'annonce" style="width:300px; height:300px;"><br>

            <label>Changer la photo:</label>
            <input type="file" name="photo"><br>

            <label>État:</label>
            <select name="etat" id="etat">
                <option value="1" <?php echo ($annonce['Etat'] == '1') ? 'selected' : ''; ?>>Actif</option>
                <option value="2" <?php echo ($annonce['Etat'] == '2') ? 'selected' : ''; ?>>Inactif</option>
            </select>

            <a href="vosAnnonces.php" style="display: inline-block; padding: 10px 20px; background-color: green; color: white; text-align: center; text-decoration: none; border-radius: 4px">Annuler</a>
            <button type="submit">Mettre à jour l'annonce</button>
        </form>
    </body>
</html>
<?php
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Nouvelle annonce</title>
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
    <body>
        <h1>Nouvelle annonce</h1>
        <?php 
        require_once 'Ressources.php';
        require_once 'navigation.php';

        session_start();
        if (!isset($_SESSION['session']) || $_SESSION['session'] != session_id()) {
            header('Location: ../connexion.php');
            exit();
        }

        require_once 'connect.php';
        $email = $_SESSION['Courriel'];
        $errors = [];

        //Fetch NoUtilisateur
        $sql = "SELECT NoUtilisateur FROM utilisateurs WHERE Courriel = :email";
        $stmt = $db->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $NoUtilisateur = $user['NoUtilisateur'];
        } else {
            $errors[] = "Utilisateur non trouvé.";
        }

        //Fetch categories
        $categories = [];
        $sql = "SELECT NoCategorie, Description FROM categories";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $categorie = '';
        $description_abregee = '';
        $description_complete = '';
        $prix = '';
        $photo = '';
        $etat = 'actif';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categorie = $_POST['categorie'] ?? '';
            $description_abregee = $_POST['description_abregee'] ?? '';
            $description_complete = $_POST['description_complete'] ?? '';
            $prix = $_POST['prix'] ?? '';
            $etat = $_POST['etat'] ?? 'actif';

            if (empty($categorie)) {
                $errors[] = "La catégorie est obligatoire.";
            }

            if (empty($description_abregee)) {
                $errors[] = "La description abrégée est obligatoire.";
            }

            if (empty($description_complete)) {
                $errors[] = "La description complète est obligatoire.";
            }

            if (empty($prix) || !is_numeric($prix)) {
                $errors[] = "Le prix est obligatoire et doit être un nombre.";
            }

            if (empty($_FILES['photo']['name'])) {
                $errors[] = "La photo est obligatoire.";
            }

            if (empty($errors)) {
                //Données générées auto
                $Parution = date('Y-m-d H:i:s');
                $MiseAJour = $Parution;

                //Téléversement
                $photo = '';
                if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
                    $upload_dir = 'images/';
                    $photo = $upload_dir . basename($_FILES['photo']['name']);
                    if (!(move_uploaded_file($_FILES['photo']['tmp_name'], $photo))) {
                        $errors[] = "Erreur lors du téléversement de la photo.";
                    }
                }

                if (empty($errors)) {
                    // Insérer données
                    $sql = "INSERT INTO annonces (NoUtilisateur, Parution, Categorie, DescriptionAbregee, DescriptionComplete, Prix, Photo, MiseAJour, Etat)
                            VALUES (:NoUtilisateur, :Parution, :Categorie, :DescriptionAbregee, :DescriptionComplete, :Prix, :Photo, :MiseAJour, :Etat)";
                    $stmt = $db->prepare($sql);
                    $stmt->execute([
                        ':NoUtilisateur' => $NoUtilisateur,
                        ':Parution' => $Parution,
                        ':Categorie' => $categorie,
                        ':DescriptionAbregee' => $description_abregee,
                        ':DescriptionComplete' => $description_complete,
                        ':Prix' => $prix,
                        ':Photo' => $photo,
                        ':MiseAJour' => $MiseAJour,
                        ':Etat' => $etat
                    ]);

                    if ($stmt) {
                        echo "<p>Annonce ajoutée avec succès!</p>";
                    } else {
                        echo "<p>Erreur: " . $db->errorInfo()[2] . "</p>";
                    }
                }
            }
        }
        ?>

        <form method="POST" action="" enctype="multipart/form-data">
            <label for="categorie">Catégorie</label>
            <select name="categorie" id="categorie">
                <option value="">Sélectionner une catégorie</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['NoCategorie']; ?>" <?= ($category['NoCategorie'] == $categorie) ? 'selected' : '' ?>><?php echo $category['Description']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="description_abregee">Description abrégée</label>
            <textarea name="description_abregee" id="description_abregee" rows="3"><?= htmlspecialchars($description_abregee) ?></textarea>

            <label for="description_complete">Description complète</label>
            <textarea name="description_complete" id="description_complete" rows="6"><?= htmlspecialchars($description_complete) ?></textarea>

            <label for="prix">Prix</label>
            <input type="text" name="prix" id="prix" value="<?= htmlspecialchars($prix) ?>">

            <label for="photo">Photo</label>
            <input type="file" name="photo" id="photo">

            <label for="etat">État</label>
            <select name="etat" id="etat">
                <option value="actif" <?= ($etat == 'actif') ? 'selected' : '' ?>>Actif</option>
                <option value="inactif" <?= ($etat == 'inactif') ? 'selected' : '' ?>>Inactif</option>
            </select>

            <?php if (!empty($errors)): ?>
            <div class="error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <button type="submit">Ajouter une annonce</button>
        </form>
    </body>
</html>

<?php
    require_once 'close.php';
?>

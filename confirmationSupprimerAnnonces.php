<?php
require_once ('navigationAdmin.php');
require_once ("Ressources.php");
require_once ('connect.php');

if (isset($_POST['btnSupprimerAnnonces'])) {
    $etat = 3;
    $sql = "DELETE FROM `annonces` WHERE `Etat`=:etat;";
    $query = $db->prepare($sql);
    $query->bindValue(':etat', $etat, PDO::PARAM_STR);
    $query->execute();
    header('Location: nettoyageBD.php');

} else if (isset($_POST['btnRetourListe'])) {
    header('Location: nettoyageBD.php');
}

require_once ('close.php');
?>

<br>
<div class="container">
    <div class="card text-white mb-3" style="background-color: #ff80ee">
        <h1 class="text-center">Êtes-vous sur de vouloir supprimer ces éléments?</h1>
    </div>
</div>
<br>
<form class="text-center" method="POST">
    <button id="btnSupprimerAnnonces" style="background-color: #ff6188" class="btn w-25" type="submit"
        name="btnSupprimerAnnonces">Supprimer</button>

    <button id="btnRetourListe" style="background-color: #b061ff" class="btn btn-primary w-25" type="submit"
        name="btnRetourListe">Retour à la liste</button>
</form>
</div>
<br><br>
<?php
require_once ("Footer.php");
?>
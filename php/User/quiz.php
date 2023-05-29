<?php require '../Integrations/headerEtudiant.php';

/* On inclut les fonctions de manipulation de la BDD */
require_once("../../bdd/fonctionsBDD.php");

connect();

/* Si l'utilisateur n'est pas capitaine, on redirige vers la page d'équipe */
if (isset($_SESSION['infoTeam'])) {
    if ($_SESSION['ID'] != $_SESSION['infoTeam']['capitaine']) {
        header('Location: equipe.php');
        exit();
    }
}
?>

<!-- MAIN CONTENT -->

<main>
    <div class="corps">

        <?php
            
        ?>
    </div>

</main>

<?php require '../Integrations/footer.php'; ?>
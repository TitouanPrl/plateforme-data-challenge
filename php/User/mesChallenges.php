<?php require '../Integrations/headerEtudiant.php';

/* On inclut les fonctions de manipulation de la BDD */
require_once("../../bdd/fonctionsBDD.php");

connect();
?>

<!-- MAIN CONTENT -->

<main>
    <div class="bordure"></div>

    <div class="corps">

        <?php
        /* Si l'utilisateur n'est pas inscrit à un challenge, on lui indique */
        if ($_SESSION['inscriptions'] == NULL) {
            header('Location: inscriptionChallenge.php');
            exit();
        }

        /* Sinon on affiche la liste des challenges auxquels il est inscrit */
        echo ('<!-- Affichage des challenges auxquels l\'utilisateur est inscrit -->
        <div id="mesChallenges">
            <h2 class="titreForm"> Mes Challenges </h2>
            ');
            foreach ($_SESSION['inscriptions'] as $current) {
                /* On récupère les infos liées à l'événement */
                $infos = getChallengeByID($conn, (int)$current["idEvenement"])[0];

                echo ('<a href="infoChallenge.php?challenge=' . $current["idEvenement"] . '">
                        <div class="challenge">
                            <span class="titre_challenge"> ' . $infos['libelle'] . ' </span>
                            <span class="descript_challenge"> ' . $infos['descrip'] . ' </span>
                        </div>
                        </a>');
            }

        echo('</div>');
        ?>
        
    </div>

</main>

<?php require '../Integrations/footer.php'; ?>
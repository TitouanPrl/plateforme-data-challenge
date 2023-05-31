<?php require '../Integrations/headerGestion.php';

/* On inclut les fonctions de manipulation de la BDD */
require_once("../../bdd/fonctionsBDD.php");

connect();
?>

<!-- MAIN CONTENT -->

<main>
    <div class="corps">

        <?php
        /* Si le gestionnaire n'est lié à aucun challenge, on lui indique */
        if ($_SESSION['inscriptions'] == NULL) {
            echo("<p id='notif'>Il semblerait que vous soyez un gestionnaire sans rien à gérer, pas terrible. 
            Contactez un administrateur pour régler ce problème.</p>");
        }

        /* Sinon on affiche la liste des challenges dont il est responsable */
        else {
            echo ('<!-- Affichage des challenges dont le gestionnaire est responsable -->
            <div id="mesChallenges">

            <h2 class="titreForm"> Mes Challenges </h2>');

            foreach ($_SESSION['inscriptions'] as $current) {
                /* On récupère les infos liées à l'événement */
                $infos = getChallengeByID($current);

                echo ('<a href="equipesEtProjets.php.php?challenge=' . $current . '">
                          <div class="challenge">
                              <span class="titre_challenge"> ' . $infos['libelle'] . ' </span>
                              <span class="descript_challenge"> ' . $infos['description'] . ' </span>
                          </div>
                        </a>');
            }

            echo('</div>');
        }
        ?>
        
    </div>

</main>

<?php require '../Integrations/footer.php'; ?>
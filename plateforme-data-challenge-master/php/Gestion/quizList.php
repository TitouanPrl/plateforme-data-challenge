<?php require '../Integrations/headerGestion.php';

/* On inclut les fonctions de manipulation de la BDD */
require_once("../../bdd/fonctionsBDD.php");

connect();

/* Liste de tous les data battle en cours */
$listEvents = getEvenementsByKind($conn, 'BATTLE');

?>

<!-- MAIN CONTENT -->

<main>
    <div class="corps">

        <?php

        /* ================================== *
        *            CREATION QUIZ            *
        * =================================== */

        /* On propose de créer un quiz */ ?>
        <div id="creer_quiz">
            <h2 class="titreForm"> Création d'un quiz </h2>

            <p class="titre_input"> Sujet pour lequel vous souhaitez créer un questionnaire </p>
            <input type="text" id="nom_challenge" list="liste_challenges">
            <datalist id="liste_challenges">

                <?php
                foreach ($listEvents as $current) {
                    echo ('<option value="' . $current['libelle'] . '>');
                }

                echo ('</datalist>');

            /* Dates */ ?>
            <p class="titre_input"> Date de début </p>
            <input type="date" id="date_deb">

            <p class="titre_input"> Date de fin </p>
            <input type="date" id="date_fin">

            <?php
            /* Questions */
            for ($i = 0; $i < 5; $i++) {
                echo ('<p class="titre_input"> Question ' . $i + 1 . '</p>
            <input type="text" id="question' . $i . '" required>');
            } ?>

            <button id="creer_quiz" type="button" onclick="createQuiz()">Créer le questionnaire </button>
        </div>


        <?php
        /* ================================== *
        *                 QUIZ                *
        * =================================== */ ?>
              
        <!-- Affichage des quiz créés -->
        <div id="listeQuiz">
            <h2 class="titreForm"> Liste des quiz </h2>

            <?php
            /* On initialise le compteur pour naviguer dans la classe */
            $i = 0;
            foreach ($listEvents as $currentEvent) {
                echo ('<div class="case_battle" id="' . $currentEvent['libelle'] . '"
                <h2 class="titreForm">' . $currentEvent['libelle'] . '</h2>
                <input type="hidden" id="idMax" value="' . getMaxIdQuestionnaire($conn) . '">');

                $j = 0;
                
                /* On récupère la liste des quiz associés */
                $listQuiz = getQuestionnairesOnSujet($conn, $currentEvent['idEvenement']);

                foreach ($listeQuiz as $currentQuiz) {
                    echo('<div classe="ligne_quiz>
                        <a href="detailsQuiz.php?quiz=' . $currentQuiz['idQuestionnaire'] . '">
                            <span class="nom_quiz" id="' . $j . '> Questionnaire ' . $j . '</span>
                        </a>
                        <img class="delete_button" src="../../img/croix.png" onclick="supprQuiz('. $j .', ' . $currentQuiz['idQuestionnaire'] . ')" alt="I am an image">
                    </div>');
                }

                echo('</div>');
                $i++;
            }

            ?>
        </div>
    </div>

</main>

<?php require '../Integrations/footer.php'; ?>
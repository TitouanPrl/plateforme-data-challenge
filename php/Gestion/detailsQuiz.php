<?php require '../Integrations/headerGestion.php';

/* On inclut les fonctions de manipulation de la BDD */
require_once("../../bdd/fonctionsBDD.php");

connect();

/* On vérifie que le questionnaire est rentré et qu'il existe */
if(!isset($_GET['quiz'])) {
    header('Location:.accueilGestion.php');
    exit();
}

/* Sinon on récupère le questionnaire sélectionné */
$idQuiz = $_GET['quiz'];

/* On passe par des var session pour stocker l'ID du challenge et celui du sujet afin de faciliter le traitement */
$quiz = getQuestionnairesByID($conn, $idQuiz);
$_SESSION['info_sujet'] = getSujetById($conn, $quiz['idSujet']);

/* On récupère les questions du questionnaire */
$listeQuestions = getQuestionsOnQuestionnaire($conn,$idQuiz); ?>

<!-- MAIN CONTENT -->

<main>
    <div class="corps">
        <h2 class="titreForm"> Questions </h2>

        <?php

            /* ================================== *
            *         AFFICHAGE REPONSES          *
            * =================================== */

            /* Compteur du nb de question */
            $numQuestion = 0;

            /* Parcours des questions */
            foreach($listeQuestions as $currentQuestion) {
                echo('<p class="titre_input"> Question '. $numQuestion .' </p>');

                /* On récupère les réponses des différentes équipes à la question */
                $listeRéponses = getReponsesOnQuestion($conn,$currentQuestion['idQuestion']);

                /* Compteur du nb de réponse */
                $numReponse = 0;

                foreach($listeRéponses as $currentReponse) {
                    /* On récupère le nom de l'équipe à qui appartient la réponse */
                    $currentEquipe = getEquipe($conn,$currentReponse['idEquipe']);

                    /* On affiche la réponse */
                    echo('<div class="ligne_equipe">
                    <p class="titre_input"> Réponse de : '. $currentEquipe['nom'] .' </p>
                    <p class="reponse">'. $currentReponse['contenu'] .'</p>
                    <input type="text class="note" placeholder="x/4">');                    
                    echo('</div>');

                    $numReponse++;
                }

                /* Nombre de réponses */
                echo('<input type="hidden" id="nbRep" value="' . $numReponse . '">');

                /* Bouton de soumission des notes */
                echo('<button id="submit_notes" type="button" onclick="submitNotes()">Envoyer les notes</button>');

                $numQuestion++;
            }
        ?>

    </div>
</main>


<?php require '../Integrations/footer.php'; ?>
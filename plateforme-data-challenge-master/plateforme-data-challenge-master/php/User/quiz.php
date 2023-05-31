<?php require '../Integrations/headerEtudiant.php';

/* On inclut les fonctions de manipulation de la BDD */
require_once("../../bdd/fonctionsBDD.php");

connect();

/* Si l'utilisateur n'est pas capitaine, on redirige vers la page d'équipe */
if (!isset($_SESSION['infoTeam']) || ($_SESSION['capitaine'] == false)) {
    header('Location: equipe.php');
    exit();
}

?>

<!-- MAIN CONTENT -->

<main>
    <div class="corps">

        <?php
            $quiz = getQuestionnairesOnSujet($conn, $_SESSION['infoTeam']['idEvenement']);

            /* Si aucun quiz n'est en ligne on l'indique */
            if (!isset($quiz)) {
                echo ('Il n\'y a pas de quiz disponible pour l\'instant !');
            }
            else {
                /* On récupère la date actuelle */
                $dateAct = new \DateTime();

                /* On cherche le questionnaire en cours à l'instant t */
                foreach ($quiz as $actQuiz) {
                    /* Une fois trouvé, on récupère ses questions */
                    if ((date_diff($actQuiz['dateD'], $dateAct) < 0) && (date_diff($actQuiz['dateF'], $dateAct) > 0)) {
                        $questionsQuiz = getQuestionsOnQuestionnaire($conn,$actQuiz['idQuestionnaire']);

                        echo('<!-- QUESTIONNAIRE -->
                        <div style="display:flex; justify-content:center;align-items:center;padding-top:70px;">
                          <div id="inscription">
                            <h2 class="titreForm"> Questionnaire </h2>
              
                            <form action="envoiReponses.php" method="POST">
                              <div style="display:flex; justify-content:center;align-items:center">');

                        $i = 0;

                        /* On affiche les questions et on permet d'y répondre */
                        foreach($questionsQuiz as $actQuestion) {
                            echo('<div class="question">
                            <span class="enonce">' . $actQuestion['contenu'] . '</span>
                            <input type="text" class="reponse" name="reponse' . $i . '">');

                            /* On passe l'id de la question en hidden */
                            echo('<input type="hidden" value="' . $actQuestion['idQuestion'] . '" name="id' . $i . '">
                            </div>');
                            
                            $i++;
                        }

                        /* On passe le nb de réponses en hidden */
                        echo('<input type ="hidden" value"' . $i . 'name="nbReponses">      
                                </div>
                                <input type="submit" class="boutonForm" value="Valider" style="align-self:center;">
                                </form>
                            </div>
                        </div>');
                    }
                }
                
            }
        ?>
    </div>

</main>

<?php require '../Integrations/footer.php'; ?>
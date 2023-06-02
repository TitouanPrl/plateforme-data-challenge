<?php require '../Integrations/headerGestion.php';

/* On inclut les fonctions de manipulation de la BDD */
require_once("../../bdd/fonctionsBDD.php");

connect();

/* Liste de tous les data battle en cours */
$listEvents = getEvenementsByKind($conn, 'BATTLE');
?>

<!-- MAIN CONTENT -->

    <div class="bordure"></div>
    <div class="corps" style="height:1350px;background-attachment: fixed;">
            <div class="back-button">
            <a href="accueilGestion.php" class="fleche"></a>
        </div>
        <main>

        <div id="deux">
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
                    echo ('<option value="' . $current['libelle'] . '">');
                }
                echo('</datalist>');?>

    <p class="titre_input"> Date de début </p>
    <input type="date" id="date_deb">

    <p class="titre_input"> Date de fin </p>
    <input type="date" id="date_fin">

    <?php
    /* Questions */
    for ($i = 0; $i < 5; $i++) {
        echo ('<p class="titre_input"> Question ' . $i . '</p>
    <input type="text" id="question'.$i.'" required>');
    } ?>

<button class="boutonForm" style="margin-left:25%;" type="button" onclick="createQuiz()">Créer le questionnaire </button>
    
        

    
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
                <h2 class="titreForm">' . $currentEvent['libelle'] . '</h2>');


                $j = 0;
                
                /* On récupère la liste des quiz associés */
                $listeQuiz = getQuestionnairesOnSujet($conn, (int)$currentEvent['idEvenement']);

                foreach ($listeQuiz as $currentQuiz) {
                    echo('<div classe="ligne_quiz">
                        <a href="detailsQuiz.php?quiz='.(int)$currentQuiz['idQuestionnaire']. '">
                            <span class="nom_quiz" id="' . $j . '"> Questionnaire ' . $j . '</span>
                        </a>
                        <img class="delete_button" src="../../img/croix.png" onclick="supprQuiz('. $j .', ' . $currentQuiz['idQuestionnaire'] . ')" alt="I am an image">
                    </div>');
                    $j++;
                }

                echo('</div>');
                $i++;
            }

            ?>
        </div>
        </div>
    </div>

</main>

<?php require '../Integrations/footer.php'; ?>
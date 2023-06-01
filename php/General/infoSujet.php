<?php require_once '../Integrations/headerVanilla.php'; 

/* On inclut les fonctions de manipulation de la BDD */
require_once("../../bdd/fonctionsBDD.php");

if (!connect()) {
    die('Erreur de connexion à la base de données');
}


/* On récupère l'ID du sujet sélectionné */
$idSujet = $_GET['sujet'];

/* On récupère le sujet associé à cet ID */
$sujet = getSujetByID($conn, $idSujet);

/* On récupère le podium associé au sujet */
$podium = getPodiumBySujet($conn, $idSujet);

/* On récupère les différentes équipes du podium */
/*$team1 = getEquipe($conn, $podium[0]['idE1']);
$team2 = getEquipe($conn, $podium[0]['idE2']);
$team3 = getEquipe($conn, $podium[0]['idE3']);
*/
$team1 = getEquipe($conn, 1);
$team2 = getEquipe($conn, 2);
$team3 = getEquipe($conn, 3);


/* On affiche la description du sujet */
echo('<!-- MAIN CONTENT -->
<div class="bordure"></div>

<div class="corps" style="height:auto;background-attachment: fixed;">
    <div class="back-button">
        <a href="listeChallenge.php" class="fleche"></a>
    </div>
    <main style="display:flex;flex-direction:column;align-items:center;padding-top:50px;">
        <h2 class="titreForm"> Description sur le sujet</h2>
        <div id="descrit_sujet">
            ' . $sujet[0]['descrip'] .
        '</div>
');

/* On affiche le podium du sujet */
echo ('<!-- CLASSEMENT -->
        <div id="podium">
            <p id="podiumTitre" >Équipes en tête de classement</p>
            <div id="classement">
                <span class="ligne_podium">' . $team2[0]['nom'] . '</span>
                <span class="ligne_podium">' . $team1[0]['nom'] . '</span>
                <span class="ligne_podium">' . $team3[0]['nom'] . '</span>
            </div>
        </div>
    </main>
</div>
');

require_once '../Integrations/footer.php';?>
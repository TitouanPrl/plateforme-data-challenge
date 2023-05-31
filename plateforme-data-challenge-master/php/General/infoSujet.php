<?php require_once '../Integrations/headerVanilla.php'; 

/* On inclut les fonctions de manipulation de la BDD */
require_once("../../bdd/fonctionsBDD.php");

connect();

/* On récupère l'ID du sujet sélectionné */
$idSujet = $_GET['sujet'];

/* On récupère le sujet associé à cet ID */
$sujet = getSujetByID($conn, $idSujet);

/* On récupère le podium associé au sujet */
$podium = getPodiumBySujet($conn, $idSujet);

/* On récupère les différentes équipes du podium */
$team1 = getEquipe($conn, $podium['idE1']);
$team2 = getEquipe($conn, $podium['idE2']);
$team3 = getEquipe($conn, $podium['idE3']);

/* On affiche la description du sujet */
echo('<!-- MAIN CONTENT -->

<main>
<h3> Informations sur le sujet </h3>
<div id="descrit_sujet">
    ' . $sujet['descrip'] .
'</div>');

/* On affiche le podium du sujet */
echo ('<!-- CLASSEMENT -->
        <div id="classement">
            <span class="ligne_podium">' . $team1['nom'] . '</span>
            <span class="ligne_podium">' . $team2['nom'] . '</span>
            <span class="ligne_podium">' . $team3['nom'] . '</span>
        </div>
    </main>');

require_once '../Integrations/footer.php';
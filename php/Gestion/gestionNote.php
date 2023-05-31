<?php

session_start();

/* On vérifie qu'un mdp a bien été rentré (évite qu'on dodge la page de connexion) */
if (!isset($_SESSION["login"]) || (($_SESSION['infoUser']['fonction'] != "GESTION"))) {
    header('Location:../Connexion/connexionInscription.php?message=1');
    exit();
}

/* On inclut les fonctions de manipulation de la BDD */
require_once("../../bdd/fonctionsBDD.php");

connect();


/* ================================== *
*         LECTURE DES DONNEES         *
* =================================== */

/* On récupère les variables envoyées si elles sont renseignées */

/* Tableau des réponses */
if(isset($_POST["tabReponses"])) {
    $tabReponses = $_POST["tabReponses"];
}
else {
    $tabReponses = NULL;
}

/* Tableau des notes */
if(isset($_POST["tabNotes"])) {
    $tabNotes = $_POST["tabNotes"];
}
else {
    $tabNotes = NULL;
}

/* ID du challenge */
$idEvenement = $_SESSION['info_sujet']['idEvenement'];



/* ID du sujet  */
$idSujet = $_SESSION['info_sujet']['idSujet'];




/* ================================== *
*            ENVOI DES NOTES          *
* =================================== */

for ($i=0; $i < count($tabReponses); $i++) { 
    setNote($conn, $tabReponses[$i], $tabNotes[$i]);
}


/* ================================== *
*            UPDATE PODIUM            *
* =================================== */

/* On récupère les équipes participant à ce questionnaire */
$equipesInscrites = getEquipesByEvenement($conn,$idEvenement);

/* On crée le classement des équipes */
$classement[] = array();

/* On effectue le classement des équipes */
foreach ($equipesInscrites as $currentTeam) {
    /* On récupère l'ID de l'équipe */
    $idEquipe = $currentTeam['idEquipe'];

    /* On ajoute le couple [id, note] au classement */
    array_push($classement, [$idEquipe, getNbPoints($conn, $idEquipe)]);
}

/* On trie le tableau par ordre croissant des notes */
asort($classement);

/* On récupère le tableau des clés du classement */
$tabCle = array_keys($classement);

/* On récupère les 3 premières */
$top1 = $tabCle[0];
$top2 = $tabCle[1];
$top3 = $tabCle[2];

/* Et on update le podium dans la BDD */
modifyPodium($conn, $idSujet, $classement[$top1], $classement[$top2], $classement[$top3]);


?>
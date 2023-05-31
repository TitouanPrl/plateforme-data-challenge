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

/* ajout/suppression */
if(isset($_POST["type"])) {
    $type = $_POST["type"];
}
else {
    $type = NULL;
}

/* ID du questionnaire */
if(isset($_POST["idQuestionnaire"])) {
    $idQuestionnaire = $_POST["idQuestionnaire"];
}
else {
    $idQuestionnaire = NULL;
}

/* ID du challenge auquel le questionnaire est associé */
if(isset($_POST["IDchallenge"])) {
    $IDchallenge = $_POST["IDchallenge"];
}
else {
    $IDchallenge = NULL;
}

/* Date de début */
if(isset($_POST["debut"])) {
    $debut = $_POST['debut'];
}
else {
    $debut = NULL;
}

/* Date de fin */
if(isset($_POST["fin"])) {
    $fin = $_POST['fin'];
}
else {
    $fin = NULL;
}

/* Les 5 questions */
if(isset($_POST["question0"])) {
    $question0 = $_POST['question0'];
}
else {
    $question0 = NULL;
}

if(isset($_POST["question1"])) {
    $question1 = $_POST['question1'];
}
else {
    $question1 = NULL;
}

if(isset($_POST["question2"])) {
    $question2 = $_POST['question2'];
}
else {
    $question2 = NULL;
}

if(isset($_POST["question3"])) {
    $question3 = $_POST['question3'];
}
else {
    $question3 = NULL;
}

if(isset($_POST["question4"])) {
    $question4 = $_POST['question4'];
}
else {
    $question4 = NULL;
}

/* ID de la question */
if(isset($_POST["newID"])) {
    $newID = $_POST['newID'];
}
else {
    $newID = NULL;
}


/* ================================== *
*        CREATION QUESTIONNAIRE       *
* =================================== */

if ($type == 'ajout') {
    /* Création du questionnaire */
    createQuestionnaire($conn,$idQuestionnaire,$debut,$fin);

    /* Ajout des questions */
    addQuestion($conn,$idQuestionnaire,$question0);
    addQuestion($conn,$idQuestionnaire,$question1);
    addQuestion($conn,$idQuestionnaire,$question2);
    addQuestion($conn,$idQuestionnaire,$question3);
    addQuestion($conn,$idQuestionnaire,$question4);

    /* Envoie du lien du questionnaire à tous les capitaines des équipes liées */
    // NEED FCT QUI ENVOI CA VIA LA MESSAGERIE
}


/* ================================== *
*      SUPRESSION QUESTIONNAIRE       *
* =================================== */

if ($type == 'suppr') {
    /* Suppression du questionnaire */
    deleteQuestionnaire($conn,$idQuestionnaire);
}

?>
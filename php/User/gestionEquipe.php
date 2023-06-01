<?php

session_start();

/* On vérifie qu'un mdp a bien été rentré (évite qu'on dodge la page de connexion) */
if (!isset($_SESSION["login"])) {
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
if(isset($_GET["val1"])) {
    $nom_prenom = $_GET["val1"];
}
else {
    $nom_prenom = NULL;
}

if(isset($_GET["idNewMember2"])) {
    $idNewMember2 = (int)$_GET["idNewMember2"];
}
else {
    $idNewMember2 = NULL;
}

if(isset($_GET["idNewMember3"])) {
    $idNewMember3 = (int)$_GET["idNewMember3"];
}
else {
    $idNewMember3 = NULL;
}

if(isset($_GET["type"])) {
    $type = $_GET["type"];
}
else {
    $type = NULL;
}

if(isset($_GET["idUser"])) {
    $idNewMember = (int)$_GET["idUser"];
    $idTeamToAdd = getIDEquipeByIDCapitaine($conn, $_SESSION['infoUser']['idUser'])[0];
    $teamToAdd = getEquipe($conn,$idTeamToAdd)[0];
    $infosNewMember = getUtilisateurById($conn,$idNewMember)[0];
    $liste_inscrits = getInscrits($conn, $teamToAdd['idEvenement']);
    $inscrit = false;

    /* on vérifie que le membre à ajouter est bien inscrit au projet */
    foreach($liste_inscrits as $current) {
        if($idUser == $current) {
            $inscrit = true;
        }
    }
}

/* On récupère le nom de l'équipe */
if(isset($_GET["nomTeam"])) {
    $nomTeam = $_GET['nomTeam'];
}
else {
    $nomTeam = NULL;
}

/* On récupère l'ID de l'évènement auquel l'équipe s'inscrit */
if(isset($_GET["challenge"])) {
    $IDchallenge = (int)getIDByNomEvenement($conn, $_GET['challenge']);
}
else {
    $IDchallenge = NULL;
}

/* On écrit l'id du capitaine de l'équipe */
$idCap = (int)$_SESSION['infoUser']['idUser'];



/* ================================== *
*            AJOUT CAPITAINE          *
* =================================== */

echo("ENTREE");
var_dump($_SESSION['infoUser']['idEquipe']);
var_dump($idCap);

var_dump((int)getIDEquipeByIDCapitaine($conn, $idCap)[0]["idEquipe"]);

/* On vérifie que le capitaine a une équipe, et que le membre n'en a pas mais qu'il est bien inscrit au challenge */
if (($type == 'ajout') && (!isset($_SESSION['infoUser']['idEquipe']))) {
    createEquipe($conn, $IDchallenge, $nomTeam, $idCap);
    $idEquipe = (int)getIDEquipeByIDCapitaine($conn, $idCap)[0]["idEquipe"];
    $_SESSION['infoUser']['idEquipe'] = $idEquipe;
    addMembreEquipe($conn, $idEquipe, $idCap);
    addMembreEquipe($conn,$idEquipe,$idNewMember2);
    addMembreEquipe($conn,$idEquipe,$idNewMember3);

    /* On met à jour la var des infos d'équipe */
    $_SESSION['infoTeam'] = getEquipe($conn,$_SESSION['infoUser']['idEquipe'])[0];
    $_SESSION['teamMembers'] = getEquipeMembers($conn,$_SESSION['infoUser']['idEquipe']);

    /* Et on définit le user comme capitaine */
    $_SESSION['capitaine'] = true;

    /* On recharge la page pour actualiser les fonctionnalités d'ajout et de suppression de membres */
    header('Location: equipe.php');
    exit();
}


/* ================================== *
*             AJOUT MEMBRE            *
* =================================== */

/* On vérifie que le capitaine a une équipe, et que le membre n'en a pas mais qu'il est bien inscrit au challenge */
else if (($type == 'ajout') && (isset($_SESSION['infoUser']['idEquipe'])) && (!isset($infosNewMember['idEquipe'])) && $inscrit) {
    echo("ENTREE AJOUT");
    $idEquipe = (int)getIDEquipeByIDCapitaine($conn, $idCap)[0];
    addMembreEquipe($conn,$idEquipe,$idNewMember);

    /* On met à jour les membres de l'équipe en session */
    $_SESSION['teamMembers'] = getEquipeMembers($conn,$_SESSION['infoUser']['idEquipe']);
}


/* ================================== *
*          SUPPRESSION MEMBRE         *
* =================================== */

/* On vérifie que le capitaine a une équipe, que le membre en a une, et qu'il est bien inscrit au challenge */
else if (($type == 'suppr') && (isset($_SESSION['infoUser']['idEquipe'])) && (isset($infosNewMember['idEquipe'])) && $inscrit) {
    echo("ENTREE SUPPRESSION");
    deleteMembreEquipe($conn,$idNewMember);

    /* On met à jour les membres de l'équipe en session */
    $_SESSION['teamMembers'] = getEquipeMembers($conn,$_SESSION['infoUser']['idEquipe']);
}

?>
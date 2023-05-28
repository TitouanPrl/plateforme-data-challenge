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

/* On récupère les variables envoyées si elles sont renseignées */
if(isset($_POST["val1"])) {
    $nom_prenom = $_POST["val1"];
}

if(isset($_POST["type"])) {
    $type = $_POST["type"];
}

if(isset($_POST["idUser"])) {
    $idNewMember = $_POST["idUser"];
    $infosNewMember = getUtilisateurById($conn,$idNewMember);
    $liste_inscrits = getInscrits($idEvenement);
    $inscrit = false;

    /* on vérifie que le membre à ajouter est bien inscrit au projet */
    foreach($liste_inscrits as $current) {
        if($idUser == $current) {
            $inscrit = true;
        }
    }
}

/* On récupère le nom de l'équipe */
if(isset($_POST["nomTeam"])) {
    $nomTeam = $_POST['nomTeam'];
}

/* On récupère l'ID de l'évènement auquel l'équipe s'inscrit */
if(isset($_POST["challenge"])) {
    $IDchallenge = getIDByNomEvenement($conn, $_POST['challenge']);
}

/* On écrit l'id du capitaine de l'équipe */
$idCap = $_SESSION['infoUser']['idUser'];


/* ==== AJOUT D'UN CAPITAINE ==== */
if (($type == 'ajout') && (!isset($_SESSION['infoUser']['idEquipe']))) {
    createEquipe($conn, $IDchallenge, $nomTeam, $idCap);
    $idEquipe = getIDEquipeByCapitaineNom($conn, $idCap, $nomTeam);
    $_SESSION['infoUser']['idEquipe'] = $idEquipe;
    addMembreEquipe($conn, $idEquipe, $idCap);
}

/* ==== AJOUT D'UN MEMBRE ==== */
/* On vérifie que le capitaine a une équipe, que le membre n'en a pas, mais qu'il est bien inscrit au challenge */
else if (($type == 'ajout') && (isset($_SESSION['infoUser']['idEquipe'])) && (!isset($infosNewMember['idEquipe'])) && $inscrit) {
    $idEquipe = getIDEquipeByCapitaineNom($conn, $idCap, $nomTeam);
    addMembreEquipe($conn,$idEquipe,$idNewMember);
}

/* ==== SUPPRESSION D'UN MEMBRE ==== */
else if (($type == 'suppr') && (isset($_SESSION['infoUser']['idEquipe'])) && (isset($infosNewMember['idEquipe'])) && $inscrit) {
    deleteMembreEquipe($conn,$idNewMember);
}

?>
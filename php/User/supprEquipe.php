<?php
session_start();

/* On inclut les fonctions de manipulation de la BDD */
require_once("../../bdd/fonctionsBDD.php");

/* On vérifie qu'un mdp a bien été rentré (évite qu'on dodge la page de connexion) */
if (!isset($_SESSION["login"])) {
    header('Location:../Connexion/connexionInscription.php?message=1');
    exit();
}

connect();

/* On supprime l'équipe */
deleteEquipe($conn,$_SESSION['infoTeam']['idEquipe']);

/* On met à jour les var de session */
$_SESSION['teamMembers'] = NULL;
$_SESSION['infoTeam'] = NULL;
$_SESSION['capitaine'] = NULL;

/* Actualisation de la page équipe */
header('Location:equipe.php');

?>
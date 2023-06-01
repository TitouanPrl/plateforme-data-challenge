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

/* On récupère le challenge sélectionné */
$idEvent = $_GET['challenge'];

/* On vérifie que l'utilisateur n'est pas encore inscrit à ce challenge */
$myEvents = getEventInscrit($conn, $_SESSION['ID']);
$inscrit = false;

foreach($myEvents as $current) {
    if($idEvent == $current["idEvenement"]) {
        $inscrit = true;
    }
}

/* Inscription de l'étudiant au challenge dans la BDD */
if(!$inscrit) {
    inscription($conn, $_SESSION['ID'],$idEvent);

    /* On met à jour la var de session */
    $_SESSION['inscriptions'] = getEventInscrit($conn, $_SESSION['ID']);
}

/* Redirection vers la page détaillant les infos du challenge */
header('Location:../User/infoChallenge.php?challenge=' . $idEvent);

?>
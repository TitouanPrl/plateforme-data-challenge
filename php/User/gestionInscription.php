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

/* Inscription de l'étudiant au challenge dans la BDD */
inscription($conn, $_SESSION['ID'],$idEvent);

/* Redirection vers la page détaillant les infos du challenge */
header('Location:../User/infoChallenge.php?challenge=' . $idEvent);

?>
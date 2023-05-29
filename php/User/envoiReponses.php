<?php
session_start();

/* On inclut les fonctions de manipulation de la BDD */
require_once("../../bdd/fonctionsBDD.php");

/* On vérifie qu'un mdp a bien été rentré (évite qu'on dodge la page de connexion) */
if (!isset($_SESSION["login"])){
  header('Location:connexionInscription.php?message=1');
  exit();
}

/* Si l'utilisateur n'est pas capitaine, on redirige vers la page d'équipe */
if (!isset($_SESSION['infoTeam']) || ($_SESSION['capitaine'] == false)) {
    header('Location: equipe.php');
    exit();
}

/* Sinon on récupère le nombre de réponses */
$nbReponses = (int) ($_POST['nbReponses']) + 1;

/* Et on ajoute les réponses dans la BDD */
for ($i = 0; $i < $nbReponses; $i++) {
    addRéponse($conn, $_POST['id' . $i], $_SESSION['infoTeam']['idEquipe'], $_POST['reponse' . $i]);
}

/* On redirige vers l'accueil */
header('Location: accueilUser.php'); 

exit();

?>

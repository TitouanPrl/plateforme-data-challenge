<?php require '../Integrations/headerEtudiant.php';

/* On inclut les fonctions de manipulation de la BDD */
require_once("../../bdd/fonctionsBDD.php");

connect();

/* On récupère le challenge auquel l'équipe participe */
$idEvent = $_SESSION['infoTeam']['idEvent'];

/* On récupère les sujets associés au challenge */
$liste_inscrits = getInscrits($idEvent);

echo('<!-- MAIN CONTENT -->

<main>');

/* Affichage des challenges disponibles */
foreach ($liste_inscrits as $current) {
    echo ('  <!-- INSCRITS--> ');
        if (getUtilisateurById($conn, $current)['idEquipe'] != $_SESSION['infoTeam']['idEquipe']) {
        echo('<span class="participant"> ' . getUtilisateurById($conn, $current)['prenom'] . ' ' . getUtilisateurById($conn, $current)['nom'] . '</span>');
        }
}
echo('</main>');

require '../Integrations/footer.php'; ?>
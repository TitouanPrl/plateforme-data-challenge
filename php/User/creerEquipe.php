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

/* Champ de saisie pour ajouter un membre à l'équipe */
echo('<input type="text" id="partipant" name="login" required>
<button type="button" onclick="addMemberTeam();">Ajouter à l\'équipe</button>');


/* Affichage des inscrits disponibles */
//foreach ($liste_inscrits as $current) {
//    echo ('  <!-- INSCRITS--> ');
//        if (getUtilisateurById($conn, $current)['idEquipe'] == NULL) {
//        echo('<span class="participant" onclick="updTeam()"> ' . getUtilisateurById($conn, $current)['prenom'] . ' ' . getUtilisateurById($conn, $current)['nom'] . '</span>');
//        }
//}
echo('</main>');

require '../Integrations/footer.php'; ?>
<?php require '../Integrations/headerGestion.php';

/* On inclut les fonctions de manipulation de la BDD */
require_once("../../bdd/fonctionsBDD.php");

connect();

/* On récupère le challenge sélectionné */
$idEvent = $_GET['challenge'];

/* On récupère les sujets associés au challenge dans la BDD */
$tabEquipes = getEquipesByEvenement($conn,$idEvent);

echo('<!-- MAIN CONTENT -->

<main>
<div id="equipes">

        <h2 class="titreForm"> Equipes inscrites </h2>');

/* Affichage des équipes inscrites au challenge */
foreach ($tabEquipes as $current) {

    echo ('  <!-- EQUIPES -->
        <span class="ligne_equipe">' . $current['nom'] . '</span>');
}

    echo('</div>
    </main>');

require '../Integrations/footer.php'; ?>
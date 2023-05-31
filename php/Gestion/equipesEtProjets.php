<?php require '../Integrations/headerGestion.php';

/* On inclut les fonctions de manipulation de la BDD */
require_once("../../bdd/fonctionsBDD.php");

connect();

/* On récupère le challenge sélectionné */
$idEvent = $_GET['challenge'];

/* On récupère les équipes associées au challenge dans la BDD */
$tabEquipes = getEquipesByEvenement($conn,$idEvent);

/* On récupère les sujets associés au challenge dans la BDD */
$tabSujets = getSujetByEvenement($conn, $idEvent);


/* ================================== *
*               EQUIPES               *
* =================================== */

echo('<!-- MAIN CONTENT -->

<main>
<div id="equipes">

        <h2 class="titreForm"> Equipes inscrites </h2>');

/* Affichage des équipes inscrites au challenge */
foreach ($tabEquipes as $current) {

    echo ('  <!-- EQUIPES -->
        <span class="ligne_equipe">' . $current['nom'] . '</span>');
}

echo('</div>');;


/* ================================== *
*                SUJETS               *
* =================================== */

echo('<div id="sujets">

        <h2 class="titreForm"> Projets associés </h2>');

/* Affichage des sujets associés au challenge */
foreach ($tabSujets as $current) {
    echo ('  <!-- SUJETS-->
        <a href="ressourcesSujet.php?sujet=' . $current['idSujet'] . '
             <div class="sujets">
                 <h3>' . $current['libelle'] . '</h3>
             </div>
        </a>');
}

echo('</div>');

echo('</main>');

require '../Integrations/footer.php'; ?>
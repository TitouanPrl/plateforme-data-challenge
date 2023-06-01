<?php require '../Integrations/headerEtudiant.php';

/* On inclut les fonctions de manipulation de la BDD */
require_once("../../bdd/fonctionsBDD.php");

connect();

/* On récupère le challenge sélectionné */
$idEvent = $_GET['challenge'];

/* On récupère les sujets associés au challenge dans la BDD */
$tabSujets = getSujetByEvenement($conn, $idEvent);

echo('<!-- MAIN CONTENT -->

<main>
<div class="bordure"></div>

<div id="sujets">

<h2 class="titreForm"> Sujets </h2>');

/* Affichage des sujets disponibles */
foreach ($tabSujets as $current) {
    echo ('  <!-- SUJETS-->
        <a href="ressourcesSujet.php?sujet=' . $current['idSujet'] . '">
             <div class="sujets">
                 <h3>' . $current['libelle'] . '</h3>
             </div>
        </a>');
}

echo('</div>');

echo('</main>');

require '../Integrations/footer.php'; ?>
<?php require_once '../Integrations/headerVanilla.php'; 

/* On inclut les fonctions de manipulation de la BDD */
require_once("../../bdd/fonctionsBDD.php");

connect();

/* On récupère le challenge sélectionné */
$idEvent = $_GET['challenge'];

/* On récupère les sujets associés au challenge */
$tabSujets = getSujetByEvenement($conn, $idEvent);

echo('<!-- MAIN CONTENT -->

<main>

    <div id="mesChallenges">
        <h2 class="titreForm"> Sujets </h2>');

/* Affichage des challenges disponibles */
foreach ($tabSujets as $current) {

    echo ('  <!-- SUJETS-->
        <a href="infoSujet.php?sujet=' . $current['idSujet'] . '
             <div class="sujets">
                 <h3>' . $current['libelle'] . '</h3>
             </div>
        </a>');
}

    echo('</main>');

require_once '../Integrations/footer.php';

<?php require_once '../Integrations/headerVanilla.php'; 

/* On inclut les fonctions de manipulation de la BDD */
require_once("../../bdd/fonctionsBDD.php");

connect();

/* On récupère le challenge sélectionné */
$idEvent = $_GET['challenge'];

/* On récupère les sujets associés au challenge */
$tabSujets = getSujetByEvenement($conn, $idEvent);

echo('<!-- MAIN CONTENT -->
<div class="bordure"></div>

<div class="corps" style="height:auto;background-attachment: fixed;">
    <div class="back-button">
        <a href="listeChallenge.php" class="fleche"></a>
    </div>
    <main style="display:flex;flex-direction:column;align-items:center;padding-top:50px;">
    <h2 class="titreForm"> Sujets disponibles pour le Challenge</h2>
    <div id="mesSujets">
');

/* Affichage des challenges disponibles */
foreach ($tabSujets as $current) {

    echo ('  <!-- SUJETS-->
        <a href="infoSujet.php?sujet=' . $current['idSujet'] . '">
            <div class="sujets">
                <img class="imgSujet" src="' . $current['img'] . '" >
                <span class="libelle_challenge"> ' . $current['libelle'] . ' </span>
                <span class="descript_challenge"> ' . $current['descrip'] . ' </span>
                <p> Contact : </p>
                <span class="telGerant_challenge"> ' . $current['telGerant'] . ' </span>
                <span class="emailGerant_challenge"> ' . $current['emailGerant'] . ' </span>
            </div>
        </a>');
}

    echo('</div>
    </main>');

require_once '../Integrations/footer.php';

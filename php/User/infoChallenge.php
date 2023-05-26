<?php require '../Integrations/headerEtudiant.php';

/* On inclut les fonctions de manipulation de la BDD */
require_once("../../bdd/fonctionsBDD.php");

connect();

/* On récupère le challenge sélectionné */
$idEvent = $_GET['challenge'];

/* On récupère les sujets associés au challenge */
$tabSujets = getSujetByEvenement($conn, $idEvent);

echo('<!-- MAIN CONTENT -->

<main>');

/* Affichage des challenges disponibles */
foreach ($tabSujets as $current) {

    echo ('  <!-- SUJETS-->
        <a href="ressourcesSujet.php?sujet=' . $current['idSujet'] . '
             <div class="sujets">
                 <h3>' . $current['libelle'] . '</h3>
             </div>
        </a>');
}

    echo('</main>');

require '../Integrations/footer.php'; ?>
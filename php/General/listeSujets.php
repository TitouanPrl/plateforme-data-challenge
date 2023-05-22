<?php require_once '../Integrations/headerVanilla.php'; 

connect();

/* On récupère le challenge sélectionné */
$idEvent = $_GET['challenge'];

/* On récupère les sujets associés au challenge */
$tabSujets = getSujetByEvenement($idEvent);

echo('<!-- MAIN CONTENT -->

<main>');

/* Affichage des challenges disponibles */
foreach ($tabSujets as $current) {

    echo ('  <!-- SUJETS-->
        <a href="infoSujet.php?sujet=' . $current['idSujet'] . '
             <div id="sujets">
                 <h3>' . $current['libelle'] . '</h3>
             </div>
        </a>
             <!-- CLASSEMENT -->
             <div id="classement">');
}

    echo('
</main>');

require_once '../Integrations/footer.php';

<?php require_once '../Integrations/headerVanilla.php'; 

echo('<!-- MAIN CONTENT -->

<div class="bordure"></div>

<main>

    <div id="mesChallenges">
        <h2 class="titreForm"> Challenges </h2>');

/* Affichage des challenges disponibles */
foreach ($_SESSION['Evenements'] as $current) {

    echo ('<a href="listeSujets.php?challenge=' . $current['idEvenement'] . '">
            <div class="challenge">
                <span class="titre_challenge"> ' . $current['libelle'] . ' </span>
                <span class="descript_challenge"> ' . $current['descrip'] . ' </span>
            </div>
          </a>');
}

echo('</main>');

require_once '../Integrations/footer.php'; ?>
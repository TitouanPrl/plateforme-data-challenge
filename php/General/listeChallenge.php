<?php require_once '../Integrations/headerVanilla.php'; 

echo('<!-- MAIN CONTENT -->

<main>');

/* Affichage des challenges disponibles */
foreach ($_SESSION["data"]['Evenement'] as $current) {

    echo ('<a href="listeSujets.php?challenge=' . $current['idEvenement'] . '">
            <div class="challenge">
                <span class="titre_challenge"> ' . $current['libelle'] . ' </span>
                <span class="descript_challenge"> ' . $current['description'] . ' </span>
            </div>
          </a>');
}

echo('</main>');

require_once '../Integrations/footer.php'; ?>
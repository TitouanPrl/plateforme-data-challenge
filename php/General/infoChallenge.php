<?php require_once '../Integrations/headerVanilla.php'; 

echo('<!-- MAIN CONTENT -->

<main>');

/* Affichage des challenges disponibles */
foreach ($_SESSION["data"]['Evenement'] as $current) {

    echo ('<div class="challenge">
                <span class="titre_challenge"> ' . $current['libelle'] . ' </span>
                <span class="descript_challenge"> ' . $current['description'] . ' </span>
            </div>');
}

    echo('<!-- CLASSEMENT -->
    <div id="classement">
        <h3>Classement</h3>
        <!-- need un foreach qui met le podium de chaque  -->
    </div>
    
    <!-- SUJETS-->
    <div id="sujets">
        <h3>Sujets</h3>
        <!-- CLASSEMENT -->
    </div>
</main>');

require_once '../Integrations/footer.php'; ?>
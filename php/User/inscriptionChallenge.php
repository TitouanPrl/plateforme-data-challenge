<?php require '../Integrations/header.php';

/* Affichage de l'en-tête*/
echo ('<!-- MAIN CONTENT -->
<main>
    <h3 id="liste_event"> Choisissez le challenge auquel vous souhaitez vous inscire <h3>');


    /* Affichage des challenges disponibles */
foreach ($_SESSION["data"]['Evenement'] as $current) {

    echo ('<div class="challenge">
                <span class="titre_challenge"> ' . $current['libelle'] . ' </span>
                <span class="descript_challenge"> ' . $current['description'] . ' </span>
                </div>');
}
    
        
echo('</main>');

echo ('<!-- FOOTER -->');

require '../Integrations/footer.php'; ?>
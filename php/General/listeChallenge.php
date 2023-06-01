<?php require_once '../Integrations/headerVanilla.php'; 


echo ('<!-- MAIN CONTENT -->
<div class="bordure"></div>

<div class="corps" style="height:auto;background-attachment: fixed;">
    <main style="display:flex;flex-direction:column;align-items:center;padding-top:50px;">
        <h2 id="liste_event"> Challenges et Battles en cours et à venir </h2>
        <div style="display:flex; flex-wrap:wrap;justify-content:center;margin-top:50px;width:70%;">
');

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
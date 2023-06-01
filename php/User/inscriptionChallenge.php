<?php require '../Integrations/headerEtudiant.php';

/* Affichage de l'en-tête*/
echo ('<!-- MAIN CONTENT -->
<main>
    <div class="bordure"></div>
    
    <h3 id="liste_event"> Choisissez le challenge auquel vous souhaitez vous inscrire </h3>');


/* Affichage des challenges disponibles */
foreach ($_SESSION['Evenements'] as $current) {

    echo ('<a href="gestionInscription.php?challenge=' . $current['idEvenement'] . '">
            <div class="challenge">
                <span class="titre_challenge"> ' . $current['libelle'] . ' </span>
                <span class="descript_challenge"> ' . $current['descrip'] . ' </span>
            </div>
          </a>');
}
    
        
echo('</main>');

echo ('<!-- FOOTER -->');

require '../Integrations/footer.php'; ?>
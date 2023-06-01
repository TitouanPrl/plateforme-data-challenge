<?php require '../Integrations/headerEtudiant.php';


/* Affichage de l'en-tête*/
echo ('<!-- MAIN CONTENT -->
<div class="bordure"></div>
<div class="corps" style="height:auto;background-attachment: fixed;">
<main style="display:flex;flex-direction:column;align-items:center;padding-top:50px;">
    <h3 id="liste_event"> Choisissez le challenge auquel vous souhaitez vous inscrire </h3>
    <div style="display:flex; flex-wrap:wrap;">
');
/* Affichage des challenges disponibles */
foreach ($_SESSION['Evenements'] as $current) {
    echo ('
        <a href="gestionInscription.php?challenge=' . $current['idEvenement'] . '">
            <div class="challenge">
                <span class="titre_challenge"> ' . $current['libelle'] . ' </span>
                <span class="descript_challenge"> ' . $current['descrip'] . ' </span>
            </div>
        </a>'
        );
}
    
        
echo('
</div>
</main>
</div>');

echo ('<!-- FOOTER -->');

require '../Integrations/footer.php'; ?>
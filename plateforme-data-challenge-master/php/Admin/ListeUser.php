<?php require_once '../Integrations/headerVanilla.php'; 

/* On inclut les fonctions de manipulation de la BDD */
require_once("../../bdd/fonctionsBDD.php");

connect();

/* On récupère l'Utilisateur sélectionné */
$idUser = $_GET['user'];

/* On récupère les informations de l'utilisateur */
$tabUser = getUtilisateurById($conn,$idUser);

echo('<!-- MAIN CONTENT -->

<main>');

/* Affichage des utilisateurs  */
foreach ($tabUser as $current) {

    echo ('  <!-- USER-->
        <a href="infoUser.php?sujet=' . $current['idUser'] . '
             <div id="sujets">
                 <h3>' . $current['nom'] . $current['prenom'] .'</h3>
             </div>
        </a>');
}

    echo('</main>');

require_once '../Integrations/footer.php';
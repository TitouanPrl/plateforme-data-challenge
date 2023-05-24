<?php require_once '../Integrations/headerVanilla.php'; 

/* On inclut les fonctions de manipulation de la BDD */
require_once("../../bdd/fonctionsBDD.php");

connect();

/* On récupère l'ID de l'utilisateur sélectionné */
$idUser = $_GET['idUser'];

/* On récupère l'utilisateur associé à cet ID */
$User = getAllUtilisateurs($conn);

/* On affiche le numéro de l'utilisateur */
echo('<!-- MAIN CONTENT -->

<main>
<h3> Utilisateurs </h3>
<div id="Num_user">
    ' . $idUser .
'</div>');

/* On affiche le nom et le prénom de l'utilisateur */
echo ('<!-- CLASSEMENT -->
        <div id="liste">
            <span class="ligne_user">' . $User['nom'] . '</span>
            <span class="ligne_user">' . $User['Prenom'] . '</span>
        </div>
    </main>');

require_once '../Integrations/footer.php';
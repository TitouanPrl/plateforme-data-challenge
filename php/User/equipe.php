<?php require '../Integrations/headerEtudiant.php';

/* On inclut les fonctions de manipulation de la BDD */
require_once("../../bdd/fonctionsBDD.php");

connect();
?>

<!-- MAIN CONTENT -->

<main>
    <div class="bordure">
    </div>
    <div class="corps">

        <?php
        /* Si l'utilisateur n'a pas d'équipe, on affiche les champs et le bouton lui proposant d'en créer une */
        if (!isset($_SESSION['infoUser']['idEquipe'])) {
            echo ('<div id="creer_equipe">
            <input type="text" id="nom_equipe" placeholder="Nom que vous souhaitez donner à votre équipe">

            <input type="text" id="nom_challenge" list="liste_challenges" placeholder="Challenge auquel vous souhaitez inscrire votre équipe">
            <datalist id="liste_challenges">');

            /* Liste de tous les challenges en cours */
            $listEvents = getEvenements($conn);
            
            foreach($listEvents as $current) {
                echo('<option value="' . $current['libelle'] . '>');
            }

            echo('</datalist>
            <button id="creer_equipe" type="button" onclick="createTeam(' . $_SESSION['infoUser']['prenom'] . ' ' . $_SESSION['infoUser']['nom'] . ')">Créer une équipe</button>
            </div>');
        }

        /* Affichage des membres de l'équipe */
        echo ('<!-- Affichage des membres de son équipe -->
        <div id="monEquipe">');
        /* On initialise le compteur pour naviguer dans la classe */
        $i = 0;
        foreach ($_SESSION['teamMembers'] as $member) {
            echo ('<div class="ligne_equipe" id="' . $i . '" onclick="supprMemberTeam(' . $i . ')">');

            /* Si le membre est le capitaine, on affiche une couronne */
            if ($member == $_SESSION['infoTeam']['capitaine']) {
                echo ('<img id="logo_crown" src="../../img/logo_crown.png" alt="logo">');
            }
            echo ('<span class="nom_teamMember id="' . $member . '">' . getUtilisateurById($conn, $member)['prenom'] . ' ' . getUtilisateurById($conn, $member)['nom'] . ' </span>  
                    </div>');
            $i++;
        }
        echo ('</div>');

        /* On récupère le challenge auquel l'équipe participe */
        $idEvent = $_SESSION['infoTeam']['idEvent'];

        /* On récupère les étudiants inscrits au challenge et n'ayant pas d'équipe */
        $liste_inscrits = getInscritsSansEquipe($idEvent);

        /* Champ de saisie pour ajouter un membre à l'équipe */
        echo ('<div id="ajout_membre">
        <input type="text" id="partipant" list="liste_participants" required>

        <datalist id="liste_participants">');

            /* Liste de tous les inscrits au challenge qui n'ont pas d'équipe */            
            foreach($liste_inscrits as $current) {
                echo('<option value="' . $current['prenom'] . ' ' . $current['nom'] . ' name="' . $current['idUser'] . '>');
            }

            echo('</datalist>

        <button type="button" onclick="addMemberTeam();">Ajouter à l\'équipe</button>
        </div>');
        ?>
    </div>

</main>

<?php require '../Integrations/footer.php'; ?>
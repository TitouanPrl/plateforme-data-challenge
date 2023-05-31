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

        /* ================================== *
        *           CREATION EQUIPE           *
        * =================================== */

        /* Si l'utilisateur n'a pas d'équipe, on affiche les champs et le bouton lui proposant d'en créer une */
        if (!isset($_SESSION['infoUser']['idEquipe'])) {
            echo ('<div id="creer_equipe">
            <h2 class="titreForm"> Création d\'une équipe </h2>
            <form>
            <input type="text" id="nom_equipe" placeholder="Nom que vous souhaitez donner à votre équipe" required>

            <input type="text" id="nom_challenge" list="liste_challenges" placeholder="Challenge auquel vous souhaitez inscrire votre équipe" required>
            <datalist id="liste_challenges">');

            /* Liste de tous les challenges en cours */
            $listEvents = getEvenements($conn);

            foreach ($listEvents as $current) {
                echo ('<option value="' . $current['libelle'] . '">');
            }

            echo ('</datalist>');

            /* Deuxième membre (après le capitaine) */
            echo ('<p class="titre_input"> Membre 1 </p>
            <input type="text" id="partipant2" list="liste_participants" required>');

            /* Troisième membre (après le capitaine) */
            echo ('<p class="titre_input"> Membre 2 </p>
            <input type="text" id="partipant3" list="liste_participants" required>');

            echo ('<button id="creer_equipe" type="submit" onclick="createTeam(' . $_SESSION['infoUser']['prenom'] . ' ' . $_SESSION['infoUser']['nom'] . ')">Créer une équipe</button>
            </form>
            </div>');
        }

        /* ================================== *
        *                EQUIPE               *
        * =================================== */

        /* Affichage des membres de l'équipe */
        echo ('<!-- Affichage des membres de son équipe -->
        <div id="monEquipe">
        <h2 class="titreForm"> Mon équipe </h2>
        <p id="legend"> Une équipe doit avoir entre 3 et 8 membres, si vous êtes capitaine, vous pouvez supprimer un membre en cliquant dessus </p>');
        /* On initialise le compteur pour naviguer dans la classe */
        $i = 0;
        foreach ($_SESSION['teamMembers'] as $member) {
            echo ('<div class="ligne_equipe" id="' . $i . '">');
            /* Si le user actuel est capitaine, on lui permet de supprimer des membres */
            if ($_SESSION['capitaine'] == true) {
                echo ('<img class="delete_button" src="../../img/croix.png" onclick="supprMemberTeam(' . $i . ')" alt="I am an image">');
            }

            /* Si le membre est le capitaine, on affiche une couronne */
            if ($member == $_SESSION['infoTeam']['capitaine']) {
                echo ('<img id="logo_crown" src="../../img/logo_crown.png" alt="logo">');
            }
            echo ('<span class="nom_teamMember id="' . $member . '">' . getUtilisateurById($conn, $member)['prenom'] . ' ' . getUtilisateurById($conn, $member)['nom'] . ' </span>  
                    </div>');
            $i++;
        }

        /* Si le user actuel est capitaine, on lui permet de supprimer l'équipe */
        if ($_SESSION['capitaine'] == true) {
            echo ('<a id="but_suppr_equipe" href="supprEquipe.php">Supprimer l\'équipe</a>');
        }

        echo ('</div>');


        /* ================================== *
        *           AJOUT D'UN MEMBRE         *
        * =================================== */

        /* On récupère le challenge auquel l'équipe participe */
        $idEvent = $_SESSION['infoTeam']['idEvent'];

        /* On récupère les étudiants inscrits au challenge et n'ayant pas d'équipe */
        $liste_inscrits = getInscritsSansEquipe($conn, $idEvent);

        /* Champ de saisie pour ajouter un membre à l'équipe */ ?>
        <div id="ajout_membre">
        <p class="titre_input"> Ajouter un membre </p>
        <input type="text" id="partipant" list="liste_participants" required>

        <datalist id="liste_participants">

        <?php 

        var_dump($liste_inscrits);
        /* Liste de tous les inscrits au challenge qui n'ont pas d'équipe */
        foreach ($liste_inscrits as $current) {
            echo ('<option value="' . $current['prenom'] . ' ' . $current['nom'] . ' name="' . $current['idUser'] . '>');
        }

        echo ('</datalist>');

        /* Si le user actuel est capitaine, on lui permet d'ajouter des membres */
        if ($_SESSION['capitaine'] == true) {
            echo ('<button type="button" id="but_add_member" onclick="addMemberTeam();">Ajouter à l\'équipe</button>');
        }
        echo ('</div>');

        ?>
    </div>

</main>

<?php require '../Integrations/footer.php'; ?>
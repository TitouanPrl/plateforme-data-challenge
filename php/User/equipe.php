<?php require '../Integrations/headerEtudiant.php';

/* On inclut les fonctions de manipulation de la BDD */
require_once("../../bdd/fonctionsBDD.php");

connect();
?>

<!-- MAIN CONTENT -->
<div class="bordure"></div>    
<div class="corps" style="height:auto;background-attachment: fixed;">
    <main id="pageEquipe">

        <?php

        /* ================================== *
        *           CREATION EQUIPE           *
        * =================================== */

        /* Si l'utilisateur n'a pas d'équipe, on affiche les champs et le bouton lui proposant d'en créer une */
        if (!isset($_SESSION['infoUser']['idEquipe'])) {
            echo ('
            <div id="creer_equipe" style="display:flex; justify-content:center;height:fit-content;">
                <div style="display:flex;flex-direction:column; justify-content:center;align-items:center;">
                    <h2 class="titreForm"> Création d\'une équipe </h2>
                    <form>
                        <input type="text" id="nom_equipe" placeholder="Nom que vous souhaitez donner à votre équipe" required>

                        <input type="text" id="nom_challenge" list="liste_challenges" placeholder="Challenge auquel vous souhaitez inscrire votre équipe" required>
                        <datalist id="liste_challenges">'
            );
            /* Liste de tous les challenges auxquels l'utilisateur est inscrit */
            $listEvents = getEventInscrit($conn, $_SESSION['ID']);

            foreach ($listEvents as $current) {
                $infoChallenge = getChallengeByID($conn, (int)$current)[0];
                echo ('<option value="' . $infoChallenge['libelle'] . '">');
            }

            echo ('</datalist>');

            /* Deuxième membre (après le capitaine) */
            echo ('<p class="titre_input"> Membre 1 </p>
            <input type="text" id="partipant2" list="liste_participants" required>');

            /* Liste des utilisateurs inscrits aux mêmes challenge que le user qui crée l'équipe */
            echo('<datalist id="liste_participants">');

            foreach ($listEvents as $current) {
                $infoChallenge = getChallengeByID($conn, (int)$current)[0];
                $liste_inscrits = getInscritsSansEquipe($conn, $infoChallenge['idEvenement']);

                foreach ($liste_inscrits as $currentUser) {
                    /* On récupère les infos du user */
                    $info_user = getUtilisateurById($conn, (int)$currentUser['idUser']);
                    $cur_info_user = $info_user[0];

                    if ($cur_info_user['idUser'] != $_SESSION['ID']) {
                        echo ('<option value="' . $cur_info_user['prenom'] . ' ' . $cur_info_user['nom'] . ' - ' . strtoupper($infoChallenge['libelle']) . '" dataID="' . $cur_info_user['idUser'] . '">');
                    }
                }
            }
            
            echo ('</datalist>');


            /* Troisième membre (après le capitaine) */
            echo ('<p class="titre_input"> Membre 2 </p>
            <input type="text" id="partipant3" list="liste_participants" required>');
            
            $nom_prenom = $_SESSION['infoUser']['prenom'] . ' ' . $_SESSION['infoUser']['nom'];

            echo ('
                    <button type="submit" id="creer_equipe" class="boutonForm" onclick="createTeam(' . $nom_prenom . ')">Créer une équipe</button>
                    </form>
                </div>
            </div>');
        }

        /* ================================== *
        *                EQUIPE               *
        * =================================== */

        if(isset($_SESSION['infoTeam'])) {

            /* Affichage des membres de l'équipe */
            echo ('<!-- Affichage des membres de son équipe -->
            <div id="monEquipe">
            <h2 class="titreForm" > Mon équipe </h2>
            <p id="legend"> Une équipe doit avoir entre 3 et 8 membres, si vous êtes capitaine, vous pouvez supprimer un membre en cliquant dessus </p>');
            /* On initialise le compteur pour naviguer dans la classe */
            echo('<div id="listeEquipe">');
            $i = 0;
            foreach ($_SESSION['teamMembers'] as $memberAct) {
                $member = $memberAct['idUser'];
                echo ('<div class="ligne_equipe" id="' . $i . '">');
                /* Si le user actuel est capitaine, on lui permet de supprimer des membres */
                if (($_SESSION['capitaine'] == true) && $member != $_SESSION['infoTeam']['capitaine']) {
                    echo ('<img class="delete_button" src="../../img/croix.png" onclick="supprMemberTeam(' . $i . ')" alt="I am an image">');
                }

                /* Si le membre est le capitaine, on affiche une couronne */
                if ($member == $_SESSION['infoTeam']['capitaine']) {
                    echo ('<img id="logo_crown" src="../../img/logo_crown.png" alt="logo">');
                }
                echo ('<span class="nom_teamMember" id="' . $member . '">' . getUtilisateurById($conn, $member)[0]['prenom'] . ' ' . getUtilisateurById($conn, $member)[0]['nom'] . ' </span>  
                        </div>');
                $i++;
            }

            echo ('</div>
            </div>
            <div id="modifEquipe">
            ');

            /* Si le user actuel est capitaine, on lui permet de supprimer l'équipe */
            if ($_SESSION['capitaine'] == true) {
                echo ('<a class="boutonForm" style="background-color:red;" href="supprEquipe.php">Supprimer l\'équipe</a>');
                echo (' <form id="linegithub">
                            <p class="titre_input"> Deposer un code </p>
                            <input type="text" id="liengit" name="inputGit" placeholder="https://github.com/TitouanPrl/plateforme-data-challenge">
                            <button class="boutonForm" type="submit">Lien Github/Depot</button>
                        </form>');
                // ajout du lien github dans la base de données
                if (isset($_GET['inputGit'])) {
                    $link = $_GET['inputGit'];
                    $idTeam = $_SESSION['infoTeam']['idEquipe'];
                    $sql = "UPDATE Projet SET lienCode = '$link' WHERE idEquipe = '$idTeam'";
                    $conn->query($sql);
                }

            }        

            
            /* ================================== *
            *           AJOUT D'UN MEMBRE         *
            * =================================== */

            /* Si le user actuel est capitaine, on lui permet d'ajouter des membres */
            if ($_SESSION['capitaine'] == true) {
                
                /* On récupère le challenge auquel l'équipe participe */
                $idEvent = (int)$_SESSION['infoTeam']['idEvenement'];
                
                /* On récupère les étudiants inscrits au challenge et n'ayant pas d'équipe */
                $liste_inscrits = getInscritsSansEquipe($conn, $idEvent);
                
                /* Champ de saisie pour ajouter un membre à l'équipe */ ?>
                <div id="ajout_membre">
                <p class="titre_input"> Ajouter un membre </p>
                <input type="text" id="participant" list="liste_participants" required>
                
                <datalist id="liste_participants">
                
                <?php 
    
                /* Liste de tous les inscrits au challenge qui n'ont pas d'équipe */
                foreach ($liste_inscrits as $currentUser) {
                    /* On récupère les infos du user */
                    $info_user = getUtilisateurById($conn, (int)$currentUser['idUser']);
                    $cur_info_user = $info_user[0];
                
                    if ($cur_info_user['idUser'] != $_SESSION['ID']) {
                        echo ('<option value="' . $cur_info_user['prenom'] . ' ' . $cur_info_user['nom']. '" dataID="' . $cur_info_user['idUser'] . '">');
                    }
                }
            
                echo ('</datalist>');
            
                
                echo ('<button type="button" id="but_add_member" class="boutonForm" onclick="addMemberTeam();">Ajouter à l\'équipe</button>');
            }
            echo ('</div>');
        }

        ?>
    </main>
</div>

<?php require '../Integrations/footer.php'; ?>
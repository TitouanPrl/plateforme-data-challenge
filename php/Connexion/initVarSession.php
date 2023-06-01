<?php

/* On vérifie qu'un mdp a bien été rentré (évite qu'on dodge la page de connexion) */
if (!isset($_SESSION["login"])) {
    header('Location:../Connexion/connexionInscription.php?message=1');
    exit();
}

connect();

/* On récupère les infos de l'utilisateur en cours */
$_SESSION['infoUser'] = getUtilisateurById($conn, $_SESSION['ID'])[0];

/* On récupère les challenges auxquels l'utilisateur est inscrit */
$_SESSION['inscriptions'] = getEventInscrit($conn, $_SESSION['ID']);

/* On récupère les membres de son équipe et ses infos */
if (isset($_SESSION['infoUser']['idEquipe'])) {
    $_SESSION['teamMembers'] = getEquipeMembers($conn,$_SESSION['infoUser']['idEquipe']);
    $_SESSION['infoTeam'] = getEquipe($conn,$_SESSION['infoUser']['idEquipe'])[0];

    /* On regarde si le user est capitaine ou non */
    if ($_SESSION['ID'] == $_SESSION['infoTeam']['capitaine']) {
        $_SESSION['capitaine'] = true;
    }
    else {
        $_SESSION['capitaine'] = false;
    }
    
}

?>


<?php 

/* On redirige vers la page d'accueil correspondant au type de l'utilisateur */
switch ($_GET['type']) {
    case 'admin':
        header('Location: accueilAdmin.php');
      break;

    case 'gestion':
        header('Location: accueilGestion.php');
      break;

    case 'user':
        header('Location: accueilUser.php');
      break;

    default:
      header('Location: connexionInscription.php?error=3');
      break;
  }

?>
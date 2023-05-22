<?php 

/* On redirige vers la page d'accueil correspondant au type de l'utilisateur */
switch ($_GET['type']) {
    case 'admin':
        header('Location: Admin/accueilAdmin.php');
      break;

    case 'gestion':
        header('Location: Gestion/accueilGestion.php');
      break;

    case 'user':
        header('Location: User/accueilUser.php');
      break;

    default:
      header('Location: Connexion/connexionInscription.php?error=3');
      break;
  }

?>
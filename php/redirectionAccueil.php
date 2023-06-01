<?php 

/* On redirige vers la page d'accueil correspondant au type de l'utilisateur */
switch ($_GET['fonction']) {
    case 'ADMIN':
        header('Location: Admin/accueilAdmin.php');
      break;

    case 'GESTION':
        header('Location: Gestion/accueilGestion.php');
      break;

    case 'USER':
        header('Location: User/accueilUser.php');
      break;

    default:
      header('Location: Connexion/connexionInscription.php?message=3');
      break;
  }

?>
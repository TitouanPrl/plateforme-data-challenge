<?php
session_start();

/* On inclut les fonctions de manipulation de la BDD */
include("../bdd/fonctionsBDD.php");

/* On écrit dans la session les variables rentrées */
$_SESSION['login'] = $_POST['login'];
$_SESSION['mdp'] = $_POST['mdp'];

/* On vérifie qu'un mdp a bien été rentré (évite qu'on dodge la page de connexion) */
if (!isset($_SESSION["login"])){
  header('Location:connexionInscription.php?error=1');
  exit();
}


//PARTIE VERIFICATION IDENTITE
/* On lit la liste des users dans la BDD */
Connexion();
recupClient();

/* Si le fichier n'existe pas on renvoit une erreur */
if ($_SESSION['data']['Utilisateur'] == NULL) {     
  echo "La liste des utilisateurs n'existe pas, l'administrateur a fait un sale boulot, n'hésite pas à le critiquer";
  exit();
}

/* Sinon on vérifie que l'utilisateur existe dans le fichier */
else {

  foreach($_SESSION['data']['Utilisateur'] as $user) {

    /* On écrit les var dans la session */
    $_SESSION['login1'] = $user['loginID'];
    $_SESSION['mdp1'] = $user['mdp'];

    /* Si les infos de connexion correspondent on passe l'état à connecté et on redirige vers l'accueil */
    if ($_SESSION['login'] == $_SESSION['login1'] && md5($_SESSION['mdp']) == $_SESSION['mdp1']){

      /* On change l'état de la connexion */
      $user['connectID'] = 'true';

      /* On met en session l'id de l'utilisateur */
      $_SESSION['ID'] = $user['idUser'];
      
      if ($user['adminID'] == true) {
        $_SESSION['admin'] = true;
      }
      else {
        $_SESSION['admin'] = false;
      }

      /* On update l'état des clients dans la BDD */
      connecter($_SESSION['ID']);

      /* On redirige vers l'accueil */
      // A MODIFIER EN FONCTION DU TYPE DE USER, LA REDIRECTION N'EST PAS LA MEME
      //CF redirectionAccueil.php
      header('Location: accueil.php'); 

      exit();
    }

  }

  /* Si les données de connexions ne correspondent pas on renvoi vers la connexion */
  session_destroy(); 
  header('Location: connexion.php?error=2');

}

  ?>

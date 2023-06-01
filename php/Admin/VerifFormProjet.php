<?php session_start() ?>
<?php
    require_once("../../bdd/fonctionsBDD.php");

    connect();
  /* Var témoin pour savoir si les données d'inscription de l'utilisateur sont valides ou non */
    $correct = true;
    /* Sécurise la chaine de caractère lue, évite l'injection de code malveillant */
    function erase($donnees) {

        /* On supprime les espaces inutiles */
        $donnees = trim($donnees);

        /* On supprime les antislashs */
        $donnees = stripslashes($donnees);

        /* On échappe les caractères spéciaux */
        $donnees = htmlspecialchars($donnees);

        return $donnees;

    }  

    /* Définition des variables */
    $libelle = erase($_POST['libelle']);
    $telGerant = erase($_POST['telG']);
    $emailGerant = erase($_POST['mailG']);
    $idevt = erase($_SESSION['idevt']);
    $Description = erase($_POST['Description']);

     /* On vérifie que les var ne sont pas vides */
     if (empty($libelle)
     || empty($telGerant)
     || empty($emailGerant)
     || empty($idevt)) {
         global $correct;
        $correct = false;
     }

    /* Si les données ne sont pas valides on renvoit le form avec les erreurs à corriger */
        if ($correct == false) {
        header('Location:formProjet.php?libelle=' . $libelle . '&telGerant=' . $telGerant . '&emailGerant=' . $emailGerant . '&idevt=' . $idevt . '&Description=' . $Description );
        exit();
        }

        // fonction qui permet de récupérer les fichiers télécharger dans le répertoire fichierstelecharger

        else{
            $stock = '../../fichierstelecharger/';
            $i=0;
            while($i< count($_FILES['userfile'])){
                if($_FILES['userfile']['tmp_name'][$i]!=""){
                    if (move_uploaded_file($_FILES['userfile']['tmp_name'][$i], $stock.$_FILES['userfile']['name'][$i]))
                    {
                        echo '<p id="msgfichier"> Le fichier '.$_FILES['userfile']['name'][$i].' a été téléchargé avec succès dans '.$stock.'</p>';
                    }
                    else{
                        echo"Le fichier n'a pas pu être télécharger ";
                    }
                }
                $i+=1;
            }
            //ajout du Data Challenge dans la Bdd
            createSujet($conn,$idevt,$libelle,$Description,NULL,$telGerant,$emailGerant,NULL);
            //redirection à l'accueil admin
            header('Location:accueilAdmin.php');
        }
 
?>
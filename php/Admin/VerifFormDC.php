
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
    $DateDebut =date('Y-m-d', strtotime(erase($_POST['DateDebut'])));
    $DateFin = date('Y-m-d', strtotime(erase($_POST['DateFin'])));
    $heureD = erase($_POST['heureD']);
    $heureF = erase($_POST['heureF']);
    $Commentaires = erase($_POST['Commentaires']);
    $event= getEvenements($conn);
    $modif = false;

     /* On vérifie que les var ne sont pas vides */
     if (empty($libelle)
     || empty($DateDebut)
     || empty($DateFin)
     || empty($heureD)
     || empty($heureF)) {
         global $correct;
        $correct = false;
     }

    /* Si les données ne sont pas valides on renvoit le form avec les erreurs à corriger */
        if ($correct == false) {
        header('Location:formDC.php?libelle=' . $libelle . '&DateDebut=' . $DateDebut . '&DateFin=' . $DateFin . '&heureD=' . $heureD . '&heureF=' . $heureF . '&Commentaires=' . $Commentaires );
        exit();
        }

        // fonction qui permet de récupérer les fichiers télécharger dans le répertoire fichierstelecharger

        else{
            $stock = '../../fichierstelecharger/';
            $i=0;
            echo(count($_FILES['userfile'][1]));
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
            foreach($event as $evt){
                if ($evt['libelle'] == $libelle){
                    $modif= true;
                    $idevt = $evt['idEvenement'];
                }
            }
            if($modif){
                modifyEvenement($conn,$idevt,$libelle,$Commentaires,$DateDebut,$DateFin);
                header('Location:accueilAdmin.php');
            }
            else{
                //ajout du Data Challenge dans la Bdd
            createEvenement($conn,"CHALLENGE",$libelle,$Commentaires,$DateDebut,$DateFin);
            //redirection à l'accueil admin
            header('Location:accueilAdmin.php');
            }
        }
 
?>

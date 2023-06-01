<?php session_start() ?>

<?php
// on récupère le type d'utilisateur qui s'inscrit
if(!empty($_SESSION["type"] )){
    $type = $_SESSION["type"];
}
else{
    $type = "etudiant";
}
?>



<?php
    require_once("../../bdd/fonctionsBDD.php");

    connect();
  /* Var témoin pour savoir si les données d'inscription de l'utilisateur sont valides ou non */
    $valide = true;
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
    $nom = erase($_POST['nom']);
    $prenom = erase($_POST['prenom']);
    $mail = erase($_POST['mail']);
    $nivEtude = erase($_POST['nivEtude']);
    $ecole = erase($_POST['ecole']);
    $ville = erase($_POST['ville']);
    $tel = erase($_POST['tel']);
    $entreprise = erase ($_POST['entreprise']);
    $dateFin = erase($_POST['dateFin']);
    

    /* On vérifie que les var ne sont pas vides */
    if (empty($nom)
    || empty($prenom)
    || empty($mail)
    || empty($ville)
    || empty($tel)) {

        global $valide;
       $valide = false;
    }

    /* Matche pattern nom et prenom */
    function patern_nom($data) {
        global $valide;
        if (!ctype_upper($data[0]) || !ctype_alpha($data)) {
            $valide = false;
        }
    }
    patern_nom($nom);
    patern_nom($prenom);

    /* Matche patern tel */
    
    function patern_tel($data) {
        global $valide;
        if((!is_numeric($data)) || (strlen($data) != 10)) {
            $valide = false;
        }
    }
    patern_tel($tel);
        //on retire les vérifications non nécessaires en fonction du type d'inscription
    if($type == "administrateur"){
                /* Si les données ne sont pas valides on renvoit le form avec les erreurs à corriger */
        if ($valide == false) {
            header('Location:formInsc.php?nom=' . $nom . '&prenom=' . $prenom . '&mail=' . $mail . '&tel=' . $tel . '&ville=' . $ville );
            exit();
        }
        else{
            //ajout du compte admin dans la bdd
            addAdmin($conn,$nom,$prenom,$numTel,$email,md5('123'));
            /* On redirige vers l'accueil avec connexion */
            header('Location:../Admin/accueilAdmin.php');
        }
    }

    if($type == "gestionnaire"){
        if(empty($entreprise) || empty($dateFin)){
            global $valide;
            $valide = false;
        }
            /* Si les données ne sont pas valides on renvoit le form avec les erreurs à corriger */
        if ($valide == false) {
            header('Location:formInsc.php?nom=' . $nom . '&prenom=' . $prenom . '&mail=' . $mail . '&tel=' . $tel . '&entreprise='. $entreprise . '&ville=' . $ville . '&dateFin=' . $dateFin);
            exit();
        }

        else{
        $dateDebut = date('d-m-y');
        addGestion($conn,$nom,$prenom,$entreprise,$numTel,$email,md5('123'),$dateDebut,$dateFin);
        /* On redirige vers l'accueil avec connexion */
        header('Location:../Admin/accueilAdmin.php');
        }
    }

    if($type =="etudiant"){
        if(empty($ecole) || empty($nivEtude)){
            global $valide;
            $valide = false;
        }
            /* Si les données ne sont pas valides on renvoit le form avec les erreurs à corriger */
        if ($valide == false) {
            header('Location:formInsc.php?nom=' . $nom . '&prenom=' . $prenom . '&mail=' . $mail . '&tel=' . $tel . '&nivEtude=' . $nivEtude . '&ecole=' . $ecole . '&ville=' . $ville );
            exit();
        }

        else{
            addEtudiant($conn,$nom,$prenom,$numTel,$email,md5('123'),$nivEtude,$ecole,$ville);
            /* On redirige vers l'accueil avec connexion */
            header('Location:../Admin/accueilAdmin.php');
        }
    }
    header('Location:../Admin/accueilAdmin.php');

?>

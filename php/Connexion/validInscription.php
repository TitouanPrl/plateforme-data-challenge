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

    /* Var témoin pour savoir si les données sont valides ou non */
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
    $entreprise = erase ($_POST['entreprises']);
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
            header('Location:connexionInscription.php?nom=' . $nom . '&prenom=' . $prenom . '&mail=' . $mail . '&tel=' . $tel . '&ville=' . $ville );
            exit();
        }
        else{
            mail(
                $mail,         /* Destinataire */
                'Résumé de votre inscription sur la plateforme IA Pau',       /* Sujet du mail */
                'Nom : ' . $nom . '\r\n
                Prénom : ' . $prenom . '\r\n
                Mail : ' . $mail . '\r\n
                Tel : ' . $tel . '\r\n
                Ville : ' . $ville . '\r\n
                Date de fin de compte : '. $dateFin  . ' \r\n'
            );
    
            // AJOUTER LA FCT POUR AJOUTER UN USER DANS LA BDD
    
            /* On redirige vers l'accueil avec connexion */
            header('Location:../User/accueilUser.php');
        }
    }

    if($type == "gestionnaire"){
        if(empty($entreprise) || empty($dateFin)){
            global $valide;
            $valide = false;
        }
            /* Si les données ne sont pas valides on renvoit le form avec les erreurs à corriger */
        if ($valide == false) {
            header('Location:connexionInscription.php?nom=' . $nom . '&prenom=' . $prenom . '&mail=' . $mail . '&tel=' . $tel . '$entreprise='. $entreprise . '&ville=' . $ville . '&dateFin=' . $dateFin);
            exit();
        }

        else{
            /* Si elles le sont, on envoie un mail avec un récap et on push dans la BDD */
            mail(
                $mail,         /* Destinataire */
                'Résumé de votre inscription sur la plateforme IA Pau',       /* Sujet du mail */
                'Nom : ' . $nom . '\r\n
                Prénom : ' . $prenom . '\r\n
                Mail : ' . $mail . '\r\n
                Tel : ' . $tel . '\r\n
                Ville : ' . $ville . '\r\n
                Entreprise : ' . $entreprise . '\r\n
                Date de fin de compte : '. $dateFin  . ' \r\n'
            );


        /* On redirige vers l'accueil avec connexion */
        header('Location:../User/accueilUser.php');
        }
    }

    if($type =="etudiant"){
        if(empty($ecole) || empty($nivEtude)){
            global $valide;
            $valide = false;
        }
            /* Si les données ne sont pas valides on renvoit le form avec les erreurs à corriger */
        if ($valide == false) {
            header('Location:connexionInscription.php?nom=' . $nom . '&prenom=' . $prenom . '&mail=' . $mail . '&tel=' . $tel . '&nivEtude=' . $nivEtude . '&ecole=' . $ecole . '&ville=' . $ville );
            exit();
        }

        else{
            /* Si elles le sont, on envoie un mail avec un récap et on push dans la BDD */
            mail(
                $mail,         /* Destinataire */
                'Résumé de votre inscription sur la plateforme IA Pau',       /* Sujet du mail */
                'Nom : ' . $nom . '\r\n
                Prénom : ' . $prenom . '\r\n
                Mail : ' . $mail . '\r\n
                Tel : ' . $tel . '\r\n
                Niveau d\'étude : ' . $nivEtude . '\r\n
                Ecole : ' . $ecole . '\r\n
                Ville : ' . $ville . '\r\n'
            );

            /* On redirige vers l'accueil avec connexion */
            header('Location:../User/accueilUser.php');
        }
    }
    header('location:../User/accueilUser.php');
?>

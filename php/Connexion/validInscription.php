<?php

    /* On inclut les fonctions de manipulation de la BDD */
    require_once("../../bdd/fonctionsBDD.php");

    connect();

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
    $mdp = erase($_POST['mdp']);

    /* On vérifie que les var ne sont pas vides */
    if (empty($nom)
    || empty($prenom)
    || empty($mail)
    || empty($nivEtude)
    || empty($ecole)
    || empty($ville)
    || empty($tel)
    || empty($mdp)) {

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

    /* Si les données ne sont pas valides on renvoit le form avec les erreurs à corriger */
    if ($valide == false) {
        header('Location:connexionInscription.php?nom=' . $nom . '&prenom=' . $prenom . '&mail=' . $mail . '&tel=' . $tel . '&nivEtude=' . $nivEtude . '&ecole=' . $ecole . '&ville=' . $ville);
        exit();
    }

    /* Si elles le sont, on envoie un mail avec un récap et on push dans la BDD */
    if ($valide == true) {
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

        /* On crée le user dans la BDD */
        addEtudiant($conn,$nom,$prenom,$tel,$mail,$mdp,$nivEtude,$ecole,$ville);
        
        /* On redirige l'utilisateur vers la connexion */
        header('Location:connexionInscription.php?message=4');
    }

?>


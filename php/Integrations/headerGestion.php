<?php
session_start();

/* On vérifie qu'un mdp a bien été rentré (évite qu'on dodge la page de connexion) 
if (!isset($_SESSION["login"]) || ($_SESSION['infoUser']['fonction'] != "GESTION")) {
    header('Location:../Connexion/connexionInscription.php?message=1');
    exit();
}
*/
?>

<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />

    <title>IA Pau</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300|Sonsie+One" rel="stylesheet" />
    <link rel="stylesheet" href="../../css/style.css" />
    <link rel="stylesheet" href="../../css/boutons.css" />
    <link rel="stylesheet" href="../../css/form.css" />
    <link rel="stylesheet" href="../../css/messagerie.css" />
    <link rel="stylesheet" href="../../css/cartes.css" />
    <link rel="stylesheet" href="../../css/gestion.css" />
    <link rel="shortcut icon" type="image/png" href="../../img/logo_iaPau.png">
    <script src="../../script/script.js"></script>
    <script src="../../script/gestionQuiz.js"></script>


</head>

<body>
    <!-- HEADER UTILISATEUR CONNECTÉ EN TANT QUE GESTIONNAIRE -->

    <header>
        <div id="header" class="">

            <a class="shine" href="../Gestion/accueilGestion.php">
                <figure><img id="logo" src="../../img/logo_iaPau.png" alt="logo"></figure>
            </a>
            <nav id="liens">
                <a href="../General/listeChallenge.php">Informations Challenges</a>
                <a href="mesChallengesGestion.php">Mes sujets</a>
                <a href="quizList.php">Mes quiz</a>
                <a href="../Analyseur/accueilAnalyseur.php">Analyseur de code</a>
                <a href="../Messagerie/messagerie.php">Messagerie</a>

            <form action="../Connexion/deconnexion.php" >
                <input type="submit" class="boutonDeco" value="Déconnexion">
            </form>

        </div>

    </header>

        



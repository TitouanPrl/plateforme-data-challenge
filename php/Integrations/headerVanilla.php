<?php
session_start();
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
    <link rel="shortcut icon" type="image/png" href="../../img/logo_iaPau.png">
    <script src="../../script/script.js"></script>


</head>

<body>
    <!-- HEADER UTILISATEUR NON CONNECTÉ-->

    <header>
        <div id="header" class="">

            <a class="shine" href="../General/accueilGeneral.php">
                <figure><img id="logo" src="../../img/logo_iaPau.png" alt="logo"></figure>
            </a>
            <nav id="liens">
                <a href="../General/infoChallenge.php">Informations Challenges</a>
                <a href="../General/inscriptionChallenge.php">Inscription Challenge</a>
                <!-- RAJOUTER LES LIENS NECESSITANT UNE  CONNEXION -->
            </nav>

            <form action="../Connexion/connexionInscription.php" >
                <input type="submit" class="boutonDeco" value="Connexion">
            </form>

        </div>

    </header>
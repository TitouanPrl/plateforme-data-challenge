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
    <link rel="shortcut icon" type="image/png" href="../../img/logo_iaPau.png">
    <script src="../../js/script.js"></script>


</head>

<body>
    <!-- HEADER -->

    <header>

        <img id="logo" src="../../img/logo_iaPau.png" alt="logo">

        <nav id="liens">
            <a href="../General/infoChallenge.php">Informations Challenges</a>
            <a href="../User/inscriptionChallenge.php">Inscription Challenge</a>
        </nav>

        <form action="../Connexion/deconnexion.php">
            <input type="submit" id="deco" value="Déconnexion">
        </form>

    </header>
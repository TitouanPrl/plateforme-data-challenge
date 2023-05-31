<?php
session_start();

/* On vérifie qu'un mdp a bien été rentré (évite qu'on dodge la page de connexion) */
if (!isset($_SESSION["login"]) ||($_SESSION['infoUser']['fonction'] != "USER")) {
    header('Location:../Connexion/connexionInscription.php?message=1');
    exit();
}

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
    <script src="../../script/script.js"></script>
    <script src="../../script/gestionEquipe.js"></script>


</head>

<body>
    <!-- HEADER UTILISATEUR CONNECTÉ EN TANT QUE PARTICIPANT -->

    <header>
        <div id="header" class="">

            <a class="shine" href="../General/accueilGeneral.php">
                <figure><img id="logo" src="../../img/logo_iaPau.png" alt="logo"></figure>
            </a>
            <nav id="liens">
                <a href="inscriptionChallenge.php">Liste des challenges</a>
                <a href="equipe.php">Mon équipe</a>
                <a href="mesChallenges.php">Mes challenges</a>
                <a href="../Analyseur/accueilAnalyseur.php">Analyseur de code</a>
                <?php
                /* Si l'utilisateur est le capitaine, on affiche le lien du QCM */
                if (isset($_SESSION['infoTeam'])) {
                    if ($_SESSION['capitaine'] == true) {
                        echo ('<a href="quiz.php">Quiz</a>');
                    }
                }
                ?>
            </nav>

            <form action="../Connexion/deconnexion.php">
                <input type="submit" class="boutonDeco" value="Déconnexion">
            </form>

        </div>

    </header>
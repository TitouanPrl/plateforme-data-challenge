<?php

/* On inclut les fonctions de manipulation de la BDD */
require_once("../../bdd/fonctionsBDD.php");

session_start();

connect();

/* On récupère les challenges disponibles */
$_SESSION['Evenements'] = getEvenements($conn);
?>


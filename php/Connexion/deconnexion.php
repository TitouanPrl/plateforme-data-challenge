<?php
session_start();

/* On inclut les fonctions de manipulation de la BDD */
require_once("../../bdd/fonctionsBDD.php");

connect();

disconnect($conn);

session_destroy();

header('Location: connexionInscription.php?message=5');
exit();
<?php
session_start();

session_destroy();
header('Location: connexionInscription.php');
exit();
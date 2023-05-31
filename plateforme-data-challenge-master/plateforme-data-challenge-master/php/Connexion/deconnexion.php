<?php
session_start();

disconnect($conn);

session_destroy();
header('Location: connexionInscription.php');
exit();
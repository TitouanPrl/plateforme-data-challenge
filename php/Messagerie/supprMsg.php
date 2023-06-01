<?php
    require_once "../../bdd/fonctionsBDD.php";
    if (!connect()) {
        die('Erreur de connexion à la base de données');
    }

    $idMes = $_POST["idMes"];

    deleteMessage($conn,$idMes);

    echo "good";
?>

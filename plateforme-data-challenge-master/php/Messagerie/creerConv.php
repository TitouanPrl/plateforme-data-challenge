<?php
    require_once "../../bdd/fonctionsBDD.php";
    if (!connect()) {
        die('Erreur de connexion à la base de données');
    }


    $idDestinataire = $_POST["destinataire"];
    $idExpediteur = $_POST["expediteur"];

    addConversation($conn, $idExpediteur, $idDestinataire);

    $idConv = getIDConversationByCorres($conn,$idExpediteur,$idDestinataire);
    

    echo $idConv[0]["idConversation"];
?>

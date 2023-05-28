<?php

    $idDestinataire = $_POST["destinataire"];
    $idExpediteur = $_POST["expediteur"];

    addConversation($conn, $idExpediteur, $idDestinataire);
    $idConv = getIDConversationByCorres($conn,$idExpediteur,$idDestinataire);

    echo $idDestinataire ."|". $idConv;
?>

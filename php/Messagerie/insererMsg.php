<?php

    $idExpediteur = $_POST['expediteur'];
    $idDestinataire = $_POST['destinataire'];
    $contenu = $_POST['contenu'];

    addMessage($conn,$contenu, $idExpediteur, $idDestinataire);

    echo $_POST['message'];

?>

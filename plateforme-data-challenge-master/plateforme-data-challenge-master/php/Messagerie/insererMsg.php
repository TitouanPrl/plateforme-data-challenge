<?php
    require_once "../../bdd/fonctionsBDD.php";
    if (!connect()) {
        die('Erreur de connexion à la base de données');
    }

    
    $idExpediteur = $_POST['expediteur'];
    $idDestinataire = $_POST['destinataire'];
    $contenu = $_POST['contenu'];


    addMessage($conn,$contenu, $idExpediteur, $idDestinataire);

    echo $contenu;

?>

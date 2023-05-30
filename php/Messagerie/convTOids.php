<?php 

    require_once "../../bdd/fonctionsBDD.php";
    if (!connect()) {
        die('Erreur de connexion à la base de données');
    }

    function aff($variable) {
        echo '<pre style="color: black;">';
        var_dump($variable);
        echo '</pre>';
    }

    //on obtient le nom et prénom correspondant à l'id

    $idConv = $_POST["idConv"];

    $conv = getConversationById($conn,$idConv);

    $idExp = $conv[0]["idExpediteur"];
    $idDest = $conv[0]["idDestinataire"];

    echo $idDest . "|" . $idExp;

?>
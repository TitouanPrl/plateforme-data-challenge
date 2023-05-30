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
    

    //renvoie toutes les conversations 
    $conversations = getConversations($conn);

    $res = ''; // Variable pour stocker les résultats concaténés
    foreach ($conversations as $conv) {

        //on convertit tout en chaînes de caractère pour pouvoir le passer à traver la requête ajax
        $tableau = [
            [
              "idConversation" => $conv["idConversation"],
              "idExpediteur" => $conv["idExpediteur"],
              "idDestinataire" => $conv["idDestinataire"]
            ]
        ];
          
        $jsonString = json_encode($tableau);     

        $res .= $jsonString . '|';
    }


    if($res != '') {
        echo rtrim($res,'|');
    } else  {
        echo array();
    }        

?>

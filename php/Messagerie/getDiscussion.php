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

    //pour obtenir la discussion entre deux personnes

    $messages = getMessages($conn);
    //$idConv = $_POST["idConv"];
    $idConv = 1;

    $conv = getConversationById($conn,$idConv);

    //les deux personnes liées à la discussion
    $idExp = $conv[0]["idExpediteur"];
    $idDest = $conv[0]["idDestinataire"];

    if(count($messages) == 0 ) { //count obtient le nombre de messages
        echo "";
    } else {

        $res = "";
        foreach ($messages as $msg) {

            $tmpDest = $msg['idDestinataire'];
            $tmpExp = $msg['idExpediteur'];

            //si le message est entre les deux personnes liées à la discussion
            if (($tmpDest == $idDest)&&($tmpExp == $idExp) || ($tmpDest == $idExp)&&($tmpExp == $idDest)) {
                $tab = [
                    [
                    "idMessage" => $msg["idMessage"],
                    "contenu" => $msg["contenu"],
                    "idExpediteur" => $msg["idExpediteur"],
                    "idDestinataire" => $msg["idDestinataire"]
                    ]
                ];      
                
                $jsonString = json_encode($tab);           
                $res .= $jsonString . '|';
            }
            
        }

        echo rtrim($res, '|');
    }


?>

<?php
//pour obtenir la discussion entre deux personnes

    $messages = getMessages($conn);
    $idConv = $_POST["idConv"];

    $conv = getConversationById($conn,$idConv);

    //les deux personnes liées à la discussion
    $idExp = $conv["idExpediteur"];
    $idDest = $conv["idDestinataire"];

    if(count($messages) == 0 ) {
        echo "NULL";
    } else {
        $res = "";
        foreach ($messages as $msg) {
            $tmpDest = $msg['idDestinataire'];
            $tmpExp = $msg['idExpediteur'];
            //si le message est entre les deux personnes liées à la discussion
            if (($tmpDest == $idDest)&&($tmpExp == $idExp) || ($tmpDest == $idExp)&&($tmpExp == $idDest)) {
                $res .= $msg . '|';
            }
            
        }
        echo rtrim($res, '|');
    }


?>

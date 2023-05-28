<?php
    //renvoie toutes les conversations 
    $conversations = getConversations($conn);

    $res = "";
    foreach ($conversations as $conv) {
        $res .= $conv . '|';
    
    }

    if($res != "") {
        echo rtrim($res, '|');
    } else  {
        echo "Empty";
    }        

?>

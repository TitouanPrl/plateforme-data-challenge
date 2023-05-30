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

    $id = $_POST["id"];

    $nomPrenom = getUtilisateurById($conn,$id);
    $nomPrenom = $nomPrenom[0]["prenom"] . " " . $nomPrenom[0]["nom"];  // de la forme "nom prenom"

    echo $nomPrenom;

?>
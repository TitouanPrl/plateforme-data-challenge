<?php 

    require_once "../../bdd/fonctionsBDD.php";
    if (!connect()) {
        die('Erreur de connexion à la base de données');
    }



    //on obtient le nom et prénom correspondant à l'id

    $id = $_POST["id"];

    $nomPrenom = getUtilisateurById($conn,$id);
    $nomPrenom = $nomPrenom[0]["nom"] . " " . $nomPrenom[0]["prenom"];  // de la forme "nom prenom"

    echo $nomPrenom;

?>
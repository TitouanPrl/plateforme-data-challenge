<?php 

    //on cherche l'id correspondant au nom et prénom donnés

    require_once "../../bdd/fonctionsBDD.php";
    if (!connect()) {
        die('Erreur de connexion à la base de données');
    }

    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];

    $use = "use SiteProjet";
    $conn->exec($use);
    $sql = "SELECT idUser FROM Utilisateur WHERE UPPER(nom) = ? AND UPPER(prenom) = ? LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->execute([strtoupper($nom), strtoupper($prenom)]);

    $id = $stmt->fetchColumn();

    if ($id) {
        echo $id;
    } else {
        $sql2 = "SELECT idUser FROM Utilisateur WHERE UPPER(nom) = ? AND UPPER(prenom) = ? LIMIT 1";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->execute([strtoupper($prenom), strtoupper($nom)]);

        $id2 = $stmt2->fetchColumn();

        if ($id2) {
            echo $id2;
        } else {
            echo "";
        }
    }



?>
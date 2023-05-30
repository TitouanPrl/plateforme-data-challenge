<?php 

    //on cherche l'id correspondant au nom et prénom donnés

    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];

    $sql = "SELECT idUser FROM Utilisateur WHERE nom=$nom AND prenom=$prenom LIMIT 1";
    $use = "use SiteProjet";
    $conn->exec($use);
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if (!$stmt) {  //on essaye de voir si nom et prenom ont été inversés
        $sql2 = "SELECT idUser FROM Utilisateur WHERE nom=$prenom AND prenom=$nom LIMIT 1";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->execute();
        if (!$stmt2) {
            echo NULL;
        } else {
            $id = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            echo $id;
        }
    } else {
        $id = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            echo $id;
    }

?>
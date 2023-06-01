<?php

// fonction qui permet d'ajouter un jsonrésultat à un projet 
function addJsonResultat($conn,$idProjet,$jsonStatistiques) {
    try {
        $use = "use SiteProjet";
        $conn->exec($use);
        // s'il n'y a pas de résultat pour ce projet, on l'ajoute
        if (getJsonResultat($conn,$idProjet) == null) {
            $sql = "INSERT INTO Resultat (idProjet,jsonStatistiques) VALUES (:idProjet,:jsonStatistiques)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':idProjet', $idProjet);
            $stmt->bindParam(':jsonStatistiques', $jsonStatistiques);

            $stmt->execute();
        }
        // sinon on le modifie 
        else {
            $sql = "UPDATE Resultat SET jsonStatistiques = :jsonStatistiques WHERE idProjet = :idProjet";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':idProjet', $idProjet);
            $stmt->bindParam(':jsonStatistiques', $jsonStatistiques);

            $stmt->execute();
        }
    } catch (PDOException $e) {
        die('Erreur : '.$e->getMessage());
    }
}

/* Renvoie toutes les statistiques des projets d'un sujet (lequel est géré par et accessible par un gestionnaire (et les administrateurs évidemment)) sous un format json */
function getStatsProjets($conn, $idSujet) {
    $sql = "SELECT jsonResultat from Projet WHERE jsonResultat IS NOT NULL AND idSujet = $idSujet";
    $stats = request($conn,$sql);
    // Boucler dans stats pour ajouter chaque json dans jsonGlobal
    /* Un json type pour chaque projet a pour forme : 
    {
        nbFonctions:2,
        nbLignes:4,
        nbLignesMax:3,
        nbLignesMin:1,
        nbLignesMoy:2,
        Fonctions : {
            nomFonction1: 3,
            nomFOnction2: 1
        }
    }
    */

    /* Un json pour les statistiques globales a pour forme :
    {
        nbFonctions:10,
        nbLignes:60,
        nbLignesMax:8,
        nbLignesMin:3,
        nbLignesMoy:5.5,
    }
    */
    
    $nbLignesMax = 0;
    $nbLignesMin = PHP_INT_MAX;
    $nbFonctions = 0;
    $nbLignesMoy = 0;
    $nbLignes = 0;
    
    // Calcul des statistiques globales
    foreach ($stats as $stat) {
        $json = json_decode($stat['jsonResultat'],true);
        $nbLignes += $json['nbLignes'];
        $nbFonctions += $json['nbFonctions'];
        $nbLignesMoy += $nbLignes;
        if ($json['nbLignesMax'] > $nbLignesMax) {
            $nbLignesMax = $json['nbLignesMax'];
        }
        if ($json['nbLignesMin'] < $nbLignesMin) {
            $nbLignesMin = $json['nbLignesMin'];
        }
    }
    $nbLignesMoy = $nbLignesMoy/$nbFonctions;


    // création du json résultat pour les statistiques globales
    $jsonGlobal = array(
        'nbFonctions' => $nbFonctions,
        'nbLignes' => $nbLignes,
        'nbLignesMax' => $nbLignesMax,
        'nbLignesMin' => $nbLignesMin,
        'nbLignesMoy' => $nbLignesMoy
    );

    // conversion en json
    $jsonGlobal = json_encode($jsonGlobal);

    return $jsonGlobal;
}

function getJsonResultat($conn,$idProjet) {
    try {
        $use = "use SiteProjet";
        $conn->exec($use);
        $sql = "SELECT jsonStatistiques FROM Resultat WHERE idProjet = $idProjet";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['jsonStatistiques'];
    } catch (PDOException $e) {
        die('Erreur : '.$e->getMessage());
    }
}
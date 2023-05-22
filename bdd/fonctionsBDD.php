<?php

//variables de connexion
require_once('bddData.php');

$conn;

// Fonction de connexion
function connect() {
    global $conn, $servername, $username, $password, $bddname;
    $conn = mysqli_connect($servername, $username, $password, $bddname);
    if ($conn->connect_error) {
        return false;
    }
    return true;
}

// Fonction de déconnexion
function disconnect($conn) {
    $conn->close();
}

function request($conn,$sql) {
    $result = mysqli_query($conn, $sql);
    while ($ligne = $result->fetch_assoc()) {
        $tableau[] = $ligne;
    }
    return $tableau;
}

// On récupère les données d'une catégorie en fonction de l'id
function getPersonById($conn,$id) {
    $sql = "SELECT * FROM Utilisateur WHERE idUser=$id";
    $person = request($conn,$sql);
    return $person;
}

function getUserByType($conn,$fonction) {
    $sql = "SELECT * FROM Utilisateur WHERE fonction=$fonction";
    $people = request($conn,$sql);
    return $people;
}

function getAllUsers($conn) {
    $etudiants = getUserByType($conn,'USER');
    $gestion = getUserByType($conn,'GESTION');
    $admin = getUserByType($conn,'ADMIN');
    $users = array();
    $users[] = $etudiants;
    $users[] = $gestion;
    $users[] = $admin;

    return $users;
}

function getPodiumByIDSujet($conn, $idSujet) {
    $sql = "SELECT * FROM Podium WHERE idSujet=$idSujet";
    $podium = request($conn,$sql);

    return $podium;
}


//AJOUT D'UTILISATEURS
function addAdmin($nom,$prenom,$numTel,$email,$mdp) {
    $sql = "INSERT INTO Utilisateur (nom,prenom,numTel,email,mdp,fonction) VALUES ($nom,$prenom,,$numTel,$email,$mdp,'ADMIN')";
    mysqli_connect($conn,$sql);
}
function addGestion($nom,$prenom,$entreprise,$numTel,$email,$mdp,$dateD) {
    $sql = "INSERT INTO Utilisateur (nom,prenom,entreprise,numTel,email,mdp,dateD,fonction) VALUES ($nom,$prenom,$entreprise,$numTel,$email,$mdp,$dateD,'GESTION')";
    mysqli_connect($conn,$sql);
}
function addEtudiant($nom,$prenom,$numTel,$email,$mdp,$nivEtude,$ecole,$ville) {
    $sql = "INSERT INTO Utilisateur (nom,prenom,numTel,email,mdp,nivEtude,ville,ecole,fonction) VALUES ($nom,$prenom,$numTel,$email,$mdp,$nivEtude,$ville,$ecole,'USER')";
    mysqli_connect($conn,$sql);
}


//SUPPRESSION DE DONNÉES
function deleteUser($idUser) {
    $sql = "DELETE FROM Utilisateur WHERE idUser = $idUser";
    mysqli_connect($conn,$sql);
}
function deleteSujet($idSujet) {
    $sql = "DELETE FROM Sujet WHERE idSujet = $idSujet";
    mysqli_connect($conn,$sql);
}
function deleteEvenement($idEvenement) {
    $sql = "DELETE FROM Evenement WHERE idEvenement = $idEvenement";
    mysqli_connect($conn,$sql);
}
function deleteProjet($idProjet) {
    $sql = "DELETE FROM Projet WHERE idProjet = $idProjet";
    mysqli_connect($conn,$sql);
}
function deletePodium($idPodium) {
    $sql = "DELETE FROM Podium WHERE idPodium = $idPodium";
    mysqli_connect($conn,$sql);
}


//recup tous les sujets par challenge
//recup tous les challenge



?>
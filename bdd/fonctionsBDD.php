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

//RÉCUPÉRATION DES DONNÉES
function getPersonById($conn,$id) { //récupère toutes les infos d'une personne avec son id
    $sql = "SELECT * FROM Utilisateur WHERE idUser=$id";
    $person = request($conn,$sql);
    return $person;
}
function getUsersByType($conn,$fonction) { //récupère tous les utilisateurs d'une catégorie
    $sql = "SELECT * FROM Utilisateur WHERE fonction=$fonction";
    $users = request($conn,$sql);
    return $users;
}
function getAllUsers($conn) { //récupère tous les utilisateurs
    $etudiants = getUsersByType($conn,'USER');
    $gestion = getUsersByType($conn,'GESTION');
    $admin = getUsersByType($conn,'ADMIN');
    $users = array();
    $users[] = $etudiants;
    $users[] = $gestion;
    $users[] = $admin;

    return $users;
}
function getPodiumBySujet($conn, $idSujet) { //récupère le podium d'un sujet
    $sql = "SELECT * FROM Podium WHERE idSujet=$idSujet";
    $podium = request($conn,$sql);

    return $podium;
}
function getSujetByEvenement($idEvenement) { //récupère touts les sujets d'un évenement 
    $sql = "SELECT * FROM Sujet WHERE idEvenement=$idEvenement";
    $sujets = request($conn,$sql);

    return $sujets;
}
function getEvenements() { //récupère tous les évenements
    $sql = "SELECT * FROM Evenement";
    $evenements = request($conn,$sql);

    return $evenements;
}
function getTeamMembers($idEquipe) {  //récupère tous les membres d'une équipe
    $sql = "SELECT * FROM Equipe WHERE idEquipe = $idEquipe";
    $membres = request($conn,$sql);

    return $membres;
}
function getTeams() {
    $sql = "SELECT * FROM Equipe";
    $equipes = request($conn,$sql);

    return $equipes;
}
function getTeamsOnSujet($idSujet) { //récupère toutes les équipes ayant un projet proposé pour le sujet
    $sql = "SELECT idEquipe FROM Projet WHERE idSujet = $idSujet";
    $equipes = request($conn,$sql);

    return $equipes;
}



//AJOUT DE DONNÉES
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



?>
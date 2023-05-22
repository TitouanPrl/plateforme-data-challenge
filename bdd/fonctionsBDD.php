<?php

//variables de connexion
require_once('bddData.php');

$conn;

// CONNEXION / DÉCONNEXION
function connect() {
    global $conn, $servername, $username, $password, $bddname;
    $conn = mysqli_connect($servername, $username, $password, $bddname);
    if ($conn->connect_error) {
        return false;
    }
    return true;
}
function disconnect($conn) {
    $conn->close();
}



//REQUÊTE GÉNÉRALE
function request($conn,$sql) {
    $result = mysqli_query($conn, $sql);
    while ($ligne = $result->fetch_assoc()) {
        $tableau[] = $ligne;
    }
    return $tableau;
}
function send($conn,$sql) {
    mysqli_query($conn,$sql);
}



//RÉCUPÉRATION DES DONNÉES
function getUtilisateurById($conn,$id) { //récupère toutes les infos d'une personne avec son id
    $sql = "SELECT * FROM Utilisateur WHERE idUser=$id";
    $person = request($conn,$sql);
    return $person;
}
function getUtilisateurByFonction($conn,$fonction) { //récupère tous les utilisateurs d'une catégorie
    $sql = "SELECT * FROM Utilisateur WHERE fonction=$fonction";
    $users = request($conn,$sql);
    return $users;
}
function getAllUtilisateurs($conn) { //récupère tous les utilisateurs
    $etudiants = getUtilisateurByFonction($conn,'USER');
    $gestion = getUtilisateurByFonction($conn,'GESTION');
    $admin = getUtilisateurByFonction($conn,'ADMIN');
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
function getSujetById($idSujet) {
    $sql = "SELECT * FROM Sujet WHERE idSujet=$idSujet";
    $sujet = request($conn,$sql);

    return $sujet;
}
function getEvenements() { //récupère tous les évenements
    $sql = "SELECT * FROM Evenement";
    $evenements = request($conn,$sql);

    return $evenements;
}
function getEquipeMembers($idEquipe) {  //récupère tous les membres d'une équipe
    $sql = "SELECT idUser FROM Utilisateur WHERE idEquipe = $idEquipe";
    $membres = request($conn,$sql);

    return $membres;
}
function getEquipe($idEquipe) {  //renvoie nom, id et capitaine d'equipe
    $sql = "SELECT * FROM Equipe WHERE idEquipe=$idEquipe";
    $equipe = request($conn,$sql);

    return $equipe;
}
function getEquipes() { //récupère toutes les équipes
    $sql = "SELECT * FROM Equipe";
    $equipes = request($conn,$sql);

    return $equipes;
}
function getProjetsOnSujet($idSujet) { //récupère tous les projets proposé pour le sujet
    $sql = "SELECT idProjet FROM Projet WHERE idSujet = $idSujet";
    $projets = request($conn,$sql);

    return $projets;
}
function getEquipeByProjet($idProjet) { //récupère l'équipe attachée à un projet
    $sql = "SELECT idEquipe FROM Projet WHERE idProjet = $idProjet";
    $equipe = request($conn,$sql);

    return $equipe;
}

function getUtilisateursBySujet($idSujet) { //récupère tous les utilisateurs attachés à un sujet
    $projets = getProjetsOnSujet($idSujet);
    $equipes = array();
    foreach ($projets as $projet) {
        $equipes[] = getTeamByProjet($projet['idProjet']);
    }
    $utilisateurs = array();
    foreach ($equipes as $equipe) {
        $utilisateurs[] = getEquipeMembers($equipe['idEquipe']);
    }

    return $utilisateurs;
}
function getQuestionsOnQuestionnaire($idQuestionnaire) {  //récupère toutes les questions d'un questionnaire
    $sql = "SELECT * FROM Question WHERE idQuestionnaire = $idQuestionnaire";
    $questions = request($conn,$sql);

    return $questions;
}
function getReponsesOnQuestion($idQuestion) {  //renvoie les réponses de toutes les équipes à une question
    $sql = "SELECT * FROM Reponse WHERE idQuestion = $idQuestion";
    $reponses = request($conn,$sql);

    return $responses;
}
function getIdByNomPrenom($nom,$prenom) {   //renvoie l'id d'une personne depuis son nom/prénom
    $sql = "SELECT idUser FROM Utilisateur WHERE nom=$nom, prenom=$prenom";
    $id = request($conn,$sql);

    return $id;
}





//AJOUT DE DONNÉES
function addAdmin($nom,$prenom,$numTel,$email,$mdp) {
    $sql = "INSERT INTO Utilisateur (nom,prenom,numTel,email,mdp,fonction) VALUES ($nom,$prenom,,$numTel,$email,$mdp,'ADMIN')";
    send($conn,$sql);
}
function addGestion($nom,$prenom,$entreprise,$numTel,$email,$mdp,$dateD) {
    $sql = "INSERT INTO Utilisateur (nom,prenom,entreprise,numTel,email,mdp,dateD,fonction) VALUES ($nom,$prenom,$entreprise,$numTel,$email,$mdp,$dateD,'GESTION')";
    send($conn,$sql);
}
function addEtudiant($nom,$prenom,$numTel,$email,$mdp,$nivEtude,$ecole,$ville) {
    $sql = "INSERT INTO Utilisateur (nom,prenom,numTel,email,mdp,nivEtude,ville,ecole,fonction) VALUES ($nom,$prenom,$numTel,$email,$mdp,$nivEtude,$ville,$ecole,'USER')";
    send($conn,$sql);
}
function createQuestionnaire($idSujet) {
    $sql = "INSERT INTO Questionnaire (idSujet) VALUES ($idSujet)";
    send($conn,$sql);
}
function addQuestion($idQuestionnaire,$contenu) {
    $sql = "INSERT INTO Question (contenu,idQuestionnaire) VALUES ($contenu,$idQuestionnaire)";
    send($conn,$sql);
}
function addRéponse($idQuestion,$idEquipe,$contenu) {
    $sql = "INSERT INTO Reponse (contenu,idQuestion,idEquipe) VALUES ($contenu,$idQuestion,$idEquipe)";
    send($conn,$sql);
}
function addMessage($contenu, $idExpediteur, $idDestinataire) {
    $sql = "INSERT INTO Message (contenu,idExpediteur,idDestinataire) VALUES ($contenu,$idExpediteur,$idDestinataire)";
    send($conn,$sql);
}
function createEquipe($nom,$capitaine) {
    $sql = "INSERT INTO Equipe (nom,capitaine) VALUES ($nom,$capitaine)";
    send($conn,$sql);
}


//SUPPRESSION DE DONNÉES
function deleteUtilisateur($idUser) { //supprimer un utilisateur
    $sql = "DELETE FROM Utilisateur WHERE idUser = $idUser";
    send($conn,$sql);
}
function deleteSujet($idSujet) { //supprimer un sujet
    $sql = "DELETE FROM Sujet WHERE idSujet = $idSujet";
    send($conn,$sql);
}
function deleteEvenement($idEvenement) { //supprimer un évenement
    $sql = "DELETE FROM Evenement WHERE idEvenement = $idEvenement";
    send($conn,$sql);
}
function deleteProjet($idProjet) { //supprimer un projet
    $sql = "DELETE FROM Projet WHERE idProjet = $idProjet";
    send($conn,$sql);
}
function deletePodium($idPodium) { //supprimer un podium
    $sql = "DELETE FROM Podium WHERE idPodium = $idPodium";
    send($conn,$sql);
}
function deleteQuestionnaire($idQuestionnaire) {
    $sql = "DELETE FROM Questionnaire WHERE idQuestionnaire = $idQuestionnaire";
    send($conn,$sql);
}
function deleteQuestion($idQuestion) {
    $sql = "DELETE FROM Question WHERE idQuestion = $idQuestion";
    send($conn,$sql);
}
function deleteReponse($idReponse) {
    $sql = "DELETE FROM Reponse WHERE idReponse = $idReponse";
    send($conn,$sql);
}


//MODIFIER LES DONNÉES
function modifyAdmin($nom,$prenom,$numTel,$email,$mdp,$idUser) {
    $sql = "UPDATE Utilisateur SET (nom,prenom,numTel,email,mdp,fonction) = ($nom,$prenom,,$numTel,$email,$mdp,'ADMIN') WHERE idUser = $idUser";
    send($conn,$sql);
}
function modifyGestion($nom,$prenom,$entreprise,$numTel,$email,$mdp,$dateD,$idUser) {
    $sql = "UPDATE Utilisateur SET (nom,prenom,entreprise,numTel,email,mdp,dateD,fonction)=($nom,$prenom,$entreprise,$numTel,$email,$mdp,$dateD,'GESTION') WHERE idUser = $idUser";
    send($conn,$sql);
}
function modifyEtudiant($nom,$prenom,$numTel,$email,$mdp,$nivEtude,$ecole,$ville,$idUser) {
    $sql = "UPDATE Utilisateur SET (nom,prenom,numTel,email,mdp,nivEtude,ville,ecole,fonction) = ($nom,$prenom,$numTel,$email,$mdp,$nivEtude,$ville,$ecole,'USER') WHERE idUser = $idUser";
    send($conn,$sql);
} 
function addMembreEquipe($idEquipe,$idUser) {   //ajouter un membre dans l'équipe
    $sql = "UPDATE Utilisateur SET idEquipe = $idEquipe WHERE idUser = $idUser";
    send($conn,$sql);
}

?>
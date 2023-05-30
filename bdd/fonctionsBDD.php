<?php

//variables de connexion
require_once('bddData.php');

$conn;

// CONNEXION / DÉCONNEXION

function connect() {
    global $conn, $servername, $username, $password, $dbname;

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return true;
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        return false;
    }
}

function disconnect($conn) {
    $conn = null;
}


/*REQUÊTE GÉNÉRALE*/
function request($conn, $sql) {
    $use = "use SiteProjet";
    $conn->exec($use);
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return $rows;
}


function send($conn, $sql) {
    try {
        $use = "use SiteProjet";
        $conn->exec($use);
        $resultat = $conn->exec($sql);

    } catch (PDOException $e) {
        die('Erreur : '.$e->getMessage());
    }
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
function getSujetByEvenement($conn,$idEvenement) { //récupère touts les sujets d'un évenement 
    $sql = "SELECT * FROM Sujet WHERE idEvenement=$idEvenement";
    $sujets = request($conn,$sql);

    return $sujets;
}
function getSujetById($conn,$idSujet) {
    $sql = "SELECT * FROM Sujet WHERE idSujet=$idSujet";
    $sujet = request($conn,$sql);

    return $sujet;
}
function getEvenements($conn) { //récupère tous les évenements
    $sql = "SELECT * FROM Evenement";
    $evenements = request($conn,$sql);

    return $evenements;
}
function getEquipeMembers($conn,$idEquipe) {  //récupère tous les membres d'une équipe
    $sql = "SELECT idUser FROM Utilisateur WHERE idEquipe = $idEquipe";
    $membres = request($conn,$sql);

    return $membres;
}
function getEquipe($conn,$idEquipe) {  //renvoie nom, id et capitaine d'equipe
    $sql = "SELECT * FROM Equipe WHERE idEquipe=$idEquipe";
    $equipe = request($conn,$sql);

    return $equipe;
}
function getIDEquipeByCapitaineNom($conn,$capitaine,$nom) {
    $sql = "SELECT idEquipe FROM Equipe WHERE capitaine=$capitaine AND nom=$nom";
    $id = request($conn,$sql);

    return $id;
}
function getEquipes($conn) { //récupère toutes les équipes
    $sql = "SELECT * FROM Equipe";
    $equipes = request($conn,$sql);

    return $equipes;
}
function getProjetsOnSujet($conn,$idSujet) { //récupère tous les projets proposé pour le sujet
    $sql = "SELECT idProjet FROM Projet WHERE idSujet = $idSujet";
    $projets = request($conn,$sql);

    return $projets;
}
function getEquipeByProjet($conn,$idProjet) { //récupère l'équipe attachée à un projet
    $sql = "SELECT idEquipe FROM Projet WHERE idProjet = $idProjet";
    $equipe = request($conn,$sql);

    return $equipe;
}
function getQuestionnairesOnSujet($idSujet) {   //tous les qusetionnaires envoyés pour un sujet
    $sql = "SELECT * FROM Questionnaire WHERE idSujet = $idSujet";
    $questionnaires = request($conn,$sql);

    return $questionnaires;
}
function getIdByNomPrenom($conn,$nom,$prenom) {   //renvoie l'id d'une personne depuis son nom/prénom
    $sql = "SELECT idUser FROM Utilisateur WHERE nom=$nom, prenom=$prenom";
    $id = request($conn,$sql);

    return $id;
}
function getInscrits($idEvenement) {  //renvoie toutes les personnes inscrites à un évenement
    $sql = "SELECT idUser FROM Inscription WHERE idEvenement=$idEvenement";
    $inscrits = request($conn,$sql);

    return $inscrits;
}
function getMessages($conn) {
    $sql ="SELECT * FROM Messages";
    $messages = request($conn,$sql);

    return $messages;
}
function getConversations($conn) {
    $sql ="SELECT * FROM Conversation";
    $conversations = request($conn,$sql);

    return $conversations;
}

function getUtilisateursBySujet($conn,$idSujet) { //récupère tous les utilisateurs attachés à un sujet
    $projets = getProjetsOnSujet($conn,$idSujet);
    $equipes = array();
    foreach ($projets as $projet) {
        $equipes[] = getEquipeByProjet($conn,$projet['idProjet']);
    }
    $utilisateurs = array();
    foreach ($equipes as $equipe) {
        $utilisateurs[] = getEquipeMembers($conn,$equipe['idEquipe']);
    }

    return $utilisateurs;
}
function getQuestionsOnQuestionnaire($conn,$idQuestionnaire) {  //récupère toutes les questions d'un questionnaire
    $sql = "SELECT * FROM Question WHERE idQuestionnaire = $idQuestionnaire";
    $questions = request($conn,$sql);

    return $questions;
}
function getReponsesOnQuestion($conn,$idQuestion) {  //renvoie les réponses de toutes les équipes à une question
    $sql = "SELECT * FROM Reponse WHERE idQuestion = $idQuestion";
    $reponses = request($conn,$sql);

    return $reponses;
}
function getConversationById($conn,$idConv) {
    $sql = "SELECT * FROM Conversation WHERE idConversation = $idConv";
    $conversation = request($conn,$sql);

    return $conversation;
}
function getIDConversationByCoress($conn,$idExp,$idDest) {
    $sql = "SELECT idConversation FROM Conversation WHERE (idExpediteur = $idExp AND idDestinataire = $idDest) OR (idExpediteur = $idDest AND idDestinataire = $idExp) LIMIT 1";
    $id = request($conn,$sql);

    return $id;
}






//AJOUT DE DONNÉES
function addAdmin($conn,$nom,$prenom,$numTel,$email,$mdp) {
    $sql = "INSERT INTO Utilisateur (nom,prenom,numTel,email,mdp,fonction) VALUES (:nom,:prenom,:numTel,:email,:mdp,'ADMIN')";

    $use = "use SiteProjet";
    $conn->exec($use);

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':numTel', $numTel);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':mdp', $mdp);

    $stmt->execute();
}
function addGestion($conn,$nom,$prenom,$entreprise,$numTel,$email,$mdp,$dateD,$dateF) {
    $sql = "INSERT INTO Utilisateur (nom,prenom,entreprise,numTel,email,mdp,dateD,dateF,fonction) VALUES ($nom,$prenom,$entreprise,$numTel,$email,$mdp,$dateD,$dateF,'GESTION')";
    send($conn,$sql);
}
function addEtudiant($conn,$nom,$prenom,$numTel,$email,$mdp,$nivEtude,$ecole,$ville) {
    $sql = "INSERT INTO Utilisateur (nom,prenom,numTel,email,mdp,nivEtude,ville,ecole,fonction) VALUES ($nom,$prenom,$numTel,$email,$mdp,$nivEtude,$ville,$ecole,'USER')";
    send($conn,$sql);
}
function createQuestionnaire($conn,$idSujet,$dateD,$dateF) {
    $sql = "INSERT INTO Questionnaire (idSujet,dateD,dateF) VALUES ($idSujet,$dateD,$dateF)";
    send($conn,$sql);
}
function addQuestion($conn,$idQuestionnaire,$contenu) {
    $sql = "INSERT INTO Question (contenu,idQuestionnaire) VALUES ($contenu,$idQuestionnaire)";
    send($conn,$sql);
}
function addRéponse($conn,$idQuestion,$idEquipe,$contenu) {
    $sql = "INSERT INTO Reponse (contenu,idQuestion,idEquipe) VALUES ($contenu,$idQuestion,$idEquipe)";
    send($conn,$sql);
}
function addMessage($conn,$contenu, $idExpediteur, $idDestinataire) {
    try {
        $use = "use SiteProjet";
        $conn->exec($use);
        $sql = "INSERT INTO Messages (contenu,idExpediteur,idDestinataire) VALUES (:contenu,:idExpediteur,:idDestinataire)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':contenu', $contenu);
        $stmt->bindParam(':idExpediteur', $idExpediteur);
        $stmt->bindParam(':idDestinataire', $idDestinataire);

        $stmt->execute();
    } catch (PDOException $e) {
        die('Erreur : '.$e->getMessage());
    }
    
}
function addConversation($conn, $idExpediteur, $idDestinataire) {
    $sql = "INSERT INTO Conversation (idExpediteur,idDestinataire) VALUES ($idExpediteur,$idDestinataire)";
    send($conn,$sql);
}
function createEquipe($conn,$nom,$capitaine) {
    $sql = "INSERT INTO Equipe (nom,capitaine) VALUES ($nom,$capitaine)";
    send($conn,$sql);
}
function createEvenement($conn,$libelle,$descrip,$dateD,$dateF) {
    $sql = "INSERT INTO Evenement (libelle,descrip,dateD,dateF) VALUES ($libelle,$descrip,$dateD,$dateF)";
    send($conn,$sql);
}
function createSujet($conn,$idEvenement,$libelle,$descrip,$img,$telGerant,$emailGerant,$lienRessources) {
    $sql = "INSERT INTO Sujet (idEvenement,libelle,descrip,img,telGerant,emailGerant,lienRessources) VALUES ($idEvenement,$libelle,$descrip,$img,$telGerant,$emailGerant,$lienRessources)";
    send($conn,$sql);
}
function inscription($idUser,$idEvenement) {
    $sql = "INSERT INTO Inscription (idUser,idEvenement) VALUES ($idSujet,$idEvenement)";
    send($conn,$sql);
}



//SUPPRESSION DE DONNÉES
function deleteUtilisateur($conn,$idUser) { //supprimer un utilisateur
    $sql = "DELETE FROM Utilisateur WHERE idUser = $idUser";
    send($conn,$sql);
}
function deleteSujet($conn,$idSujet) { //supprimer un sujet
    $sql = "DELETE FROM Sujet WHERE idSujet = $idSujet";
    send($conn,$sql);
}
function deleteEvenement($conn,$idEvenement) { //supprimer un évenement
    $sql = "DELETE FROM Evenement WHERE idEvenement = $idEvenement";
    send($conn,$sql);
}
function deleteProjet($conn,$idProjet) { //supprimer un projet
    $sql = "DELETE FROM Projet WHERE idProjet = $idProjet";
    send($conn,$sql);
}
function deletePodium($conn,$idPodium) { //supprimer un podium
    $sql = "DELETE FROM Podium WHERE idPodium = $idPodium";
    send($conn,$sql);
}
function deleteQuestionnaire($conn,$idQuestionnaire) {
    $sql = "DELETE FROM Questionnaire WHERE idQuestionnaire = $idQuestionnaire";
    send($conn,$sql);
}
function deleteQuestion($conn,$idQuestion) {
    $sql = "DELETE FROM Question WHERE idQuestion = $idQuestion";
    send($conn,$sql);
}
function deleteReponse($conn,$idReponse) {
    $sql = "DELETE FROM Reponse WHERE idReponse = $idReponse";
    send($conn,$sql);
}
function desinscription($idUser,$idEvenement) {
    $sql = "DELETE FROM Inscription WHERE (idUser,idEvenement) = ($idSujet,$idEvenement)";
    send($conn,$sql);
}
function deleteMessage($conn,$idMessage) {
    $sql = "DELETE FROM Messages WHERE idMessage = $idMessage";
    send($conn,$sql);
}
function deleteConversation($conn,$idConversation) {
    $sql = "DELETE FROM Conversation WHERE idConversation = $idConversation";
    send($conn,$sql);
}


//MODIFIER LES DONNÉES
function modifyAdmin($conn,$nom,$prenom,$numTel,$email,$mdp,$idUser) {
    $sql = "UPDATE Utilisateur SET (nom,prenom,numTel,email,mdp,fonction) = ($nom,$prenom,,$numTel,$email,$mdp,'ADMIN') WHERE idUser = $idUser";
    send($conn,$sql);
}
function modifyGestion($conn,$nom,$prenom,$entreprise,$numTel,$email,$mdp,$dateD,$idUser) {
    $sql = "UPDATE Utilisateur SET (nom,prenom,entreprise,numTel,email,mdp,dateD,fonction)=($nom,$prenom,$entreprise,$numTel,$email,$mdp,$dateD,'GESTION') WHERE idUser = $idUser";
    send($conn,$sql);
}
function modifyEtudiant($conn,$nom,$prenom,$numTel,$email,$mdp,$nivEtude,$ecole,$ville,$idUser) {
    $sql = "UPDATE Utilisateur SET (nom,prenom,numTel,email,mdp,nivEtude,ville,ecole,fonction) = ($nom,$prenom,$numTel,$email,$mdp,$nivEtude,$ville,$ecole,'USER') WHERE idUser = $idUser";
    send($conn,$sql);
} 
function addMembreEquipe($conn,$idEquipe,$idUser) {   //ajouter un membre dans l'équipe
    $sql = "UPDATE Utilisateur SET idEquipe = $idEquipe WHERE idUser = $idUser";
    send($conn,$sql);
}
function modifyEvenement($conn,$idEvenement,$libelle,$descrip,$dateD,$dateF) {
    $sql = "UPDATE Evenement SET (libelle,descrip,dateD,dateF) = ($libelle,$descrip,$dateD,$dateF) WHERE idEvenement = $idEvenement";
    send($conn,$sql);
}
function modifySujet($conn,$idSujet,$idEvenement,$libelle,$descrip,$img,$telGerant,$emailGerant,$lienRessources) {
    $sql = "UPDATE Sujet SET (idEvenement,libelle,descrip,img,telGerant,emailGerant,lienRessources) = ($idEvenement,$libelle,$descrip,$img,$telGerant,$emailGerant,$lienRessources) WHERE idSujet = $idSujet";
    send($conn,$sql);
}
function setNote($idReponse,$note) { // définir la note de la réponse à une question
    $sql = "UPDATE Reponse SET note = $note WHERE idReponse = $idReponse";
    send($conn,$sql);
}
function deleteMembreEquipe($conn,$idUser) {
    $sql = "UPDATE Utilisateur SET idEquipe = NULL WHERE idUser = $idUser";
    send($conn,$sql);
}

?>
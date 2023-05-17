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


// On récupère les données d'une catégorie en fonction de l'id
function getPersonById($conn,$id) {
    $sql = "SELECT * FROM Produit WHERE idProduit=$id";
    $result = mysqli_query($conn, $sql);
    $produit = mysqli_fetch_assoc($result);
    return $produit;
    
}




?>
<?php 
$user=$_GET['user'];
$event=$_GET['Event'];
$sujet=$_GET['Sujet'];
$projet=$_GET['Projet'];
require_once '../../bdd/fonctionsBDD.php';
connect(); 

if(!empty($user)){
    deleteUtilisateur($conn,$user);
}
if(!empty($event)){
    deleteEvenement($conn,$event);
}
if(!empty($sujet)){
    deleteSujet($conn,$sujet);
}
if(!empty($projet)){
    deleteProjet($conn,$projet);
}
header("location:accueilAdmin.php");

?>
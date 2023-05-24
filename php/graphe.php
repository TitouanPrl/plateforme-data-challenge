<?php
$json = file_get_contents('../json/info.json');
$nameFichier= json_decode($json, true);

$_SESSION['donnees']=$donnees;

foreach($_SESSION['donnees'] as $element => $nameFichier){
    foreach($nameFichier as $nameFonction => $newLigne){
        echo"nom du fichier: $nameFichier, nombre de lignes: .$newLigne";
    }
}
?>
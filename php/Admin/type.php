<?php session_start() ?>


<?php
  $admin = $_POST['admin'];
  $gestionnaire = $_POST['gestionnaire'];
  $etudiant = $_POST['etudiant'];
  $valider= $_POST['valider'];
  if(isset($valider)){
    if(!empty($admin) && $admin != ""){
        $_SESSION["type"]=$admin;
        
    }
    if(!empty('gestionnaire') && $gestionnaire != ""){
        $_SESSION["type"]=$gestionnaire;
    }
    if(!empty('etudiant') && $etudiant !=""){
        $_SESSION["type"] = $etudiant;
    }
    header('location:formInsc.php');
  }
  echo($_SESSION["type"]);
?>
<h2>Gestion des utilisateurs</h2>

<main>
    <article>
      <!-- INSCRIPTION D'un utilisateur -->
      <div id="inscription">
        <h2>Inscription utilisateur</h2>

        <form method="POST">
        <div id="formfunction">
            <fieldset>
                <legend>
                    Quel type de compte souhaitez vous ajouter ?
                </legend>
                    Administrateur : <input type="radio" id="admin" name="admin" value="administrateur"> 
                    Gestionnaire : <input type="radio" id="type" name="gestionnaire" value="gestionnaire">
                    Étudiant :<input type="radio" id="type" name="etudiant" value= "etudiant"><br>
                    <input type="submit" id="valider" name="valider" value='valider'>
          </fieldset>
        </div>
</main>


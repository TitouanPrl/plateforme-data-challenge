<?php 
    require '../Integrations/headerAdmin.php'; 

    session_start() ;

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

?>




<div class="bordure"></div>
<div class="corps">
  <div class="back-button">
    <a href="accueilAdmin.php" class="fleche"></a>
  </div>
  <main>
    <div style="display:flex; justify-content:center;align-items:center;">
      <!-- INSCRIPTION D'un utilisateur -->
        <div id="inscriptionU">
            <h2 class="titreForm">Inscription utilisateur</h2>

            <form method="POST">
                <div id="formfunction">
                    <fieldset>
                        <legend>
                            Quel type de compte souhaitez-vous ajouter ?
                        </legend>
                        <div class="choixType">Administrateur  <input type="radio" id="admin" name="admin" value="administrateur"> </div>
                        <div class="choixType">Gestionnaire  <input type="radio" id="gestionnaire" name="gestionnaire" value="gestionnaire"></div>
                        <div class="choixType">Étudiant  <input type="radio" id="etudiant" name="etudiant" value= "etudiant"></div><br>
                        <input type="submit" class="boutonForm" id="valider" name="valider" value='Valider'>
                </fieldset>
                </div>
            </form>
        </div>
    </div>
  </main>
</div>

<?php require '../Integrations/footer.php'; ?>





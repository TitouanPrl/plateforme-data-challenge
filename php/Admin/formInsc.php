<?php session_start() ?>
<?php require '../Integrations/headerVanilla.php'; ?>
<?php $type=$_SESSION["type"]; ?>


<div class="bordure"></div>


<div class="corps">
    <div class="back-button">
      <a href="type.php" class="fleche"></a>
    </div>
    <div style="display:flex; justify-content:center;align-items:center;">

      <!-- INSCRIPTION D'un utilisateur -->
      <div id="inscriptionU">
        <h2>Inscription utilisateur</h2>

        <form action="VerifForm.php" method="POST">
          <div style="display:flex; justify-content:center;align-items:center">
            <div id="formG">
              <fieldset>
                <legend>Nom</legend>
                <input type="text" id="nom" name="nom" value="<?php echo ($_GET['nom']); ?>" required pattern="[A-Z][A-Za-z]+"> <br>
              </fieldset>

              <fieldset>
                <legend>Prénom</legend>
                <input type="text" id="prenom" name="prenom" value="<?php echo ($_GET['prenom']); ?>" required pattern="[A-Z][A-Za-z]+"> <br>
              </fieldset>

              <fieldset>
                <legend>E-mail</legend>
                <input type="email" id="mail" name="mail" value="<?php echo ($_GET['mail']); ?>" required> <br>
              </fieldset>

              <fieldset>
                <legend>Telephone</legend>
                <input type="tel" id="tel" name="tel" value="<?php echo($_GET['tel']); ?>" required>
              </fieldset>
            
              <fieldset>
                <legend>Ville</legend>
                <input type="text" id="ville" name="ville" value="<?php echo ($_GET['ville']); ?>" required pattern="[A-Z][A-Za-z]+"> <br>
              </fieldset>
            </div>

            <div id="formD">
              <fieldset id="nivEtu">
                <legend> Degré d'étude :</legend>
                <select name="nivEtude" id="nivEtude" >
                  <option value=""> <?php echo ($_GET['nivEtude']); ?></option>
                  <option value="L1">1ère année de Licence</option>
                  <option value="L2">2ème année de Licence</option>
                  <option value="L3">3ème année de Licence</option>
                  <option value="M1">1ère année de Master</option>
                  <option value="M2">2ème année de Master</option>
                  <option value="D">Doctorat</option>
                </select>
                <br>
              </fieldset>

              <fieldset id='school'>
                <legend>Ecole</legend>
                <input type="text" id="ecole" name="ecole" value="<?php echo ($_GET['ecole']); ?>"> <br>
              </fieldset>

              <img id="gif" src="../../img/montagne.gif">

              <fieldset id='entrep'>
                <legend>Entreprise</legend>
                <input type="text" id="entreprise" name="entreprise" value="<?php echo ($_GET['entreprise']); ?>"> <br>
              </fieldset>

              <fieldset id='dateF'>
                <legend>Date de fin du compte</legend>
                <input type="date" id="dateFin" name="dateFin" value="<?php echo ($_GET['dateFin']);?>" > <br>
              </fieldset>

              
            </div>
          </div>
        <input type="submit" class="boutonForm" style="margin-top:0;" value="Valider" style="align-self:center;">
        </form>
      </div>
</div>
</div>

  <?php
  
  if(!empty($type))
  {?>
  <script type="text/javascript">
      administrateur = 1;
      etudiant =2;
      gestionnaire =3;
      var $type=<?php echo $type; ?>;
      if($type == 2){
          //on cache les fieldset correspondant a gestionnaires
          document.getElementById('entrep').style.visibility="hidden";
          document.getElementById('dateF').style.visibility="hidden";
      }
      if($type == 3){
          //si c'est un gestionnaire on cache les fieldset d'étudiant
          document.getElementById('school').style.visibility="hidden";
          document.getElementById('nivEtu').style.visibility="hidden";
      }
      if($type == 1){
        document.getElementById('entrep').style.visibility="hidden";
        document.getElementById('dateF').style.visibility="hidden";
        document.getElementById('school').style.visibility="hidden";
        document.getElementById('nivEtu').style.visibility="hidden";
      }
  </script>
 
<?php
 
} // on referme la condition Php
 
?>
      <!-- faire apparaitre les champs en fonction de la checkbox et faire gaffe aux champs apparent  -->
<?php require '../Integrations/footer.php'; ?>
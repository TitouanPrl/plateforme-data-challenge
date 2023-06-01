<?php require '../Integrations/headerVanilla.php'; ?>
<?php if (isset($_GET['user'])) {
    $idUser=$_GET['user'];
    }
 ?>
<?php 
    $_SESSION["idUser"] = $idUser;
    var_dump($_SESSION["idUser"]);
    ?>
<main>
    <?php 
    /* On inclut les fonctions de manipulation de la BDD */
    require_once("../../bdd/fonctionsBDD.php");

    connect();
    $user=getUtilisateurById($conn,$idUser);
    $type=$user[0]['fonction'];
    ?>
    <article>
      <!-- INSCRIPTION D'un utilisateur -->
      <div id="inscription">
        <h2>Profil utilisateur</h2>

        <form action="VerifForm.php" method="POST">
          <div id="form">
            <div id="formG">
              <fieldset>
                <legend>Nom</legend>
                <input type="text" id="nom" name="nom" value="<?php echo ($user[0]['nom']); ?>" required pattern="[A-Z][A-Za-z]+"> <br>
              </fieldset>

                  <fieldset>
                    <legend>Prénom</legend>
                    <input type="text" id="prenom" name="prenom" value="<?php echo ($user[0]['prenom']); ?>" required pattern="[A-Z][A-Za-z]+"> <br>
                  </fieldset>

                  <fieldset>
                    <legend>E-mail</legend>
                    <input type="email" id="mail" name="mail" value="<?php echo ($user[0]['email']); ?>" required> <br>
                  </fieldset>

              <fieldset>
                <legend>Telephone</legend>
                <input type="tel" id="tel" name="tel" value="<?php echo($user[0]['numTel']); ?>" required>
              </fieldset>
            
            <fieldset>
                <legend>Ville</legend>
                <input type="text" id="ville" name="ville" value="<?php echo ($user[0]['ville']); ?>" required pattern="[A-Z][A-Za-z]+"> <br>
              </fieldset>
              </div>

            <div id="formD">
              <fieldset id="nivEtu">
                <legend> Degré d'étude :</legend>
                <select name="nivEtude" id="nivEtude" >
                  <option value=""> <?php echo ($user[0]['nivEtude']); ?></option>
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
                <input type="text" id="ecole" name="ecole" value="<?php echo ($user[0]['ecole']); ?>"> <br>
              </fieldset>

              <fieldset id='entrep'>
                <legend>Entreprise</legend>
                <input type="text" id="entreprise" name="entreprise" value="<?php echo ($user[0]['entreprise']); ?>"> <br>
              </fieldset>

              <fieldset id='dateF'>
                <legend>Date de fin du compte</legend>
                <input type="date" id="dateFin" name="dateFin" value="<?php echo ($user[0]['dateF']);?>" > <br>
              </fieldset>

              <input type="submit" class="boutonForm" value="Valider" style="align-self:center;">
            </div>
          </div>
        </form>
      </div>
    </article>
  </main>

  <?php
  
  if(!empty($type))
  {?>
  <script type="text/javascript">
      ADMIN = 1;
      USER =2;
      GESTION =3;
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
        //on ne garde que les fieldset nécessaire a l'Admin
        document.getElementById('entrep').style.visibility="hidden";
        document.getElementById('dateF').style.visibility="hidden";
        document.getElementById('school').style.visibility="hidden";
        document.getElementById('nivEtu').style.visibility="hidden";
      }
  </script>
 
<?php
} 
?>
<?php require '../Integrations/footer.php'; ?>
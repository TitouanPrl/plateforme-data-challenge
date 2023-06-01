<?php require '../Integrations/headerAdmin.php'; ?>
<?php if (isset($_GET['Sujet'])) {
    $idSujet=$_GET['Sujet'];
    }
 ?>
<div class="bordure"></div>
<div class="corps">
  <div class="back-button">
    <a href="accueilAdmin.php" class="fleche"></a>
  </div>
  <main>
     <?php 
    /* On inclut les fonctions de manipulation de la BDD */
    require_once("../../bdd/fonctionsBDD.php");

    connect();
    $sujet=getSujetById($conn,$idSujet);
    ?>
    <div style="display:flex; justify-content:center;align-items:center;padding-top:70px;">
            <div id="inscription">
              <h2 class="titreForm" style="padding-bottom:0;"> Créer un sujet</h2>

              <form action="VerifFormSujet.php" method="POST">
                <div style="display:flex; justify-content:center;align-items:center">

                  <div id="formG">
                    <div id="form">           
                      <fieldset>
                        <legend>Libelle</legend>
                        <input type="text" id="libelle" name="libelle" value="<?php echo ($sujet[0]['libelle']); ?>" required pattern="[A-Z][A-Za-z]+"> <br>
                      </fieldset>

                      <fieldset>
                          <legend>Description</legend>
                          <textarea id="Description" name="Description" rows="5" cols="40" value ="<?php echo($sujet[0]['descrip'])?>"><?php echo($sujet[0]['descrip'])?></textarea>
                      </fieldset>

                      <fieldset>
                        <legend>Tel du gérant</legend>
                        <input type="tel" id="telG" name="telG" value="<?php echo($sujet[0]['telGerant']); ?>" required>
                      </fieldset>

                      <fieldset>
                        <legend>Email du gérant</legend>
                        <input type="email" id="mailG" name="mailG" value="<?php echo($sujet[0]['emailGerant']); ?>" required>
                      </fieldset>
                    </div>
                  </div>

                  <div id="formD">
                    <fieldset>
                      <legend style="margin-bottom:10px;">Déposer un document</legend>
                      <form method="post" enctype="multipart/form-data" action="accueilAdmin.php">
                        <p style="color:var(--bleu-fond);">
                          Fichier 1 <input type="file" name="userfile[]"><br>
                          Fichier 2 <input type="file" name="userfile[]"><br>
                          Fichier 3 <input type="file" name="userfile[]"><br>
                          Fichier 4 <input type="file" name="userfile[]"><br>
                          Fichier 5 <input type="file" name="userfile[]"><br>
                        </p>
                        
                    </fieldset>
                  </div>
                </div>


                <input type="submit" class="boutonForm" value="Envoi" style="align-self:center;margin-top:0px">

              </form>
            </div>
          </div>
</div>
  </main>
</div>
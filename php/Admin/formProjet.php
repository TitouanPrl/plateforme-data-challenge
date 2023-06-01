<?php require '../Integrations/headerVanilla.php'; ?>

<div class="bordure"></div>
<div class="corps">
  <div class="back-button">
    <a href="accueilAdmin.php" class="fleche"></a>
  </div>
  <main>
    <div style="display:flex; justify-content:center;align-items:center;padding-top:70px;">
            <div id="inscription">
              <h2 class="titreForm" style="padding-bottom:0;"> Déposer un projet</h2>

              <form action="validInscription.php" method="POST">
                <div style="display:flex; justify-content:center;align-items:center">

                  <div id="formG">
                    <div id="form">           
                      <fieldset>
                        <legend>Libellé</legend>
                        <input type="text" id="libellé" name="libellé" value="<?php echo ($_GET['libellé']); ?>" required pattern="[A-Z][A-Za-z]+"> <br>
                      </fieldset>

                      <fieldset>
                        <legend>Description</legend>
                        <textarea id="Description" name="Description" rows="5" cols="40" value ="<?php echo($_GET['Commentaires'])?>">Ajouter un commentaire/sujet enfin ce que vous voulez quoi </textarea>
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

<?php require '../Integrations/footer.php'; ?>
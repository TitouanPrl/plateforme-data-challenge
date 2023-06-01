<?php require '../Integrations/headerAdmin.php'; ?>



<div class="bordure"></div>
<div class="corps">
  <div class="back-button">
    <a href="accueilAdmin.php" class="fleche"></a>
  </div>
  <main>
    <form enctype="multipart/form-data" action="VerifFormDC.php" method="POST">
    <div style="display:flex; justify-content:center;align-items:center;">
      <!-- création d'un data challenge -->
      <div id="inscriptionDC">
        <h2> Data Challenge</h2>
 
          <div id="formDC">
            <div id="formG">
              <fieldset>
                <legend>Libellé</legend>
                <input type="text" id="libelle" name="libelle" value="<?php echo ($_GET['libelle']); ?>" required pattern="[A-Z][A-Za-z]+"> <br>
              </fieldset>

              <fieldset>
                <legend>Date début</legend>
                <input type="date" id="DateDebut" name="DateDebut" value="<?php echo ($_GET['DateDebut']); ?>" required> <br>
              </fieldset>

              <fieldset>
                <legend>Date fin</legend>
                <input type="date" id="DateFin" name="DateFin" value="<?php echo ($_GET['DateFin']); ?>" required> <br>
              </fieldset>

              <fieldset>
                <legend>Heure début</legend>
                <input type="time" id="heureD" name="heureD" value="<?php echo($_GET['heureD']); ?>" required> <br>
              </fieldset>

              <fieldset>
                <legend>Heure fin</legend>
                <input type="time" id="heureF" name="heureF" value ="<?php echo($_GET['heureF']); ?>" required> <br>
              </fieldset>
            </div>
            <div id="formD">
              <fieldset>
                  <legend>Commentaires</legend>
                  <textarea id="Commentaires" name="Commentaires" rows="5" cols="40" value ="<?php echo($_GET['Commentaires'])?>"> </textarea>
              </fieldset>
              <fieldset>
                  <legend>Déposer un document</legend>
                      <input type="file" name="userfile[]" >
                      <br>
                      <input type="submit" class="boutonForm" value="Envoi">
              </fieldset>

            </div>
          </div>
        </form>
      </div>
    </div>
  </main>
</div>


<?php require '../Integrations/footer.php'; ?>
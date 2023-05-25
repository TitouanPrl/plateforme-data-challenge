<?php require '../Integrations/headerVanilla.php'; ?>


<div class="bordure"></div>
<div class="corps">
  <div class="back-button">
    <a href="accueilAdmin.php" class="fleche"></a>
  </div>
  <main>
    <article>
      <!-- création d'un data challenge -->
      <div style="display:flex; justify-content:center;align-items:center;padding-top:70px;">
        <div id="formProjet">
          <h2> Déposer un projet</h2>

          <form action="validInsc.php" method="POST">
            <div style="display:flex; justify-content:center;align-items:center">

              <div id="formG">
                <fieldset>
                  <legend>Libellé</legend>
                  <input type="text" id="libellé" name="libellé" value="<?php echo ($_GET['libellé']); ?>" required pattern="[A-Z][A-Za-z]+"> <br>
                </fieldset>

                <fieldset>
                  <legend>Déposer une image</legend>
                  <form method="post" enctype="multipart/form-data">
                  <input type="file" id="image" name="avatar" accept="image/png, image/jpeg">
                </fieldset>
              </div>

              <div id="formD">
                <fieldset>
                  <legend>Description</legend>
                  <textarea id="Description" name="Description" rows="5" cols="40" value ="<?php echo($_GET['Commentaires'])?>">Ajouter un commentaire/sujet enfin ce que vous voulez quoi </textarea>
                </fieldset>

                <fieldset>
                    <legend>Déposer un document</legend>
                    <form method="post" enctype="multipart/form-data">
                    <input type="file" id="file" name="fichier" multiple>
                </fieldset>

              </div>
            </div>

            <input type="submit" class="boutonForm" value="Valider" style="align-self:center;">

          </form>
        </div>
      </div>
    </article>
  </main>
</div>

<?php require '../Integrations/footer.php'; ?>
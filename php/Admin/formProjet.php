<?php require '../Integrations/headerVanilla.php'; ?>


<h2>Gestion des utilisateurs</h2>

<main>
    <article>
      <!-- création d'un projet -->
      <div id="inscription">
        <h2> Data challenge</h2>

          <div id="formProjet">
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

        </form>
      </div>
    </article>
  </main>

<?php require '../Integrations/footer.php'; ?>
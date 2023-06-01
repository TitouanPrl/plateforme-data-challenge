<?php require '../Integrations/headerVanilla.php'; ?>

<main>
    <article>
      <!-- création d'un projet -->
      <div id="inscription">
        <h2> Projet</h2>
        <form method="post" enctype="multipart/form-data" action="VerifFormProjet.php">
          <div id="formProjet">
            <div id="formG">
              <fieldset>
                <legend>Libelle</legend>
                <input type="text" id="libelle" name="libelle" value="<?php echo ($_GET['libelle']); ?>" required pattern="[A-Z][A-Za-z]+"> <br>
              </fieldset>

            <fieldset>
                <legend>Description</legend>
                <textarea id="Description" name="Description" rows="5" cols="40" value ="<?php echo($_GET['Description'])?>">Ajouter une Description</textarea>
            </fieldset>

            <fieldset>
              <legend>Tel du gérant</legend>
              <input type="tel" id="telG" name="telG" value="<?php echo($_GET['telGerant']); ?>" required>
            </fieldset>

            <fieldset>
              <legend>Email du gérant</legend>
              <input type="email" id="mailG" name="mailG" value="<?php echo($_GET['emailGerant']); ?>" required>
            </fieldset>

            <fieldset>
                <legend>Déposer un document</legend>
                  <p>
                    Fichier 1 : <input type="file" name="userfile[]"><br>
                    Fichier 2 : <input type="file" name="userfile[]"><br>
                    Fichier 3 : <input type="file" name="userfile[]"><br>
                    Fichier 4 : <input type="file" name="userfile[]"><br>
                    Fichier 5 : <input type="file" name="userfile[]"><br>
                  </p>
                  <input type="submit" value="Envoi">
            </fieldset>
          </div>

        </form>
      </div>
    </article>
  </main>
</div>


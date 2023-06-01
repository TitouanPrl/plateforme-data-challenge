<?php require '../Integrations/headerVanilla.php'; ?>


<main>
    <article>
      <!-- création d'un projet -->
      <div id="inscription">
        <h2> Projet</h2>

          <div id="formProjet">
            <div id="formG">
              <fieldset>
                <legend>Libellé</legend>
                <input type="text" id="libellé" name="libellé" value="<?php echo ($_GET['libellé']); ?>" required pattern="[A-Z][A-Za-z]+"> <br>
              </fieldset>

              
                <legend>Description</legend>
                <textarea id="Description" name="Description" rows="5" cols="40" value ="<?php echo($_GET['Commentaires'])?>">Ajouter un commentaire/sujet enfin ce que vous voulez quoi </textarea>
            </fieldset>

            <fieldset>
                <legend>Déposer un document</legend>
                <form method="post" enctype="multipart/form-data" action="VerifFormDC.php">
                  <p>
                    Fichier 1 : <input type="file" name="userfile[]"><br>
                    Fichier 2 : <input type="file" name="userfile[]"><br>
                    Fichier 3 : <input type="file" name="userfile[]"><br>
                    Fichier 4 : <input type="file" name="userfile[]"><br>
                    Fichier 5 : <input type="file" name="userfile[]"><br>
                  </p>
                  <input type="submit" value="Envoi">
                </form>
            </fieldset>
          </div>

        </form>
      </div>
    </article>
  </main>
</div>

<?php require '../Integrations/footer.php'; ?>
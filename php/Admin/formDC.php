<?php require '../Integrations/headerVanilla.php'; ?>


<h2>Gestion des utilisateurs</h2>

<main>
    <article>
      <!-- création d'un data challenge -->
      <div id="inscription">
        <h2> Data challenge</h2>

          <div id="formDC">
            <div id="formG">
              <fieldset>
                <legend>Libellé</legend>
                <input type="text" id="libellé" name="libellé" value="<?php echo ($_GET['libellé']); ?>" required pattern="[A-Z][A-Za-z]+"> <br>
              </fieldset>

              <fieldset>
                <legend>Date début</legend>
                <input type="date" id="dateDeb" name="dateDebut" value="<?php echo ($_GET['DateDeb']); ?>" required> <br>
              </fieldset>

              <fieldset>
                <legend>Date fin</legend>
                <input type="date" id="dateFin" name="dateFin" value="<?php echo ($_GET['DateFin']); ?>" required> <br>
              </fieldset>

              <fieldset>
                <legend>Heure début</legend>
                <input type="time" id="heureDeb" name="heureDebut" value="<?php echo($_GET['HeureDebut']); ?>" required> <br>
              </fieldset>

              <fieldset>
                <legend>Heure fin</legend>
                <input type="time" id="heureFin" name="heureFin" value ="<?php echo($_GET['HeureFin']); ?>" required> <br>
              </fieldset>

            <fieldset>
                <legend>Commentaires</legend>
                <textarea id="Com" name="Commentaires" rows="5" cols="40" value ="<?php echo($_GET['Commentaires'])?>">Ajouter un commentaire/sujet enfin ce que vous voulez quoi </textarea>
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
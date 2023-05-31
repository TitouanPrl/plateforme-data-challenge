<?php require '../Integrations/headerVanilla.php'; ?>
<div class="bordure"></div>
<div class="corps">
  <div class="back-button">
    <a href="accueilAdmin.php" class="fleche"></a>
  </div>
  <main>
    <article>
      <!-- création d'un data challenge -->
      <div style="display:flex; justify-content:center;align-items:center; padding-top:70px; ">
        <div id="inscriptionDC">
          <h2> Data challenge</h2>
            
          <form action="validInsc.php" method="POST">
            <div style="display:flex; justify-content:center;align-items:center;">
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
                <form method="post" enctype="multipart/form-data" action="accueilAdmin.php">
                    <input type="file" name="userfile" size="4000">
                    <br>
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



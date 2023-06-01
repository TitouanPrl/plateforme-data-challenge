<?php session_start() ?>
<?php require '../Integrations/headerVanilla.php'; ?>
<div class="bordure"></div>
<div class="corps">
  <div class="back-button">
    <a href="accueilAdmin.php" class="fleche"></a>
  </div>
<?php require_once '../../bdd/fonctionsBDD.php';
connect(); 
?>

<?php if (isset($_GET['DC'])) {
    $idevt=$_GET['DC'];
    }
    $Evenement=getChallengeByID($conn,$idevt);
    $_SESSION['idevt']=$idevt;
 ?>
<main>
<form enctype="multipart/form-data" action="ModifDC.php" method="POST">
<div style="display:flex; justify-content:center;align-items:center;">
      <!-- création d'un data challenge -->
      <div id="inscription">
        <h2> Data challenge</h2>

          <div id="formDC">
            <div id="formG">
              <fieldset>
                <legend>Libellé</legend>
                <input type="text" id="libelle" name="libelle" value="<?php echo ($Evenement[0]['libelle']); ?>" required pattern="[A-Z][A-Za-z]+"> <br>
              </fieldset>

              <fieldset>
                <legend>Date début</legend>
                <input type="date" id="DateDebut" name="DateDebut" value="<?php echo ($Evenement[0]['DateD']); ?>" required> <br>
              </fieldset>

              <fieldset>
                <legend>Date fin</legend>
                <input type="date" id="DateFin" name="DateFin" value="<?php echo ($Evenement[0]['DateF']); ?>" required> <br>
              </fieldset>

              <fieldset>
                <legend>Heure début</legend>
                <input type="time" id="heureD" name="heureD" value="<?php echo($Evenement[0]['heureD']); ?>" required> <br>
              </fieldset>

              <fieldset>
                <legend>Heure fin</legend>
                <input type="time" id="heureF" name="heureF" value ="<?php echo($Evenement[0]['heureF']); ?>" required> <br>
              </fieldset>

            <fieldset>
                <legend>Commentaires</legend>
                <textarea id="Commentaires" name="Commentaires" rows="5" cols="40" value ="<?php echo($Evenement[0]['descrip'])?>">Ajouter un commentaire </textarea>
            </fieldset>
            <fieldset>
                <legend>Déposer un document</legend>
                    <input type="file" name="userfile[]" >
                    <br>
                    <input type="submit" class="boutonForm" value="Envoi">
            </fieldset>
                <div></div>
                <legend>Ajouter un sujet</legend>
                <input type="button" class="boutonForm" id="plus" value="+" onclick="document.location.href='formProjet.php'";>
                </div>
            </div>
          </div>
        </form>
      </div>
    </article>
  </div>
</main>



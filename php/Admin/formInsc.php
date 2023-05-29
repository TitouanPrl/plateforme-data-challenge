<?php session_start() ?>
<?php require '../Integrations/headerVanilla.php'; ?>


<?php
  if($_SESSION["type"]=="administrateur"){
    echo('RGB t le plus bo PTHNUYDEGI');
  }
   echo($_SESSION["type"]);
?>
<h2>Gestion des utilisateurs</h2>


<main>
    <article>
      <!-- INSCRIPTION D'un utilisateur -->
      <div id="inscription">
        <h2>Inscription utilisateur</h2>

        <form action="validInscription.php" method="POST">
          <div id="form">
            <div id="formG">
              <fieldset>
                <legend>Nom</legend>
                <input type="text" id="nom" name="nom" value="<?php echo ($_GET['nom']); ?>" required pattern="[A-Z][A-Za-z]+"> <br>
              </fieldset>

              <fieldset>
                <legend>Prénom</legend>
                <input type="text" id="prenom" name="prenom" value="<?php echo ($_GET['prenom']); ?>" required pattern="[A-Z][A-Za-z]+"> <br>
              </fieldset>

              <fieldset>
                <legend>Mail</legend>
                <input type="email" id="mail" name="mail" value="<?php echo ($_GET['mail']); ?>" required> <br>
              </fieldset>

              <fieldset>
                <legend>Telephone</legend>
                <input type="tel" id="tel" name="tel" value="<?php echo($_GET['tel']); ?>" required>
              </fieldset>
            </div>

            <div id="formD">
              <fieldset id="nivEtude">
                <legend> Degré d'étude :</legend>
                <select name="nivEtude" id="nivEtude" >
                  <option value=""> <?php echo ($_GET['nivEtude']); ?></option>
                  <option value="L1">1ère année de Licence</option>
                  <option value="L2">2ème année de Licence</option>
                  <option value="L3">3ème année de Licence</option>
                  <option value="M1">1ère année de Master</option>
                  <option value="M2">2ème année de Master</option>
                  <option value="D">Doctorat</option>
                </select>
                <br>
              </fieldset>

              <fieldset id='ecole'>
                <legend>Ecole</legend>
                <input type="text" id="ecole" name="ecole" value="<?php echo ($_GET['ecole']); ?>"> <br>
              </fieldset>

              <fieldset id='entreprise'>
                <legend>Entreprise</legend>
                <input type="text" id="ecole" name="ecole" value="<?php echo ($_GET['entreprise']); ?>"> <br>
              </fieldset>

              <fieldset>
                <legend>Ville</legend>
                <input type="text" id="ville" name="ville" value="<?php echo ($_GET['ville']); ?>" required pattern="[A-Z][A-Za-z]+"> <br>
              </fieldset>

              <fieldset id='dateFin'>
                <legend>Date de fin du compte</legend>
                <input type="date" id="dateFin" name="dateFin" value="<?php echo ($_GET['dateFin']);?>" > <br>
              </fieldset>

            </div>
          </div>

          <input type="submit" id="submit" value="Valider">

        </form>
      </div>
    </article>
  </main>
      <!-- faire apparaitre les champs en fonction de la checkbox et faire gaffe aux champs apparent  -->
<?php require '../Integrations/footer.php'; ?>
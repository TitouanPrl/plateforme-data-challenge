<?php require '../Integrations/headerVanilla.php'; ?>


<h2>Gestion des utilisateurs</h2>

<main>
    <article>
      <!-- INSCRIPTION D'un utilisateur -->
      <div id="inscription">
        <h2>Inscription utilisateur</h2>

        <form action="validInsc.php" method="POST">
        <div id="formfunction">
            <fieldset>
                <legend>
                    Quel type de compte souhaitez vous ajouter ?
                </legend>
                <div>
                    <input type="radio" id="admin" name="function" value="<?php echo ($_POST['admin']); ?>"> 
                    <label for="admin">Adinistrateur</label>
                </div>
                <div>
                    <input type="radio" id="gestionnaire" name="function" value="<?php echo ($_POST['gestionnaire']); ?>">
                    <label for="gestionnaire">Gestionnaire</label>
                </div>
                <div> 
                    <input type="radio" id="etudiant" name="function" value= "<?php echo ($_POST['etudiant']); ?>">
                    <label for="etudiant">Etudiant</label>
                </div>
            </fieldset>
            
        </div>
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
              <fieldset>
                <legend> Degré d'étude :</legend>
                <select name="nivEtude" id="nivEtude" required>
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

              <fieldset>
                <legend>Ecole</legend>
                <input type="text" id="ecole" name="ecole" value="<?php echo ($_GET['ecole']); ?>"> <br>
              </fieldset>

              <fieldset>
                <legend>Entreprise</legend>
                <input type="text" id="ecole" name="ecole" value="<?php echo ($_GET['entreprise']); ?>"> <br>
              </fieldset>

              <fieldset>
                <legend>Ville</legend>
                <input type="text" id="ville" name="ville" value="<?php echo ($_GET['ville']); ?>" required pattern="[A-Z][A-Za-z]+"> <br>
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
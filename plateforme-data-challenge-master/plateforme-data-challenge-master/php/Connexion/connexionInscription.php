<?php
session_start();
require '../Integrations/headerVanilla.php'; ?>


<body>
  <!-- HEADER -->

  <header>
    <div class="bordure"></div>

    <?php
    /* Envoie un message correspondant à l'erreur de manipulation */
    if (isset($_GET['message'])) {
      switch ($_GET['message']) {
        case '1':
          echo "<p id='notif'>Il semblerait que vous n'ayiez pas rentré vos identifiants.</p>";
          break;

        case '2':
          echo "<p id='notif'>Il semblerait qu'il y ait une erreur dans vos identifiants ou que nous ne trouvions pas votre compte, êtes-vous bien inscrit ?</p>";
          break;

        case '3':
          echo "<p id='notif'>Le type d'utilisateur est indéfini, veuillez contacter un administrateur.</p>";
          break;

        case '4':
          echo "<p id='notif'>Votre inscription a bien été prise en compte !</p>";
        break;

        default:
          break;
      }
    }

    ?>

  </header>

  <!-- MAIN CONTENT -->

  <main>
    <div class="corps">

    
      <article>

        <div id="deuxForm">
          <!-- CONNEXION -->
          <div id="connexion">
            <h2 class="titreForm">Connexion</h2>

            <form action="verifConnexion.php" method="POST">
              <div id="form">
                <fieldset>
                  <legend>Identifiant</legend>
                  <input type="text" id="login" name="login" required> <br>
                </fieldset>
                <fieldset>
                  <legend>Mot de passe</legend>
                  <input type="password" id="mdp" name="mdp" required> <br>
                </fieldset>
              </div>
              <input type="submit" class="boutonForm" value="Valider">
            </form>
          </div>

          <!-- INSCRIPTION -->
          <div style="display:flex; justify-content:center;align-items:center;padding-top:70px;">
            <div id="inscription">
              <h2 class="titreForm"> Inscription</h2>

              <form action="validInscription.php" method="POST">
                <div style="display:flex; justify-content:center;align-items:center">

                  <div id="formG">
                    <div id="form">           
                    <fieldset>
                      <legend>Votre nom</legend>
                      <input type="text" id="nom" name="nom" value="<?php echo ($_GET['nom']); ?>" required pattern="[A-Z][A-Za-z]+"> <br>
                    </fieldset>
                    <fieldset>
                      <legend>Votre prénom</legend>
                      <input type="text" id="prenom" name="prenom" value="<?php echo ($_GET['prenom']); ?>" required pattern="[A-Z][A-Za-z]+"> <br>
                    </fieldset>
                    <fieldset>
                      <legend>Votre e-mail</legend>
                      <input type="email" id="mail" name="mail" value="<?php echo ($_GET['mail']); ?>" required> <br>
                    </fieldset>

                    <fieldset>
                      <legend>Votre numéro de téléphone</legend>
                      <input type="tel" id="tel" name="tel" value="<?php echo ($_GET['tel']); ?>" required patern = "[0-9]+">
                    </fieldset>
                  </div>
                  </div>

                  <div id="formD">
                    <fieldset>
                      <legend>Votre degré d'étude ?</legend>
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
                      <legend>Votre école</legend>
                      <input type="text" id="ecole" name="ecole" value="<?php echo ($_GET['ecole']); ?>"> <br>
                    </fieldset>
                    <fieldset>
                      <legend>Votre ville</legend>
                      <input type="text" id="ville" name="ville" value="<?php echo ($_GET['ville']); ?>" required pattern="[A-Z][A-Za-z]+"> <br>
                    </fieldset>

                  </div>
                </div>

                <input type="submit" class="boutonForm" value="Valider" style="align-self:center;">

              </form>
            </div>
          </div>

      </article>
    
    </div>
  </main>

  <?php require '../Integrations/footer.php'; ?>
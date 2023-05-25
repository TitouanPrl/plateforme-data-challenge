<?php require '../Integrations/headerVanilla.php'; ?>



<main>
    <div class="bordure"></div>
    <div class="corps">
        <div class="pageTab">
            <h1 style="padding-top:90px;">Accueil administrateur </h1>
            <h2>Gestion des utilisateurs</h2>
            <nav id="tab" style="padding-top:90px;">
                <a href="/php/Admin/formDC.php">Data Challenge</a>
                <a href="/php/Admin/formInsc.php">Inscription</a>
                <a href="/php/Admin/formProjet.php"> Projets</a>
            </nav>
        </div>
    </div>

    

    <!-- on pourra cliquer sur les différents user/dc/projet pour les modifier en tant qu'admin -->

  </main>
      <!-- faire apparaitre les champs en fonction de la checkbox et faire gaffe aux champs apparent  -->


<?php require '../Integrations/footer.php'; ?>
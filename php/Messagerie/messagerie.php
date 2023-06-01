
<?php 

session_start();


/* On choisit le header en fonction de la fonction de l'utilisateur */
if ($_SESSION['infoUser']["fonction"] == "ADMIN") {
    require '../Integrations/headerAdmin.php'; 
}

else if ($_SESSION['infoUser']['fonction'] == "GESTION") {
    require '../Integrations/headerGestion.php'; 
}

else if ($_SESSION['infoUser']['fonction'] == "USER") {
    require '../Integrations/headerEtudiant.php'; 
}

require_once "../../bdd/fonctionsBDD.php";
if (!connect()) {
    die('Erreur de connexion à la base de données');
}

function aff($variable) {
    echo '<pre style="color: black;">';
    var_dump($variable);
    echo '</pre>';
}

$users = getAllUtilisateurs($conn);


?>

<div class="bordure"></div>
<div class="corps">
    <main>
        <article>
            <div style="padding-top:40px; display:flex;flex-direction:column;align-items:center;height:980px;">
                <div id="titreMessagerie">
                    <h2 style="padding-left:39%;">Messagerie</h2>
                </div>
                <div class="messagerie" id="messagerie">
                    <div>
                        <input type="hidden" name="expediteur" id="expediteur" value="<?php echo $_SESSION['ID']; ?>">
                        <?php ?>
                        <input type="hidden" name="conv" id="conv" value="NULL">
                        <input type="hidden" name="idConv" id="idConv" value="NULL">

                    </div>

                    <div class="Utilisateur" id =Utilisateur>
                        <div style="margin-bottom:40px;">
                            <!--<input type="destinataire" name="destinataire" id="destinataire" class="barreDest" value="" placeholder="Votre destinataire...">-->
                            
                            <input list="choixDest" class="barreDest" id="destinataire" placeholder="Votre destinataire...">
                            <datalist id="choixDest">

                                <?php
                                    foreach ($users as $user) {
                                        $prenom = $user["prenom"];
                                        $nom = $user["nom"];
                                        $personne = $nom . " " . $prenom;
                                        echo('
                                        <option value="'. $personne .'">
                                        ');
                                    }
                                ?>
                            </datalist>
                            
                            <input type="button" id="newConv" class="boutonForm" value="Contacter" onclick="nouvelleConv()">
                        </div>
                    </div>


                    <input type="button" id="envoi" value="" onclick="message()" hidden>
                    <div class="messages" id="messages">
                        <h3 style="color:white;" id="currentConv" value=""></h3>
                        <!-- Les messages -->
                        <input type="text" name="barreEnvoie" id="barreEnvoi" value="" placeholder="Envoyer un message...">
                    </div>
                </div>
            </div>
        </article>
    </main>
</div>


<script src="../../script/messagerie.js"></script>

<?php require '../Integrations/footer.php'; ?>
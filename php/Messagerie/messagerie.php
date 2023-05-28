
<?php require '../Integrations/headerVanilla.php'; 
if (!connect()) {
    die('Erreur de connexion à la base de données');
}

function aff($variable) {
    echo '<pre style="color: white;">';
    var_dump($variable);
    echo '</pre>';
}

?>

<div class="bordure"></div>
<div class="corps">
    <div class="back-button">
        <a href="accueilAdmin.php" class="fleche"></a>
    </div>
    <main>
        <article>
            <div style="padding-top:40px; display:flex;flex-direction:column;align-items:center;height:980px;">
                <div id="titreMessagerie">
                    <h2 style="padding-left:39%;">Messagerie</h2>
                </div>
                <div class="messagerie" id="messagerie">
                    <div>
                        <input type="hidden" name="expediteur" id="expediteur" value="<?php echo $_SESSION["idUser"]; ?>">
                        <input type="hidden" name="conv" id="conv" value="NULL">
                    </div>

                    <div class="Utilisateur" id =Utilisateur>
                        <input type="destinataire" name="destinataire" id="destinataire" class="barreDest" value="" placeholder="Votre destinataire...">
                        <input type="button" id="newConv" class="boutonForm" value="Contacter" onclick="nouvelleConv()">
                        <?php 
                        $messages = getMessages($conn);
                        aff($messages);
                        ?>
                    </div>


                    <input type="button" id="envoi" value="" onclick="message()" hidden>
                    <div class="messages" id="messages">
                        <!-- Les messages -->
                        <input type="text" name="barreEnvoie" id="barreEnvoi" value="" placeholder="Envoyer un message...">
                    </div>
                </div>
            </div>
        </article>
    </main>
</div>

<script>
    //pour envoyer le message quand on appuie sur "entrée"
    var barre = document.getElementById("envoi");
    barre.addEventListener("keypress", function(event) {
        if (event.key === "Enter") {
            event.preventDefault();
            document.getElementById("envoi").click();
        }
    });
</script>


<?php require '../Integrations/footer.php'; ?>
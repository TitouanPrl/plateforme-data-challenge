
<?php require '../Integrations/headerVanilla.php'; ?>

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
                        <input type="hidden" name="e1" id="e1" value="<?php echo $_SESSION["login_fic"]; ?>">
                        <input type="hidden" name="conv" id="conv" value="NULL">
                    </div>

                    <div class="Utilisateur" id =Utilisateur>
                        <input type="eleve2" name="e2" id="e2" class="barreDest" value="" placeholder="Votre destinataire...">
                        <input type="button" name="" id="newConv" class="boutonForm" value="Contacter" onclick="nouvelleConv()">
                    </div>


                    <input type="button" id="envoi" value="" onclick="message()" hidden>
                    <div class="messages" id="messages">
                        <!-- Les messages -->
                        <input type="text" name="barreEnvoie" id="barreEnvoie" value="" placeholder="Envoyer un message...">
                    </div>
                </div>
            </div>
        </article>
    </main>
</div>

<?php require '../Integrations/footer.php'; ?>
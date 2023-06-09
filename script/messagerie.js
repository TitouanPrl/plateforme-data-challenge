var barreEnvoi = document.getElementById("barreEnvoi");

//permet d'envoyer le message en appuyant sur "entrée"
barreEnvoi.addEventListener("keypress", function(event) {
    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("envoi").click();
    }
});

//obtenir le nom et prénom depuis l'id
function nomTOid(destinataire) {
    return new Promise(function(resolve, reject) {
        let xhttp = new XMLHttpRequest();
        
        let nomPrenom = destinataire.split(" "); // Sépare la chaîne en nom et prénom

        xhttp.onreadystatechange = function() {
            if (this.readyState == 4) {
                if (this.status == 200) {

                    let id = this.responseText;
                    resolve(id);
 
                } else {
                    reject(new Error('Erreur lors de la requête AJAX'));
                }
            }
        }


        xhttp.open("POST", "nomTOid.php", true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send("nom=" + nomPrenom[0] + "&prenom=" + nomPrenom[1]);
    });
}

//obtenir les deux personnes correspondant depuis l'id de la conversation
function convTOids(idConv) {
    return new Promise(function(resolve, reject) {
        let xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState == 4) {
                if (this.status == 200) {

                    let ids = this.responseText;
                    resolve(ids);
                
                } else {
                    reject(new Error('Erreur lors de la requête AJAX'));
                }
            }
        }

        xhttp.open("POST", "convTOids.php", true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send("idConv=" + idConv);
    });
}


//obtenir nom prénom depuis l'id
function idTOnom(correspondant) {
    return new Promise(function(resolve, reject) {
        let xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    var nomPrenom = this.responseText;
                    resolve(nomPrenom); // Résoudre la promesse avec nomPrenom
                } else {
                    reject(new Error('Erreur lors de la requête AJAX'));
                }
            }
        }

        xhttp.open("POST", "idTOnom.php", true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send("id=" + correspondant);
    });
}


//=============================================================================================================================

//création d'une nouvelle conversation 
function nouvelleConv() {

    let xhttp = new XMLHttpRequest();
    let expediteur = document.getElementById('expediteur').value;
    let destinataire = document.getElementById('destinataire').value; //destinataire de la forme nom prénom

    async function asynNomPrenom() {
        try {
            //on obtient l'id du destinataire depuis son nom et son prénom
            let idDestinataire = await nomTOid(destinataire);
            //on remet rien dans la barre pour chercher 
            document.getElementById("destinataire").value = "";

            xhttp.onreadystatechange = function () {
                if(this.readyState == 4 && this.status == 200){
                    
                    //si on a trouvé l'id de la personne
                    if (idDestinataire != "") {
                        let idConv = this.responseText; 
                        document.getElementById('conv').value = idDestinataire;
            
                        let ajout = destinataire;  //nom et prénom à afficher en haut de la conv
                        let node = document.createElement("div");
                        let textnode = document.createTextNode(ajout);
                        node.appendChild(textnode);
                        console.log(idConv);
                        //quand on séléctionnera la conv en cliquant
                        node.setAttribute("onclick", "afficheConv('"+idConv+"')");
                        node.setAttribute("id", idConv);
                        node.setAttribute("class", "dest");
                        //on l'ajoute à la liste des conversations
                        document.getElementById("Utilisateur").appendChild(node);
                        
                        //on affiche la conv après l'avoir créée
                        afficheConv(idConv);

                    } else { //si la personne n'existe pas 
                        alert("Cette personne n'existe pas !");
                        return
                    }
        
                }
            }

            xhttp.open("POST", "creerConv.php", true);

            xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            if (destinataire != "") {
                xhttp.send("&expediteur=" + expediteur + "&destinataire=" + idDestinataire);
            }
        } catch (error) {
            console.error(error);
        }
    }
        
    asynNomPrenom();
}


//==================================================================================================================//


//permet de créer un message dans une conversation
function message(){
    if (document.getElementById('conv').value == "NULL" ) return;


    let xhttp = new XMLHttpRequest();
    let expediteur = document.getElementById('expediteur').value;
    let destinataire = document.getElementById('conv').value;

    xhttp.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200){

            let ajout = this.responseText;
            let node = document.createElement("div");
            let pnode = document.createElement("p");
            let textnode = document.createTextNode(ajout);
            pnode.appendChild(textnode);
            pnode.setAttribute("class", "textMess");
            node.setAttribute("id", index);
            node.appendChild(pnode);
            node.setAttribute("class", "droite");
            index++;


            document.getElementById("messages").appendChild(node);

            document.getElementById("barreEnvoi").value = "";
            document.getElementById("messages").appendChild(document.getElementById("barreEnvoi"));
            
            //ajout du bouton "poubelle" pour supprimer le message
            let button = document.createElement("img");
            button.setAttribute("src", "../../img/poubelle.png");
            button.setAttribute("class", "poubelle");
            button.setAttribute("onclick", "del(this)"); 
            button.setAttribute("id", index);    //on modifie son id pour pouvoir le passer en parametre de del avec this
            node.appendChild(button);

            document.getElementById("messages").scrollTop = document.getElementById("messages").scrollHeight;
            document.getElementById("barreEnvoi").focus();
        }
    }
    //ajout du message dans la bdd
    xhttp.open("POST", "insererMsg.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send("&expediteur=" + expediteur + "&destinataire=" + destinataire + "&contenu=" + document.getElementById('barreEnvoi').value);
}


//==================================================================================================================//



//affichage de la discution avec personne (actualisée)
function afficheConv(idConv) {

    async function asynNomPrenom() {
        try {

            //on récupère la variable depuis la promesse
            let corresp = await convTOids(idConv);
            let expediteur = document.getElementById('expediteur').value;
            document.getElementById('idConv').value = idConv;
            corresp = corresp.split('|');  //de la forme [id1,id2] depuis l'id de la conversation

            // on définit le destinataire dans 'conv'
            if (corresp[1] != expediteur) {
                let destinataire = corresp[1];
                document.getElementById('conv').value = destinataire;
            } else {
                let destinataire = corresp[0];
                document.getElementById('conv').value = destinataire;
            }

            document.getElementById("messages").remove();


            //initialisation de la nouvelle div "messages"
            let node = document.createElement("div");
            node.setAttribute("id", "messages");
            node.setAttribute("class", "messages");
            document.getElementById("messagerie").appendChild(node);

            let xhttp = new XMLHttpRequest();


            xhttp.onreadystatechange = function () {
                if(this.readyState == 4 && this.status == 200){

                    let messages = this.responseText.split('|');
                    if (!((messages.length == 1) && (messages[0] == ' '))) {
                        for(let msg of messages){
                            msg = JSON.parse(msg);
                            var idMessage = msg[0].idMessage;
                            var contenu = msg[0].contenu;
                            var idExpediteur = msg[0].idExpediteur;

                            let texte = contenu;
                            let node = document.createElement("div");
                            let textnode = document.createTextNode(texte);
                            let pnode = document.createElement("p");
                            pnode.appendChild(textnode);
                            pnode.setAttribute("class", "textMess");
                            node.appendChild(pnode);
                            node.setAttribute("id", idMessage);

                            if(idExpediteur == document.getElementById('expediteur').value){  //si on a envoyé le message
                                node.setAttribute("class", "droite");
                                //poubelle pour le supprimer
                                let button = document.createElement("img");
                                button.setAttribute("src", "../../img/poubelle.png");
                                button.setAttribute("class", "poubelle");
                                button.setAttribute("onclick", "del(this)");
                                button.setAttribute("id", idMessage);
                                node.appendChild(button);
                            } else {   //si on l'a reçu
                                node.setAttribute("class", "gauche");
                            }

                            document.getElementById("messages").appendChild(node);
                            
                        }
                    }
                }
                document.getElementById("messages").appendChild(barreEnvoi);
                document.getElementById("messages").scrollTop = document.getElementById("messages").scrollHeight;
            

                
            }

            xhttp.open("POST", "getDiscussion.php", true);
            xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhttp.send("&idConv="+ idConv);


        } catch (error) {
          console.error(error);
        }
    }
    
    asynNomPrenom();


}



//==================================================================================================================//


//permet de supprimer un message
function del(that) {

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200){
            let idConv = document.getElementById('idConv').value;
            afficheConv(idConv);
        }
    }

    xhttp.open("POST", "supprMsg.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send("&idMes="+ that.id);
}

//==================================================================================================================//


//affichage des conversations sur la gauche
let xhttp = new XMLHttpRequest();
let moi = document.getElementById('expediteur').value;
var index = 1;

xhttp.onreadystatechange = function () {
    if(this.readyState == 4 && this.status == 200){
        let conversations = JSON.parse(this.responseText);

        for(let conv of conversations){
            //parmi toutes les conversations dans la bdd, on prend celles où on participe
            if(conv[0].idExpediteur == moi || conv[0].idDestinataire == moi) {
                
                //contact à afficher en fonction de qui a créé la conversation
                let correspondant;
                if (conv[0].idExpediteur == moi) {
                    correspondant = conv[0].idDestinataire;
                } else {
                    correspondant = conv[0].idExpediteur;
                }

                async function asynNomPrenom() {
                    try {
                        //on récupère la variable depuis la promesse
                        var nomPrenom = await idTOnom(correspondant);

                        //informations générales de la conversation
                        let node = document.createElement("div");
                        let textnode = document.createTextNode(nomPrenom);
                        node.appendChild(textnode);
                        node.setAttribute("id", conv["idConversation"]);
                        node.setAttribute("onclick", "afficheConv('"+conv[0].idConversation+"')");
                        node.setAttribute("class", "dest");

                        let unite = document.createElement("div");
                        unite.setAttribute("id", "uneConv");
                        unite.appendChild(node);

                        document.getElementById("Utilisateur").appendChild(unite);
                                
                    } catch (error) {
                      console.error(error);
                    }
                }
                
                asynNomPrenom();
            }
        }
    }
}

xhttp.open("POST", "getConversation.php", true);
xhttp.send();


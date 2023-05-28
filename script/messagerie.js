

//création d'une nouvelle conversation 
function nouvelleConv() {

    let xhttp = new XMLHttpRequest();
    let expediteur = document.getElementById('expediteur').value;
    let destinataire = document.getElementById('destinataire').value;
    console.log(destinataire);
    document.getElementById("destinataire").value = "";
    xhttp.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200){

            let answer = this.responseText.split('|')
            document.getElementById('conv').value = answer[0];

            let ajout = destinataire;
            let node = document.createElement("div");
            let textnode = document.createTextNode(ajout);
            node.appendChild(textnode);


            node.setAttribute("onclick", "afficheConv('"+answer[1]+"')");
            node.setAttribute("id", answer[1]);
            node.setAttribute("class", "dest");

            document.getElementById("Utilisateur").appendChild(node);

            //ajout du logo "poubelle" pour supprimer la conversation
            let button = document.createElement("img");
            button.setAttribute("onclick", "delConv(this)");
            button.setAttribute("class","poubelleConv");
            button.setAttribute("src", "../img/poubelle.png");
            button.setAttribute("id", answer[1]);
            document.getElementById("Utilisateur").appendChild(button);

            afficheConv(answer[1]);
            
        }
    }

    xhttp.open("POST", "creerConv.php", true);

    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    if (destinataire != "") {
        xhttp.send("&expediteur=" + expediteur + "&destinataire=" + destinataire);
    }
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



            document.getElementById("messages").appendChild(node);

            document.getElementById("msg").value = "";
            document.getElementById("messages").appendChild(document.getElementById("barreEnvoie"));
            
            //ajout du bouton "poubelle" pour supprimer le message
            let button = document.createElement("img");
            button.setAttribute("src", "../img/poubelle.png");
            button.setAttribute("class", "poubelle");
            button.setAttribute("onclick", "del(this)");  //this fait référence à l'objet sur lequel l'évenement est appliqué
            button.setAttribute("id", index);    //on modifie son id pour pouvoir le passer en parametre de del avec this
            node.appendChild(button);

            document.getElementById("messages").scrollTop = document.getElementById("messages").scrollHeight;
            document.getElementById("msg").focus();
        }
    }

    //ajout du message dans la bdd
    xhttp.open("POST", "insererMsg.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send("&expediteur=" + expediteur + "&destinataire=" + destinataire + "&contenu=" + document.getElementById('barreEnvoie').value);
}


//==================================================================================================================//



//affichage de la discution avec personne (actualisée)
function afficheConv(idConv) {
    document.getElementById('conv').value = idConv;
    document.getElementById("messages").remove();


    //initialisation de la nouvelle div "messages"
    let node = document.createElement("div");
    node.setAttribute("id", "messages");
    node.setAttribute("class", "messages");
    document.getElementById("messagerie").appendChild(node);

    let xhttp = new XMLHttpRequest();


    xhttp.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200){
            if(this.responseText != "empty"){

                if (this.responseText != "NULL"){
                    let messages = this.responseText.split('|');
                    for(let msg of messages){

                        let texte = msg["contenu"];
                        let node = document.createElement("div");
                        let textnode = document.createTextNode(texte);
                        let pnode = document.createElement("p");
                        pnode.appendChild(textnode);
                        pnode.setAttribute("class", "textMess");
                        node.appendChild(pnode);
                        node.setAttribute("id", msg["idMessage"]);

                        if(msg["idExpediteur"] == document.getElementById('expediteur').value){  //si on a envoyé le message
                            node.setAttribute("class", "droite");
                            //poubelle pour le supprimer
                            let button = document.createElement("img");
                            button.setAttribute("src", "../img/poubelle.png");
                            button.setAttribute("class", "poubelle");
                            button.setAttribute("onclick", "del(this)");
                            button.setAttribute("id", msg["idMessage"]);
                            node.appendChild(button);
                        } else {   //si on l'a reçu
                            node.setAttribute("class", "gauche");
                        }

                        document.getElementById("messages").appendChild(node);
                        
                    }
                }
                document.getElementById("messages").appendChild(saveInput);
                document.getElementById("messages").scrollTop = document.getElementById("messages").scrollHeight;
            }

        }
    }

    xhttp.open("POST", "getDiscussion.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send("&idConv="+ idConv);
}



//==================================================================================================================//


//permet de supprimer un message
function del(that) {

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200){
            afficheConv(document.getElementById('conv').value);
        }
    }

    xhttp.open("POST", "supprMsg.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send("&idMes="+ that.id);
}


//==================================================================================================================//


//permet de supprimer une conversation (pas les messages, juste son affichage)
function delConv(that){
    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200){

            if(that.id == document.getElementById("conv").value){
                document.getElementById("messages").remove();
                
                //création d'une noubelle div "messages" vide
                let node = document.createElement("div");
                node.setAttribute("id", "messages");
                node.setAttribute("class", "messages");
                document.getElementById("messagerie").appendChild(node);

                document.getElementById("messages").appendChild(saveInput);
                document.getElementById("messages").scrollTop = document.getElementById("messages").scrollHeight;
            }
        }
    }

    xhttp.open("POST", "supprConv.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send("&idConv=" + that.id);
}


//==================================================================================================================//


//affichage des conversations sur la gauche
let xhttp = new XMLHttpRequest();
let moi = document.getElementById('expediteur').value;

xhttp.onreadystatechange = function () {
    if(this.readyState == 4 && this.status == 200){
        let conversations = this.responseText.split('|');

        for(let conv of conversations){

            //parmi toutes les conversations dans la bdd, on prend celles où on participe
            if(conv["idExpediteur"] == moi || conv["idDestinataire"] == moi) {
                
                //contact à afficher en fonction de qui a créé la conversation
                let correspondant;
                if (conv["idExpediteur"] == moi) {
                    correspondant = conv["idDestinataire"];
                } else {
                    correspondant = conv["idExpediteur"];
                }

                //infos globales de la conversation
                let node = document.createElement("div");
                let textnode = document.createTextNode(correspondant);
                node.appendChild(textnode);
                node.setAttribute("id", conv["idConversation"]);
                node.setAttribute("onclick", "afficheConv('"+conv["idConversation"]+"')");
                node.setAttribute("class", "dest");
                document.getElementById("Utilisateur").appendChild(node);
                
                //poubelle de la conversation
                let button = document.createElement("img");
                button.setAttribute("onclick", "delConv(this)");
                button.setAttribute("class", "poubelleConv");
                button.setAttribute("src", "../img/poubelle.png");
                button.setAttribute("id", conv["idConversation"]);
                document.getElementById("Utilisateur").appendChild(button);


            }
        }
    }
}

xhttp.open("POST", "getConversation.php", true);
xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhttp.send("&expediteur=" + moi);

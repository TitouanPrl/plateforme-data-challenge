

//pour envoyer le message quand on appuie sur "entrée"
var barre = document.getElementById("barreEnvoie");
barre.addEventListener("keypress", function(event) {
    if (event.key === "Enter") {
        event.preventDefault();
        document.getElementById("envoi").click();
    }
});


//création d'une nouvelle conversation 
function nouvelleConv() {

    let xhttp = new XMLHttpRequest();
    let e1 = document.getElementById('e1').value;
    let e2 = document.getElementById('e2').value;
    document.getElementById("e2").value = "";
    xhttp.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200){

            let answer = this.responseText.split('|')
            document.getElementById('conv').value = answer[1];

            if (answer[0] == "add") {

                let ajout = e2;
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

            else if (answer[0] == "Non") {
                alert("Cette personne n'existe pas");
            }

        }
    }

    xhttp.open("POST", "creerConv.php", true);

    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    if (e2 != "") {
        xhttp.send("eleve1=" + e1 + "&eleve2=" + e2);
    }
}



//==================================================================================================================//
//==================================================================================================================//

//permet de créer un message dans une conversation
function message(){
    if(document.getElementById('conv').value == "NULL" ) return;


    let xhttp = new XMLHttpRequest();
    let e1 = document.getElementById('e1').value;
    let adress = document.getElementById('conv').value;

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
            button.setAttribute("onclick", "del(this)");
            button.setAttribute("id", index);
            node.appendChild(button);

            document.getElementById("messages").scrollTop = document.getElementById("messages").scrollHeight;
            document.getElementById("msg").focus();
        }
    }

    //ajout du message dans la bdd
    xhttp.open("POST", "insererMsg.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send("emetteur=" + e1 + "&personne=" + adress + "&message=" + document.getElementById('barreEnvoie').value);
}


//==================================================================================================================//
//==================================================================================================================//



//affichage de la discution avec personne (actualisée)
function afficheConv(personne) {
    document.getElementById('conv').value = personne;
    document.getElementById("messages").remove();

    let node = document.createElement("div");
    node.setAttribute("id", "messages");
    node.setAttribute("class", "messages");
    document.getElementById("content").appendChild(node);

    let xhttp = new XMLHttpRequest();


    xhttp.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200){
            if(this.responseText != "empty"){

                index = 0;
                if (this.responseText != "NULL"){
                    let msgs = this.responseText.split('|');
                    for(let test of msgs){
                        let Message = JSON.parse(test);
                        if(Message.state == "visible"){

                            let ajout = Message.message;
                            let node = document.createElement("div");
                            let textnode = document.createTextNode(ajout);
                            let pnode = document.createElement("p");
                            pnode.appendChild(textnode);
                            pnode.setAttribute("class", "textMess");
                            node.appendChild(pnode);
                            node.setAttribute("id", index);

                            if(Message.emetteur == document.getElementById('e1').value){
                                node.setAttribute("class", "droite");
                                let button = document.createElement("img");
                                button.setAttribute("src", "../img/poubelle.png");
                                button.setAttribute("class", "poubelle");
                                button.setAttribute("onclick", "del(this)");
                                button.setAttribute("id", index);
                                node.appendChild(button);
                            } else {
                                node.setAttribute("class", "gauche");
                            }

                            document.getElementById("messages").appendChild(node);
                        }
                        index++;
                    }
                }
                document.getElementById("messages").appendChild(saveInput);
                document.getElementById("messages").scrollTop = document.getElementById("messages").scrollHeight;
            }

        }
    }

    xhttp.open("POST", "getDiscussion.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send("personne="+ personne);
}



//==================================================================================================================//
//==================================================================================================================//

function del(that) {

    let xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200){
            afficheConv(document.getElementById('conv').value);
        }
    }

    xhttp.open("POST", "supprMsg.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send("id="+ that.id +"&personne=" + document.getElementById('conv').value);
}


//==================================================================================================================//
//==================================================================================================================//

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
                document.getElementById("content").appendChild(node);

                document.getElementById("messages").appendChild(saveInput);
                document.getElementById("messages").scrollTop = document.getElementById("messages").scrollHeight;
            }
            let msg = that.id;
            document.getElementById(msg).remove();
            document.getElementsByName(msg)[0].remove();
            that.remove();

        }
    }

    xhttp.open("POST", "supprConv.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send("&personne=" + that.id);
}


//==================================================================================================================//
//==================================================================================================================//

//affichage de la conversation par défaut quand on arrive sur la messagerie
var index = 0;
let xhttp = new XMLHttpRequest();
let moi = document.getElementById('e1').value;

xhttp.onreadystatechange = function () {
    if(this.readyState == 4 && this.status == 200){
        let msgs = this.responseText.split('|');

        for(let test of msgs){

            let Message = JSON.parse(test);

            //on prend les conversations où on participe
            if(Message.eleve1 == moi || Message.eleve2 == moi) {

                let ajout;
                if (Message.eleve1 === moi) {
                    ajout = Message.eleve2;
                } else {
                    ajout = Message.eleve1;
                }

                
                let node = document.createElement("div");
                let textnode = document.createTextNode(ajout);
                node.appendChild(textnode);
                node.setAttribute("id", Message.personne);
                node.setAttribute("onclick", "afficheConv('"+Message.personne+"')");
                node.setAttribute("class", "dest");
                document.getElementById("Utilisateur").appendChild(node);

                let button = document.createElement("img");
                button.setAttribute("onclick", "delConv(this)");
                button.setAttribute("class", "poubelleConv");
                button.setAttribute("src", "../img/poubelle.png");
                button.setAttribute("id", Message.personne);
                document.getElementById("Utilisateur").appendChild(button);


            }
        }
    }
}

xhttp.open("POST", "getConversation.php", true);
xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhttp.send();

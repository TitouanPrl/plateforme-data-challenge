function getXHR() {
    var xhr = null;
    if (window.XMLHttpRequest)
       xhr = new XMLHttpRequest();
    else if (window.ActiveXObject) {
         try {
           xhr = new ActiveXObject("Msxml2.XMLHTTP");
         } catch (e) {
           xhr = new ActiveXObject("Microsoft.XMLHTTP");
         }
    } else {
       alert("Votre navigateur ne supporte pas AJAX");
       xhr = false;
    }
    return xhr;
}


/* ================================== *
*           CREATION EQUIPE           *
* =================================== */
function yes() {
    console.log("OUI BORDEL");
}

function createTeam(nom_prenom_cap) {
    console.log("CREATION EQUIPE");
    var xhr = getXHR();

    /* On récupère le nom de l'équipe et celui du challenge */
    var nomTeam = document.getElementById("nom_equipe").innerText;
    var challenge = document.getElementById("nom_challenge").innerText;

    /* Var deuxième user */
    var membre2 = document.getElementById("participant2").value;
    var idMembre2 = document.getElementById("participant2").dataID;

    /* Var troisième user */
    var membre3 = document.getElementById("participant3").value;
    var idMembre3 = document.getElementById("participant3").dataID;

    console.log(nomTeam);
    console.log(challenge);

    var myTeam = document.getElementById("monEquipe");
    var formEquipe = document.getElementById("creer_equipe");

    xhr.onreadystatechange = function () {

        /* On ajoute le capitaine à l'équipe dans l'affichage et on cache le form de création d'équipe */
        if (xhr.readyState == 4 && xhr.status == 200) {
            /* === On crée les lignes à ajouter et leurs différents éléments === */
            /* === CAPITAINE === */
            var newLine1 = document.createElement("div");
            newLine1.class = "ligne_equipe";
            newLine1.id = 0;

            /* Image de la couronne */
            var crown = document.createElement("img");
            crown.id = "logo_crown";
            crown.src = "../../img/logo_crown.png";
            crown.alt = "logo";

            /* Nom Prénom */
            var nom1 = document.createElement("span");
            nom1.class = "nom_teamMember";
            nom1.innerText = nom_prenom_cap;

            /* On insère les éléments dans la ligne */
            newLine1.appendChild(crown);
            newLine1.appendChild(nom1);


            /* === MEMBRE 2 === */
            var newLine2 = document.createElement("div");
            newLine2.id = 1;
            newLine2.onclick = "supprMemberTeam(1)"

            /* Nom Prénom */
            var nom2 = document.createElement("span");
            nom2.class = "nom_teamMember";
            nom2.id = idMembre2;
            nom2.innerText = membre2;

            /* On insère les éléments dans la ligne */
            newLine2.appendChild(nom2);


            /* === MEMBRE 3 === */
            var newLine3 = document.createElement("div");
            newLine3.id = 2;
            newLine3.onclick = "supprMemberTeam(2)"

            /* Nom Prénom */
            var nom3 = document.createElement("span");
            nom3.setAttribute("class", "nom_teamMember");
            nom3.setAttribute("id", "idMembre3");
            nom3.setAttribute("innerText", "membre3");

            /* On insère les éléments dans la ligne */
            newLine3.appendChild(nom3);

            /* On ajoute la ligne à l'équipe et on cache la ligne de création d'équipe */
            if (myTeam) {
                myTeam.appendChild(newLine1);
                myTeam.appendChild(newLine2);
                myTeam.appendChild(newLine3);
                formEquipe.style.visibility = "hidden";
            }
        }
    }

    /* UPDATE DES VARS SESSIONS ET DE LA BDD */
    xhr.open("POST", "gestionEquipe.php", true);
    xhr.setRequestHeader('Content-Type',
        'application/x-www-form-urlencoded;charset=utf-8');
    xhr.send("type=ajout" + "&nomTeam=" + nomTeam + "&challenge=" + challenge +"&idNewMember2=" + idMembre2 + "&idNewMember3=" + idMembre3);

}


/* ================================== *
*             AJOUT MEMBRE            *
* =================================== */

function addMemberTeam() {
    var xhr = getXHR();

    var membre = document.getElementById("participant").value;
    var idMembre = document.getElementById("participant").dataID;

    console.log(membre);
    console.log(idMembre);

    var myTeam = document.getElementById("listeEquipe");
    var listInscrits = document.getElementById("liste_participants");
    var memberToDelete = document.getElementsByName(idMembre);

    console.log(myTeam);
    console.log(listInscrits);
    console.log(memberToDelete);

    /* === On crée la ligne à ajouter et ses différents éléments === */
    var newLine = document.createElement("div");
    newLine.setAttribute("class", "ligne_equipe");

    /* On récupère le compteur du nb d'équipiers */
    compteur = parseInt(myTeam.lastChild.id);
    newLine.setAttribute("id", parseInt(compteur + 1));

    /* Nom Prénom */
    var nom = document.createElement("span");
    nom.setAttribute("class", "nom_teamMember");
    nom.setAttribute("id", idMembre);
    nom.innerText = membre;

    var img = document.createElement("img");
    img.setAttribute("class", "delete_button");
    img.setAttribute("src", "../../img/croix.png");
    img.setAttribute("onclick", "supprMemberTeam(" + parseInt(compteur + 1) + ")");
    img.setAttribute("alt", "I am an image");

    xhr.onreadystatechange = function () {

        if (xhr.readyState == 4 && xhr.status == 200) {

            /* On insère les éléments dans la ligne */
            newLine.appendChild(img);
            newLine.appendChild(nom);            

            /* S'il y a moins de 8 membres dans l'équipe on ajoute le nouveau membre */
            if (myTeam.childElementCount < 8) {

                /* On ajoute le membre à l'équipe */
                if (myTeam) {
                    myTeam.appendChild(newLine);
                }
                /* Et on le retire de la liste des participants disponibles */
                if (listInscrits) {
                    listInscrits.removeChild(memberToDelete);
                }
            }
        }
    }

    /* UPDATE DES VARS SESSIONS ET DE LA BDD */

    /* S'il y a moins de 8 membres dans l'équipe on effectue les modifications */
    if (myTeam.childElementCount < 8) {
        xhr.open("POST", "gestionEquipe.php", true);
        xhr.setRequestHeader('Content-Type',
            'application/x-www-form-urlencoded;charset=utf-8');
        xhr.send("val1=" + membre + "&type=ajout" + "&idUser=" + idMembre);
    }

}

/* ================================== *
*         SUPPRESSION MEMBRE          *
* =================================== */

function supprMemberTeam(nb) {
    var xhr = getXHR();

    var membre = document.getElementsByClassName("nom_teamMember")[nb].innerText;
    var idMembre = document.getElementsByClassName("nom_teamMember")[nb].id;

    console.log(membre);
    console.log(idMembre);

    var myTeam = document.getElementById("listeEquipe");
    var listInscrits = document.getElementById("liste_participants");
    var memberToDelete = document.getElementsByClassName("ligne_equipe")[nb];

    console.log(memberToDelete);
    console.log(myTeam.childElementCount);



    xhr.onreadystatechange = function () {

        if (xhr.readyState == 4 && xhr.status == 200) {
            /* On crée la ligne à ajouter et ses différents éléments */
            var newOption = document.createElement("option");
            newOption.setAttribute("value", membre);
            newOption.setAttribute("dataid", idMembre);

            /* S'il y a plus de 3 membres dans l'équipe on supprime le membre */
            if (myTeam.childElementCount > 3) {

                /* On met le membre dans la liste des participants disponibles */
                if (listInscrits) {
                    listInscrits.appendChild(newOption);
                }

                /* Et on le retire de l'équipe */
                if (myTeam) {
                    myTeam.removeChild(memberToDelete);
                }
            }
        }
    }

    /* UPDATE DES VARS SESSIONS ET DE LA BDD */

    /* S'il y a plus de 3 membres dans l'équipe on effectue les modificationss */
    if (myTeam.childElementCount > 3) {
        xhr.open("POST", "gestionEquipe.php", true);
        xhr.setRequestHeader('Content-Type',
            'application/x-www-form-urlencoded;charset=utf-8');
        xhr.send("val1=" + membre + "&type=suppr" + "&idUser=" + idMembre);
    }

}
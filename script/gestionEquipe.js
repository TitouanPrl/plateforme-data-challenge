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

function CreateTeam(nom_prenom_cap) {
    let xhr = getXHR();

    /* On récupère le nom de l'équipe et celui du challenge */
    let nomTeam = document.getElementById("nom_equipe").innerText;
    let challenge = document.getElementById("nom_challenge").innerText;

    /* Var deuxième user */
    let membre2 = document.getElementById("participant2").value;
    let idMembre2 = document.getElementById("participant2").dataID;

    /* Var troisième user */
    let membre3 = document.getElementById("participant3").value;
    let idMembre3 = document.getElementById("participant3").dataID;

    console.log(nomTeam);
    console.log(challenge);

    let myTeam = document.getElementById("monEquipe");
    let formEquipe = document.getElementById("creer_equipe");

    xhr.onreadystatechange = function () {

        /* On ajoute le capitaine à l'équipe dans l'affichage et on cache le form de création d'équipe */
        if (xhr.readyState == 4 && xhr.status == 200) {
            /* === On crée les lignes à ajouter et leurs différents éléments === */
            /* === CAPITAINE === */
            let newLine1 = document.createElement("div");
            newLine1.class = "ligne_equipe";
            newLine1.id = 0;

            /* Image de la couronne */
            let crown = document.createElement("img");
            crown.id = "logo_crown";
            crown.src = "../../img/logo_crown.png";
            crown.alt = "logo";

            /* Nom Prénom */
            let nom1 = document.createElement("span");
            nom1.class = "nom_teamMember";
            nom1.innerText = nom_prenom_cap;

            /* On insère les éléments dans la ligne */
            newLine1.appendChild(crown);
            newLine1.appendChild(nom1);


            /* === MEMBRE 2 === */
            let newLine2 = document.createElement("div");
            newLine2.id = 1;
            newLine2.onclick = "supprMemberTeam(1)"

            /* Nom Prénom */
            let nom2 = document.createElement("span");
            nom2.class = "nom_teamMember";
            nom2.id = idMembre2;
            nom2.innerText = membre2;

            /* On insère les éléments dans la ligne */
            newLine2.appendChild(nom2);


            /* === MEMBRE 3 === */
            let newLine3 = document.createElement("div");
            newLine3.id = 2;
            newLine3.onclick = "supprMemberTeam(2)"

            /* Nom Prénom */
            let nom3 = document.createElement("span");
            nom3.class = "nom_teamMember";
            nom3.id = idMembre3;
            nom3.innerText = membre3;

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
    let xhr = getXHR();

    let membre = document.getElementById("participant").value;
    let idMembre = document.getElementById("participant").dataID;

    console.log(membre);
    console.log(idMembre);

    let myTeam = document.getElementById("monEquipe");
    let listInscrits = document.getElementById("liste_participants");
    let memberToDelete = document.getElementsByName(idMembre);

    console.log(myTeam);
    console.log(listInscrits);
    console.log(memberToDelete);

    /* === On crée la ligne à ajouter et ses différents éléments === */
    let newLine = document.createElement("div");
    newLine.class = "ligne_equipe";
    
    /* On récupère le compteur du nb d'équipiers */
    compteur = parseInt(myTeam.lastChild.id);
    newLine.id = compteur + 1;
    newLine.onclick = "supprMemberTeam(" + compteur + 1 + ")"

    /* Nom Prénom */
    let nom = document.createElement("span");
    nom.class = "nom_teamMember";
    nom.id = idMembre;
    nom.innerText = membre;


    xhr.onreadystatechange = function () {

        if (xhr.readyState == 4 && xhr.status == 200) {

            /* On insère les éléments dans la ligne */
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
        xhr.send("val1=" + membre + "&type=ajout");
    }

}

/* ================================== *
*         SUPPRESSION MEMBRE          *
* =================================== */

function supprMemberTeam(nb) {
    let xhr = getXHR();

    let membre = document.getElementsByClassName("nom_teamMember")[nb].innerText;
    let idMembre = document.getElementsByClassName("nom_teamMember")[nb].id;

    console.log(membre);
    console.log(idMembre);

    let myTeam = document.getElementById("monEquipe");
    let listInscrits = document.getElementById("liste_participants");
    let memberToDelete = document.getElementsByClassName("ligne_equipe")[nb];


    xhr.onreadystatechange = function () {

        if (xhr.readyState == 4 && xhr.status == 200) {
            /* On crée la ligne à ajouter et ses différents éléments */
            let newOption = document.createElement("option");
            newOption.value = membre;
            newOption.name = idMembre;

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
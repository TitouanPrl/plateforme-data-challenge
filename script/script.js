

//fixation de la barre de navigation pendant le scroll

window.onscroll = function () { scrollFunction() };

function scrollFunction() {
    if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
        document.getElementById("header").style.padding = "0px 5px";
        document.getElementById("header").style.backgroundColor = "rgba(237, 251, 252,0.8)";
        document.getElementById("logo").style.paddingTop = "13px";
        document.getElementById("logo").style.height = "80px";
        document.getElementById("logo").style.width = "80px";
    } else {
        document.getElementById("header").style.padding = "8px 5px";
        document.getElementById("header").style.backgroundColor = "rgba(237, 251, 252,1)";
        document.getElementById("logo").style.height = "90px";
        document.getElementById("logo").style.width = "90px";
        document.getElementById("logo").style.paddingTop = "10px";
    }
}

/* Création d'une équipe */
function CreateTeam(nom_prenom_cap) {
    var xhr = getXHR();

    /* On récupère le nom de l'équipe et celui du challenge */
    var nomTeam = document.getElementById("nom_equipe").innerText;
    var challenge = document.getElementById("nom_challenge").innerText;

    console.log(nomTeam);
    console.log(challenge);

    xhr.onreadystatechange = function () {

        /* On ajoute le capitaine à l'équipe dans l'affichage et on cache le form de création d'équipe */
        if (xhr.readyState == 4 && xhr.status == 200) {
            let myTeam = document.getElementById("monEquipe");
            let formEquipe = document.getElementById("creer_equipe");

            /* === On crée la ligne à ajouter et ses différents éléments === */
            let newLine = document.createElement("div");
                newLine.class = "ligne_equipe";

            /* Image de la couronne */
            let crown = document.createElement("img");
                crown.id = "logo_crown";
                crown.src = "../../img/logo_crown.png";
                crown.alt = "logo";
            
            /* Nom Prénom */
            let nom = document.createElement("span");
                nom.class = "nom_teamMember";
                nom.innerText = nom_prenom_cap;

            /* On insère les éléments dans la ligne */
            newLine.appendChild(crown);
            newLine.appendChild(nom);

            /* On ajoute la ligne à l'équipe et on cache la ligne de création d'équipe */
            if (myTeam) {
                myTeam.appendChild(newLine);
                formEquipe.style.visibility = "hidden";
            }
        }
    }

    /* UPDATE DES VARS SESSIONS ET DE LA BDD */
    xhr.open("POST", "gestionEquipe.php", true);
    xhr.setRequestHeader('Content-Type',
        'application/x-www-form-urlencoded;charset=utf-8');
    xhr.send("type=ajout" + "&nomTeam=" + nomTeam + "&challenge=" + challenge);

}

/* Ajout d'un membre dans une équipe */
function addMemberTeam(idNewMember) {
    var xhr = getXHR();

    var membre = document.getElementById("participant").value;
    var idMembre = document.getElementById("participant").name;

    console.log(membre);
    console.log(idMembre);

    xhr.onreadystatechange = function () {

        if (xhr.readyState == 4 && xhr.status == 200) {
            let myTeam = document.getElementById("monEquipe");
            let listInscrits = document.getElementById("liste_participants");
            let memberToDelete = document.getElementsByName(idMembre);

            /* === On crée la ligne à ajouter et ses différents éléments === */
            let newLine = document.createElement("div");
                newLine.class = "ligne_equipe";
            
            /* Nom Prénom */
            let nom = document.createElement("span");
                nom.class = "nom_teamMember";
                nom.id = idMembre;
                nom.innerText = membre;

            /* On insère les éléments dans la ligne */
            newLine.appendChild(nom);

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

    /* UPDATE DES VARS SESSIONS ET DE LA BDD */
    xhr.open("POST", "gestionEquipe.php", true);
    xhr.setRequestHeader('Content-Type',
        'application/x-www-form-urlencoded;charset=utf-8');
    xhr.send("val1=" + membre + "&type=ajout");

}

/* Suppression d'un membre dans une équipe */
function supprMemberTeam(nb) {
    var xhr = getXHR();

    var membre = document.getElementsByClassName("nom_teamMember")[nb].innerText;
    var idMembre = document.getElementsByClassName("nom_teamMember")[nb].id;

    console.log(membre);
    console.log(idMembre);

    xhr.onreadystatechange = function () {

        if (xhr.readyState == 4 && xhr.status == 200) {
            let myTeam = document.getElementById("monEquipe");
            let listInscrits = document.getElementById("liste_participants");
            let memberToDelete = document.getElementsByClassName("ligne_equipe")[nb];
            
            /* On crée la ligne à ajouter et ses différents éléments */
            let newOption = document.createElement("option");
                newOption.value = membre;
                newOption.name = idMembre;

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

    /* UPDATE DES VARS SESSIONS ET DE LA BDD */
    xhr.open("POST", "gestionEquipe.php", true);
    xhr.setRequestHeader('Content-Type',
        'application/x-www-form-urlencoded;charset=utf-8');
    xhr.send("val1=" + membre + "&type=suppr" + "&idUser=" + idMembre);

}


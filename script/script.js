

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
            var myTeam = document.getElementById("monEquipe");
            var formEquipe = document.getElementById("creer_equipe");

            if (myTeam) {
                myTeam.parentNode.appendChild(nom_prenom_cap);  // SUREMENT A REFAIRE EN CREEANT UN ELMT DIV
                formEquipe.style.visibility = "hidden";
            }
        }
    }


    xhr.open("POST", "gestionEquipe.php", true);
    xhr.setRequestHeader('Content-Type',
        'application/x-www-form-urlencoded;charset=utf-8');
    xhr.send("type=ajout" + "&nomTeam=" + nomTeam + "&challenge=" + challenge);

}

/* Ajout d'un membre dans une équipe */
function addMemberTeam(idNewMember) {
    var xhr = getXHR();

    var membre = document.getElementById("participant").innerText;

    console.log(membre);

    xhr.onreadystatechange = function () {

        if (xhr.readyState == 4 && xhr.status == 200) {
            var myTeam = document.getElementById("monEquipe");

            if (myTeam) {
                myTeam.parentNode.appendChild(membre);
            }
        }
    }


    xhr.open("POST", "gestionEquipe.php", true);
    xhr.setRequestHeader('Content-Type',
        'application/x-www-form-urlencoded;charset=utf-8');
    xhr.send("val1=" + membre + "&type=ajout");

}

/* Suppression d'un membre dans une équipe */
function supprMemberTeam(nb) {
    var xhr = getXHR();

    var membre = document.getElementsByClassName("nom_teamMember")[nb].innerText;
    var idMembre = document.getElementById("idTeamMember").innerText;

    console.log(membre);

    xhr.onreadystatechange = function () {

        if (xhr.readyState == 4 && xhr.status == 200) {
            var myTeam = document.getElementById("monEquipe");

            if (myTeam) {
                myTeam.parentNode.remove(membre);
            }
        }
    }


    xhr.open("POST", "gestionEquipe.php", true);
    xhr.setRequestHeader('Content-Type',
        'application/x-www-form-urlencoded;charset=utf-8');
    xhr.send("val1=" + membre + "&type=suppr" + "&idUser=" + idMembre);

}


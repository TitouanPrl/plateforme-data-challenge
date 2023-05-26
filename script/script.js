

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

/* Ajout d'un membre dans une équipe */
function addMemberTeam() {
    var xhr = getXHR();

    var membre = document.getElementById("participant").outerText;

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
    xhr.send("val1=" + membre);

}

/* Suppression d'un membre dans une équipe */
function supprMemberTeam(nb) {
    var xhr = getXHR();

    var membre = document.getElementsByClassName("ligne_equipe")[nb].outerText;

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
    xhr.send("val1=" + membre);

}


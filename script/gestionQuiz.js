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
*            CREATION QUIZ            *
* =================================== */

function createQuiz() {
    var xhr = getXHR();

    /* On récupère le nom du challenge */
    var IDchallenge = document.getElementById("nom_challenge").value;

    /* On récupère les dates de début et de fin */
    var debut = document.getElementById("dateDeb").value;
    var fin = document.getElementById("dateFin").value;

    /* On récupère l'id du dernier questionnaire créé et on crée celui du nouvel élément */
    var lastID = document.getElementById("idMax").value;
    var newID = parseInt(lastID) + 1;

    /* On récupère les questions */
    var question0 = document.getElementById("question0").value;
    var question1 = document.getElementById("question1").value;
    var question2 = document.getElementById("question2").value;
    var question3 = document.getElementById("question3").value;
    var question4 = document.getElementById("question4").value;

    console.log(debut);
    console.log(fin);
    console.log(question0);
    console.log(question4);

    xhr.onreadystatechange = function () {

        /* On ajoute le quiz à la liste des quiz existants */
        if (xhr.readyState == 4 && xhr.status == 200) {
            let listeQuiz = document.getElementById("listeQuiz");

            /* On crée l'élément à ajouter */
            let newQuiz = document.createElement("div");
            newQuiz.setAttribute("class", "ligne_quiz");

            /* On crée l'élément à ajouter */
            let lien = document.createElement("a");
            lien.setAttribute("href", "detailsQuiz.php?quiz=" + ToString(newID));
            
            /* On crée les sous éléments à ajouter */
            let actBattle = document.getElementById(nom_challenge);
            let numQuiz = parseInt(actBattle.lastChild.id) + 1;

            console.log(numQuiz);

            let title = document.createElement("span");
            title.setAttribute("class", "nom_quiz");
            title.innerText = "Questionnaire " + ToString(numQuiz);

            let img = document.createElement("img");
            img.setAttribute("class", "delete_button");
            img.setAttribute("src", "../../img/croix.png");
            img.setAttribute("onclick", "supprQuiz()");
            img.setAttribute("alt", "I am an image");

            /* On les ajoute à l'élément div */
            lien.appendChild(title);
            lien.appendChild(img);

            newQuiz.appendChild(lien);


            /* On ajoute la div à la liste des quiz et on update la valeur de l'id max */
            if (listeQuiz) {
                listeQuiz.appendChild(newQuiz);
                document.getElementById("idMax").setAttribute("value", newID);
            }
        }
    }

    /* UPDATE DES VARS SESSIONS ET DE LA BDD */
    xhr.open("POST", "gestionQuiz.php", true);
    xhr.setRequestHeader('Content-Type',
        'application/x-www-form-urlencoded;charset=utf-8');
    xhr.send("type=ajout" + "&IDchallenge=" + IDchallenge + "&debut=" + debut + "&fin=" + fin + "&question0=" + question0 + "&question1=" + question1 + "&question2=" + question2 + "&question3=" + question3 + "&question4=" + question4 + "$newID" + newID);

}


/* ================================== *
*          SUPPRESSION QUIZ           *
* =================================== */

function supprQuiz(nb, id) {
    var xhr = getXHR();

    var questionnaire = document.getElementsByClassName("ligne_quiz")[nb];

    xhr.onreadystatechange = function () {

        if (xhr.readyState == 4 && xhr.status == 200) {
            let listeQuiz = document.getElementById("listeQuiz");

            /* On retire le questionnaire de la liste */
            if (listeQuiz) {
                listeQuiz.removeChild(questionnaire);
            }
        }
    }

    /* UPDATE DES VARS SESSIONS ET DE LA BDD */
    xhr.open("POST", "gestionQuiz.php", true);
    xhr.setRequestHeader('Content-Type',
        'application/x-www-form-urlencoded;charset=utf-8');
    xhr.send("type=suppr" + "&idQuestionnaire=" + id);

}


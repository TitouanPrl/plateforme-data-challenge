
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
            newQuiz.class = "ligne_quiz";

            /* On crée l'élément à ajouter */
            let lien = document.createElement("a");
            lien.href = "detailsQuiz.php?quiz=" + ToString(newID);
            
            /* On crée les sous éléments à ajouter */
            let actBattle = document.getElementById(nom_challenge);
            let numQuiz = parseInt(actBattle.lastChild.id) + 1;

            console.log(numQuiz);

            let title = document.createElement("span");
            title.class = "nom_quiz";
            title.class
            title.innerText = "Questionnaire " + ToString(numQuiz);

            let img = document.createElement("img");
            img.class = "delete_button";
            img.src = "../../img/croix.png";
            img.onclick = "supprQuiz()";
            img.alt = "I am an image";

            /* On les ajoute à l'élément div */
            lien.appendChild(title);
            lien.appendChild(img);

            newQuiz.appendChild(lien);


            /* On ajoute la div à la liste des quiz et on update la valeur de l'id max */
            if (listeQuiz) {
                listeQuiz.appendChild(newQuiz);
                document.getElementById("idMax").value = newID;
            }
        }
    }

    /* UPDATE DES VARS SESSIONS ET DE LA BDD */
    xhr.open("POST", "gestionQuiz.php", true);
    xhr.setRequestHeader('Content-Type',
        'application/x-www-form-urlencoded;charset=utf-8');
    xhr.send("type=ajout" + "&nomTeam=" + nomTeam + "&challenge=" + challenge);

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
    xhr.send("idQuestionnaire=" + id);

}


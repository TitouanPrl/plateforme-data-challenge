
function affiche($type){
    if($type == "etudiant"){
       //on cache les fieldset correspondant a gestionnaires
       document.getElementById('formGest').style.visibility="hidden";
    }
    if($type == "gestionnaire"){
       //si c'est un gestionnaire on cache les fieldset d'étudiant
       document.getElementById('formEtu').style.visibility="hidden";
    }
    }
 
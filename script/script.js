

//fixation de la barre de navigation pendant le scroll

window.onscroll = function() {scrollFunction()};

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

/* Ajout/Suppression de membres dans une équipe */
function updTeam() {
    var xhr = getXHR();

    var listemembre = document.getElementsByClassName("maskName").outerText;

    console.log(membre);

    xhr.onreadystatechange = function() {

       if (xhr.readyState == 4 && xhr.status == 200){
        var myTeam = document.getElementById("fl"); 
        var membresDispo = document.getElementById("fl"); 

        if (myTeam) {
            myTeam.parentNode.appendChild(membre);
        }
        if (membresDispo) {
            membresDispo.parentNode.removeChild(membresDispo);
          }
       }
    }

    
    xhr.open("POST","gestionEquipe.php",true) ;
    xhr.setRequestHeader('Content-Type',
           'application/x-www-form-urlencoded;charset=utf-8');
    xhr.send("val1="+membre);
    
  }


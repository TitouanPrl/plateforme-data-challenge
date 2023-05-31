

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



//apparition du logo sous le texte quand on scroll
window.addEventListener('scroll', function() {
    var presentation = document.querySelector('.presentation');
    var logoSlide = document.querySelector('.logo-slide');

    var slideInAt = (window.scrollY + window.innerHeight) - presentation.offsetHeight / 2;
    var presentationBottom = presentation.offsetTop + presentation.offsetHeight;

    if (slideInAt > presentation.offsetTop && window.scrollY < presentationBottom) {
        logoSlide.classList.add('active');
    } else {
        logoSlide.classList.remove('active');
    }
});


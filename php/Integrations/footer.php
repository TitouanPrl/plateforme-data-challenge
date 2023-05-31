

<footer>
    <div class="row" style="margin-top:-250px;">
        <div>
          <svg id="" preserveAspectRatio="xMidYMax meet" class="svg-separator sep5" viewBox="0 0 1600 200" style="display: block;" data-height="200">
          <polygon class="" style="fill: rgb(14,135,105);" points="1488,134 1304,100 1068,152 909.935,92.044 672,198 364,142 242,32 -4,95 -4,204 1604,204 1604,0 "></polygon> 
          <polygon class="" style="opacity: 1;fill: white;" points="672,198 364,142 242,32 -4,95 -4,82.333 242,32 374,136 "></polygon> 
          <polygon class="" style="opacity: 1;fill: white;" points="894,86 672,198 909.935,92.044 "></polygon> 
          <polygon class="" style="opacity: 1;fill: white;" points="1068,152 1302,86 1486,126 1604,0 1488,134 1304,100 "></polygon></svg>
        </div>
    </div>
    <div style="display:flex; flex-direction:column; align-items:center; background-color:var(--vert);height:150px;justify-content:flex-end;">
        <div style="display:flex;flex-direction:row;">
            <p class="copyright" id="easteregg" onclick="">©</p>
            <p class="copyright">2023. Tous droits réservés.</p>
        </div>
        
        <img class="easteregg" src="../../img/requin.gif">
    </div>
 </footer>

 <script>
    document.addEventListener('DOMContentLoaded', function() {
        const texte = document.querySelector('#easteregg');
        const image = document.querySelector('.easteregg');

        // Au clic sur le texte, on affiche l'image et démarrer l'animation
        texte.addEventListener('click', function() {
            image.style.transform = 'translateX(-1900vw)';
            
            // Attendre 2 secondes avant de masquer l'image
            setTimeout(function() {
                image.style.display = 'none';
                image.style.transform = 'translateX(0)';
            }, 1000);
        });
    });
</script>
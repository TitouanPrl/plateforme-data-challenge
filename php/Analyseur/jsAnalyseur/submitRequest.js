// Fichier Python
$("#fileForm").submit(function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        url: $(this).attr("action"),
        type: $(this).attr("method"),
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
            console.log(data);
            drawPieChart(data); // dessiner le graphique avec les données reçues
            drawBarChart(data); // dessiner le graphique avec les données reçues

            // ajouter dans la console le type de data
            console.log(typeof data);
            // extraire les données pertinentes pour le graphique
            var idEquipe = document.getElementById("idEquipe").value;
            $.ajax({
                // URL du script php pour ajouter à la base de données le json
                url: "php/Analyseur/ajoutAnalyse.php?idEquipe=" + idEquipe,
                type: "POST",
                data: {valeur: data}, // données à envoyer au script php
                success: function(response) {
                    console.log("json ajouté avec succès à la base de données");
                },
                error: function(xhr, status, error) {
                    console.error("Erreur lors de l'ajout de la valeur : " + error);
                }
            });
        },
        error: function(data) {
            console.log(data);
        }
    });
});

// Liste de mots
$("#wordForm").submit(function(e) {
    e.preventDefault();
    // enlever le dernier caractère de la liste de mots (qui est un saut de ligne inutile qui fait tout boguer)
    var words = $("#wordsInput").val().trim();
    $.ajax({
        url: $(this).attr("action"),
        type: $(this).attr("method"),
        data: "mots=" + words,
        success: function(data) {
            console.log(words);
            console.log(data);
            drawHorizontalBarChartWords(data); // dessiner le graphique avec les données reçues
            // ajouter le json 
        },
        error: function(data) {
            console.log(data);
        }
    });
});
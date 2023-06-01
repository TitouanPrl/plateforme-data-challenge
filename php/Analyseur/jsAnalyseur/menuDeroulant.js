// Gestion du menu déroulant pour sélectionner les graphiques
$("#chartSelect").change(function() {
    // valeur du menu déroulant
    var selectedChart = $(this).val();
    // cacher tous les graphiques
    $("#normalChart, #barChart, #wordChart").hide();

    // afficher le graphique sélectionné
    if (selectedChart == "pie") {
        $("#normalChart").show();
    } else if (selectedChart == "bar") {
        $("#barChart").show();
    } else if (selectedChart == "horizontalBar") {
        $("#wordChart").show();
    }
})
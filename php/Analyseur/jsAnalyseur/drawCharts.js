///////////////////////////
// DESSINER LE CAMEMBERT //
///////////////////////////
function drawPieChart(data) {
    // vérifier si le graphique existe déjà, et le supprimer si c'est le cas
    var ctx = document.getElementById('chartContainer').getContext('2d');
    if (ctx.chart) ctx.chart.destroy();
    var labels = [];
    var dataPoints = [];
    for (var key in data.Fonctions) {
        labels.push(key);
        dataPoints.push(data.Fonctions[key]);
    }

    // création du nouveau graphique
    ctx.chart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                label: 'Fonctions du code source Python',
                data: dataPoints,
                backgroundColor: [ // You can customize the colors here
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)',
                    'rgba(255, 159, 64, 0.7)',
                    'rgba(80,159,10,0.7)',
                ],
                borderColor: [ // And here
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(80,159,10,1)',
                ],
                borderWidth: 1
            }]
        }
    });

}


////////////////////////////////////////////////////////////////////////////
// DESSINER LE GRAPHIQUE EN BARRE (pour le nombre de lignes par fonction) //
////////////////////////////////////////////////////////////////////////////
function drawBarChart(data) {
    // vérifier si le graphique existe déjà, et le supprimer si c'est le cas
    var ctx = document.getElementById('barChartContainer').getContext('2d');
    if (ctx.chart) ctx.chart.destroy();


    var labels = [];
    var dataPoints = [];
    // var totalLines = 0;
    
    for (var key in data.Fonctions) {
        labels.push(key);
        dataPoints.push(data.Fonctions[key]);
        // totalLines += data.Fonctions[key];
    }
    // valeurs de statistiques globales du fichier python envoyé :
    var nbLignesMoy = data.nbLignesMoy;
    var nbLignesMax = data.nbLignesMax;
    var nbLignesMin = data.nbLignesMin;
    var nbLignes = data.nbLignes;


    // ranger par ordre croissant les données 
    labels.sort(function(a, b) {
        return data.Fonctions[a] - data.Fonctions[b];
    });
    dataPoints.sort(function(a, b) {
        return a - b;
    });


    // création du nouveau graphique avec les options
    ctx.chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Nombre de lignes',
                data: dataPoints,
                backgroundColor: 'rgba(75, 192, 192, 0.7)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                annotation: {
                    annotations: [{
                            type: 'line',
                            yMin: nbLignesMoy,
                            yMax: nbLignesMoy,
                            borderColor: 'rgb(255, 99, 132)',
                            borderWidth: 2,
                            label: {
                                enabled: true,
                                content: 'Moyenne',
                                font: {
                                    size: 10
                                }
                            }},{
                            type: 'line',
                            yMin: nbLignesMax,
                            yMax: nbLignesMax,
                            borderColor: 'rgb(255, 99, 132)',
                            borderWidth: 2,
                            label: {
                                enabled: true,
                                content: 'Maximum',
                                font: {
                                    size: 10
                                }
                            }
                        },{
                            type: 'line',
                            yMin: nbLignesMin,
                            yMax: nbLignesMin,
                            borderColor: 'rgb(255, 99, 132)',
                            borderWidth: 2,
                            label: {
                                enabled: true,
                                content: 'Minimum',
                                // changer la taille de la police
                                font: {
                                    size: 10
                                }
                            }
                        }]
                    }
                }
            }
        });
        
    }


// fonction qui représente les occurrences des mots de la liste de mots sur un bar chart horizontal
/*
le json utilisé est sous la forme {mot: nombre d'occurrences; mot2: nombre d'occurrences; ...}
*/
function drawHorizontalBarChartWords(data) {
    // vérifier si le graphique existe déjà, et le supprimer si c'est le cas
    var ctx = document.getElementById('wordChartContainer').getContext('2d');
    if (ctx.chart) ctx.chart.destroy();


    var labels = [];
    var dataPoints = [];

    // Transformer les données en un array de la forme  [{word: mot, count: nombre d'occurrences}, ...]
    var dataArray = [];
    for (var key in data) {
        dataArray.push({
            word: key,
            count: data[key]
        });
    }

    // Trier l'array par ordre décroissant de count (nombre d'occurrences)
    dataArray.sort(function(a, b) {
        return b.count - a.count;
    });

    // Extraire les données triées dans deux arrays séparés
    dataArray.forEach(function(item) {
        labels.push(item.word);
        dataPoints.push(item.count);
    });


    // Créer le graphique 
    ctx.chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Occurrence des mots',
                data: dataPoints,
                backgroundColor: 'rgba(75, 192, 192, 0.7)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            scales: {
                x: {
                    beginAtZero: true
                }
            }
        }
    });
}
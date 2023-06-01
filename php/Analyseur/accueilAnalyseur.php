<head>
    <title>Page PHP</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@1.0.7"></script>
</head>
<!-- MAIN CONTENT -->


<body>

    <!-- Envoyer le fichier Python -->
    <form id="fileForm" action="http://localhost:8001/projet/php" method="post" enctype="multipart/form-data">
        <input type="file" name="pythonFile">
        <input type="submit" value="Envoyer le fichier">
    </form>

    <hr>

    <!-- Envoyer une liste de mots -->
    <form id="wordForm" action="http://localhost:8001/projet/php" method="post">
        <label for="wordsInput" style="font-size:small;">Liste de mots (séparés par des virgules et sans espace après les virgules). Attention la case est prise en compte.</label><br>
        <input type="text" id="wordsInput" name="mots"><br>
        <input type="submit" value="Envoyer la liste de mots">
    </form>


    <script>
        // Envoyer le fichier Python
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
                    drawChart(data); // dessiner le graphique avec les données reçues
                    drawBarChart(data); // dessiner le graphique avec les données reçues

                },
                error: function(data) {
                    console.log(data);
                }
            });
        });

        // Envoyer la liste de mots
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
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });

        function drawChart(data) {
            // vérifier si le graphique existe déjà, et le supprimer si c'est le cas
            var ctx = document.getElementById('chartContainer').getContext('2d');
            if (ctx.chart) ctx.chart.destroy();
            var labels = [];
            var dataPoints = [];
            for (var key in data.Fonctions) {
                labels.push(key);
                dataPoints.push(data.Fonctions[key]);
            }

            // var ctx = document.getElementById('chartContainer').getContext('2d');
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
                            'rgba(255, 159, 64, 0.7)'
                        ],
                        borderColor: [ // And here
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                }
            });

        }

        function drawBarChart(data) {
            // vérifier si le graphique existe déjà, et le supprimer si c'est le cas
            var ctx = document.getElementById('barChartContainer').getContext('2d');
            if (ctx.chart) ctx.chart.destroy();


            var labels = [];
            var dataPoints = [];
            var totalLines = 0;

            for (var key in data.Fonctions) {
                labels.push(key);
                dataPoints.push(data.Fonctions[key]);
                totalLines += data.Fonctions[key];
            }

            // var ctx = document.getElementById('barChartContainer').getContext('2d');
            ctx.chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Lignes par fonction',
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
                            line1: {
                                type: 'line',
                                yMin: totalLines,
                                yMax: totalLines,
                                borderColor: 'rgb(255, 99, 132)',
                                borderWidth: 2,
                            }
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
    </script>

<select id="charSelect">
    <option value="pie">Pie</option>
    <option value="bar">Bar</option>
    <option value="horizontalBar">Occurrences des mots</option>
</select>


    <!-- Afficher le résultat -->
<div id="normalChart">
    <canvas id="chartContainer" width="300" height:"300" align=center></canvas>
</div>
<div id="barChart" style="display:none;">
    <canvas id="barChartContainer" width="300" height:"300" align=center></canvas>
</div>
<div id="wordChart" style="display:none;">
    <canvas id="wordChartContainer" width="300" height:"300" align=center></canvas>
</div>

<script>
    // Gestion du menu déroulant pour sélectionner les graphiques
    $("#charSelect").change(function() {
        var selectedChart = $(this).val();
        $("#normalChart, #barChart, #wordChart").hide();

        if (selectedChart == "pie") {
            $("#normalChart").show();
        } else if (selectedChart == "bar") {
            $("#barChart").show();
        } else if (selectedChart == "horizontalBar") {
            $("#wordChart").show();
        }
    })
</script>
</body>

<?php require '../Integrations/headerVanilla.php';

/* On initialise les variables de session contenant les informations sur les challenges */
require_once '../General/accueilGeneral.php';
?>
<head>
    <title>Page PHP</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@1.0.7"></script>
</head>
<!-- MAIN CONTENT -->

<div class="bordure">
</div>
<div class="corps">
    <main>
        <div id="titres">
            <h1>
        </div>
    </main>
</div>

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


    <!-- Menu déroulant -->
<select id="graphSelect">
    <option value="pieChart">Pie Chart</option>
    <option value="barChart">Bar Chart</option>
    <option value="wordOccurrences">Word Occurrences</option>
</select>

<script>
    // Ajouter des events listeners sur le menu déroulant
    $("#graphSelect").change(function() {
        // Cacher tous les graphiques
        $('#chartContainer').hide();
        $('#barChartContainer').hide();
        $('#wordChartContainer').hide();

        // Afficher le graphique
        var selectedGraph = $(this).val();
        if (selectedGraph === 'pieChart') {
            $('#chartContainer').show();
        } else if (selectedGraph === 'barChart') {
            $('#barChartContainer').show();
        } else if (selectedGraph === 'wordOccurrences') {
            $('#wordChartContainer').show();
        }
    });
</script>


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
            var labels = [];
            var dataPoints = [];
            for (var key in data.Fonctions) {
                labels.push(key);
                dataPoints.push(data.Fonctions[key]);
            }

            var ctx = document.getElementById('chartContainer').getContext('2d');
            var chart = new Chart(ctx, {
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
            // Gérer l'événement de clic sur le bouton d'affichage/masquage du graphique en secteurs
            // $("#togglePieChartBtn").click(function() {
            //     var pieChartContainer = $("#pieChartContainer");
            //     if (pieChartContainer.is(":visible")) {
            //         pieChartContainer.hide();
            //         $(this).text("Afficher le graphique en secteurs");
            //     } else {
            //         pieChartContainer.show();
            //         $(this).text("Masquer le graphique en secteurs");
            //     }
            // });
        }

        function drawBarChart(data) {
            var labels = [];
            var dataPoints = [];
            var totalLines = 0;

            for (var key in data.Fonctions) {
                labels.push(key);
                dataPoints.push(data.Fonctions[key]);
                totalLines += data.Fonctions[key];
            }

            var ctx = document.getElementById('barChartContainer').getContext('2d');
            var chart = new Chart(ctx, {
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
            // Gérer l'événement de clic sur le bouton d'affichage/masquage du graphique en barres
            // $("#toggleBarChartBtn").click(function() {
            //     var barChartContainer = $("#barChartContainer");
            //     if (barChartContainer.is(":visible")) {
            //         barChartContainer.hide();
            //         $(this).text("Afficher le graphique en barres");
            //     } else {
            //         barChartContainer.show();
            //         $(this).text("Masquer le graphique en barres");
            //     }
            // });
        }


        // fonction qui représente les occurrences des mots de la liste de mots sur un bar chart horizontal
        /*
        le json utilisé est sous la forme {mot: nombre d'occurrences; mot2: nombre d'occurrences; ...}
        */
        function drawHorizontalBarChartWords(data) {
            var labels = [];
            var dataPoints = [];

            // Transform data into array for sorting.
            var dataArray = [];
            for (var key in data) {
                dataArray.push({
                    word: key,
                    count: data[key]
                });
            }

            // Sort array in descending order of 'count'.
            dataArray.sort(function(a, b) {
                return b.count - a.count;
            });

            // Extract sorted labels and data points.
            dataArray.forEach(function(item) {
                labels.push(item.word);
                dataPoints.push(item.count);
            });

            // Prepare the context for drawing the chart.
            var ctx = document.getElementById('wordChartContainer').getContext('2d');

            // Create the chart.
            var chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Occurrences of words',
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

    <!-- Afficher le résultat -->
<canvas id="chartContainer" style="width:70%; height:300px;" align=center></canvas>

<canvas id="barChartContainer" style="width:70%; height:300px;" align=center></canvas>


<canvas style="width:70%; height:300px;" align=center id="wordChartContainer"></canvas>
</body>

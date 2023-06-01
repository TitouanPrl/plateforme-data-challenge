<?php require '../Integrations/headerVanilla.php';
if (!connect()) {
    die('Erreur de connexion à la base de données');
}

/* On initialise les variables de session contenant les informations sur les challenges */
// require_once 'initVarChallenges.php'
?>


<div class="bordure"></div>
<div class=corps">
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


    <script src="jsAnalyseur/submitRequest.js"></script>
    <script src="js/drawCharts.js"></script>

    <select id="charSelect">
        <option value="pie">Pie</option>
        <option value="bar">Bar</option>
        <option value="horizontalBar">Occurrences des mots</option>
    </select>


    <!-- Affichage des résultats -->
    <div id="normalChart">
        <canvas id="chartContainer" width="300" height:"300" align=center></canvas>
    </div>
    <div id="barChart" style="display:none;">
        <canvas id="barChartContainer" width="300" height:"300" align=center></canvas>
    </div>
    <div id="wordChart" style="display:none;">
        <canvas id="wordChartContainer" width="300" height:"300" align=center></canvas>
    </div>

    <script src="js/menuDeroulant.js"></script>
</body>
</div>

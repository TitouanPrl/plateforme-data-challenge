<?php 
session_start();

require '../../bdd/fonctionsBDD.php';
require '../Integrations/headerVanilla.php';
// if (!connect()) {
//     die('Erreur de connexion à la base de données');
// }

/* On initialise les variables de session contenant les informations sur les challenges */
// require_once 'initVarChallenges.php'
?>

<head>
    <title>Analyse de code</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@1.1.0"></script>
    <link rel="stylesheet" href="../../css/analyseur.css" />

</head>

<div class="bordure"></div>
<div class="corpsAnalyse corps" style="padding-top:50px;">
    
    <!-- MAIN CONTENT -->
    <!-- Envoyer le fichier Python -->
    <div id="saisies">
        <form id="fileForm" action="http://localhost:8001/projet/php" method="post">
            <input type="file" name="pythonFile">
            <input class="boutonForm" type="submit" value="Envoyer le fichier">
        </form>
        <!-- bouton pour afficher les statistiques globales -->

        <!-- Envoyer une liste de mots -->
        <form id="wordForm" action="http://localhost:8001/projet/php" method="post">
            <p>Liste de mots (séparés par des virgules et sans espace après les virgules).<br> Attention la case est prise en compte.</p>
            <input type="text" id="wordsInput" name="mots">
            <input type="submit" class="boutonForm" value="Envoyer la liste de mots">
        </form>

        <script src="jsAnalyseur/submitRequest.js"></script>
        <script src="jsAnalyseur/drawCharts.js"></script>

        <select id="chartSelect">
            <option value="pie">Pie</option>
            <option value="bar">Bar</option>
            <option value="horizontalBar">Occurrences des mots</option>
            <!-- faire en sorte de ne pas enregistrer les demandes précédentes -->
        </select>
        <script src="jsAnalyseur/menuDeroulant.js"></script>
    </div>

    <!-- Affichage des résultats -->
    <div id="affichageRes">
        <div id="normalChart" class="chart" align=center style="width:600px;height:100%;">
            <canvas id="chartContainer"></canvas>
        </div>
        <div id="barChart" class="chart" align=center style="width:600px;height:100%;display:none;">
            <canvas id="barChartContainer"></canvas>
            <div id="legendContainer"></div>
        </div>
        <div id="wordChart" class="chart" align=center style="width:600px;height:100%;display:none;">
            <canvas id="wordChartContainer"></canvas>
        </div>
    </div>

    

</div>




<?php require '../Integrations/footer.php'; ?>

<?php 
session_start();
require '../../bdd/fonctionsBDD.php';
require '../Connexion/initVarSession.php';
// require '../Integrations/headerVanilla.php';
// if (!connect()) {
//     die('Erreur de connexion à la base de données');
// }

/* On initialise les variables de session contenant les informations sur les challenges */
// require_once 'initVarChallenges.php'
?>

<br><br><br><br><br><br><br>




<!-- <?php
// si l'utilisateur est connecté 
// if (isset($_SESSION["login"])) {
//     echo '<div id="ajouteAnalyse">id de l\'équipe de l\'utilisateur : <?php echo $_SESSION[\'infoUser\'][\'idEquipe\'] ?></div>';
// } else {
//     echo '<div id="ajouteAnalyse">Vous devez être connecté pour accéder à cette page</div>';
// }
?> -->

<div class="bordure"></div>
<div class=corps">
<head>
    <title>Page PHP</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@1.1"></script>
</head>
<!-- MAIN CONTENT -->


<body>

    <!-- Envoyer le fichier Python -->
    <form id="fileForm" action="http://localhost:8001/analyse-de-code" method="post" enctype="multipart/form-data">
        <input type="file" name="pythonFile">
        <input type="submit" value="Envoyer le fichier">
    </form>
    <!-- bouton pour afficher les statistiques globales -->

    <!-- Envoyer une liste de mots -->
    <form id="wordForm" action="http://localhost:8001/analyse-de-code" method="post">
        <label for="wordsInput" style="font-size:small;">Liste de mots (séparés par des virgules et sans espace après les virgules). Attention la case est prise en compte.</label><br>
        <input type="text" id="wordsInput" name="mots"><br>
        <input type="submit" value="Envoyer la liste de mots">
    </form>


    <script src="jsAnalyseur/submitRequest.js"></script>
    <script src="jsAnalyseur/drawCharts.js"></script>

    <select id="chartSelect">
        <option value="pie">Pie</option>
        <option value="bar">Bar</option>
        <option value="horizontalBar">Occurrences des mots</option>
        <!-- faire en sorte de ne pas enregistrer les demandes précédentes
    </select>


    <!-- Affichage des résultats -->
    <div id="normalChart" align=center style="width:600px;height:100%;">
        <canvas id="chartContainer"></canvas>
    </div>
    <div id="barChart" align=center style="width:600px;height:100%;display:none;">
        <canvas id="barChartContainer"></canvas>
        <div id="legendContainer"></div>
    </div>
    <div id="wordChart" align=center style="width:600px;height:100%;display:none;">
        <canvas id="wordChartContainer"></canvas>
    </div>

    <script src="jsAnalyseur/menuDeroulant.js"></script>
</body>
</div>

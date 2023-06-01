
<?php session_start();
require '../Integrations/headerVanilla.php'; 

include('./php/bddData.php'); 
connect()?>

<div class="bordure"></div>

<body>
<!-- fonction qui permet de récupérer les fichiers télécharger dans un répertoire -->
<?php
$stock = '../../fichierstelecharger/';
$i=0;
while($i< count($_FILES['userfile'])){
    if($_FILES['userfile']['tmp_name'][$i]!=""){
        if (move_uploaded_file($_FILES['userfile']['tmp_name'][$i], $stock.$_FILES['userfile']['name'][$i]))
        {
            echo '<p id="msgfichier"> Le fichier '.$_FILES['userfile']['name'][$i].' a été téléchargé avec succès dans '.$stock.'</p>';
        }
        else{
            echo"Le fichier n'a pas pu être télécharger ";
        }
    }
    $i+=1;
}
?>

</body>

<div class="corps">
    <div style="display:flex;flex-wrap:wrap;justify-content:space-evenly;align-items:center;padding-top:100px;">

        <section class="tab" id="tabUser">

            <div>
            <table id='tabUser'>
                <!-- On crée le headers du tableau -->
                <tr>
                    <th> Utilisateurs</th>
                </tr>       
            </table>
            </div>
            <table>
                <tr>
                    <input type="button" class="ajoutUser" id="plus" title="Ajouter un utilisateur" value="+" onclick="document.location.href='type.php'";>
                </tr>
                <!-- Pour chaque catégorie du tableau -->
                <div class="contenu">
                    <?php
                    $Users = getAllUtilisateurs($conn);
                    foreach ($Users as $current) : ?>
                    <!--  -->    
                    <tr class="ligne">
                        <td>

    <div>
    <table id='tabUser'>
        <!-- On crée le headers du tableau -->
        <tr>
            <th> Utilisateurs</th>
        </tr>       
    </table>
    </div>
<table>
    <tr>
        <input type="button" class="ajoutUser" id="plus" value="+" onclick="document.location.href='type.php'";>
    </tr>
    <!-- Pour chaque catégorie du tableau -->
    <?php
    $Users = getAllUtilisateurs($conn);
     foreach ($Users as $current) : ?>
    <!--  -->    
    <tr class="ligne">
        <?php
                echo ('<td>'.'<a href="ModifProf.php?user=' . $current['idUser'] . '">
                    <div class="infosUser">
                        <span class="nomU"> ' . $current['nom'] . ' </span>
                        <span class="prenomU"> ' . $current['prenom'] . ' </span>
                        <span class="fonctionU"> ' . $current['fonction'] . ' </span>
                    </div>
                </a>'. '</td>');
            ?>
        <td>
            
            <p>
                <button class="supp" id="supp<?php echo $Users['idUser'];?>">X</button>
            </p>
        </td>
    </tr>
<?php endforeach ?>
</table>
</section>


<section>
    <div>
    <table id='tabDC'>
        <!-- On crée le headers du tableau -->
        <tr>
            <th> Data Challenge</th>
        </tr>       
    </table>
    </div>
<table>
    <!-- Pour chaque catégorie du tableau -->
        <tr>
            <input type="button" class="ajoutDC" id="plus" value="+" onclick="document.location.href='formDC.php'";>
        </tr>
    <?php
    $kind ='CHALLENGE';
    $DC = getEvenementsByKind($conn,$kind);
    
    foreach ($DC as $evt) : ?>
        <div>
        <tr class="ligneDc">
            <?php
                    $sujet = getSujetByEvenement($conn,$evt['idEvenement']);
                    echo ('<td>'.'<a href="ModifDC.php?DC=' . $evt['idEvenement'] . '">
                        <div class="infosUser">
                            <span class="nomDC"> ' . $evt['libelle'] . ' </span>
                            <span class="debut"> ' . $evt['dateD'] . ' </span>
                            <span class="fin"> ' . $evt['dateF'] . ' </span>
                        </div>
                    </a>'. '</td>
                    <td>
                    <p>
                        <button class="supp" id="supp"' . $evt['idEvenement'] . '">X</button>
                    </p>
                    </td>');
                    
                    foreach ($sujet as $sp) : ?>
                        <div>
                        <tr class="ligneSuj">
                            <?php 
                            $projet = getProjetsOnSujet($conn,$sp['idSujet']);
                            echo ('<td> '.'<a href="modifSujet.php?Sujet=' . $sp['idSujet'] . '">
                            <div class="infosSujet">
                                <span class="nomSujet"> ' . $sp['libelle'] . ' </span>
                                <span class="descriSujet"> : ' . $sp['descrip'] . ' </span>
                            </div>
                            </a>'. '</td>
                            <td>
                            <p>
                                <button class="supp" id="supp"' .  $sp['idSujet'] . '">X</button>
                            </p>
                            </td>');

                            
                            <a href="#" onclick="supprimerUtilisateur(<?php echo $Users['idUser'];?>)" style="margin-top:8px;display:inline-block;">
                                <img class="supp" title="Supprimer un utilisateur" id="supp<?php echo $Users['idUser'];?>" src="../../img/croix.png" alt="Supprimer">
                            </a>

                        </td>
                        <?php
                                echo ('<td>'.'<a href="modif.php?user=' . $current['idUser'] . '">
                                    <div class="infosUser">
                                        <span class="nomU"> ' . $current['nom'] . ' </span>
                                        <span class="prenomU"> ' . $current['prenom'] . ' </span>
                                        <span class="fonctionU"> ' . $current['fonction'] . ' </span>
                                    </div>
                                </a>'. '</td>');
                        ?>
                        
                    </tr>
                    <?php endforeach ?>
                </div>
            </table>
        </section>




        <section class="tab">
            <div>
                <div id='tabDC'>
                    
                    <div class="th">Data Challenges</div>
                    
                </div>
            </div>
            <div>
                <div style="display:flow-root">
                    <input type="button" class="ajoutDC" id="plus" title="Ajouter un Data Challenge" value="+" onclick="document.location.href='formDC.php'";>
                </div>
                <div class="contenu">
                    <?php
                    $kind = 'CHALLENGE';
                    $DC = getEvenementsByKind($conn, $kind);

                    foreach ($DC as $evt) : ?>
                        <div class="row">
                            <div class="ligneDc">
                                <div>
                                    <a href="#" onclick="supprimerEvenement(<?php echo $evt['idEvenement']; ?>)" style="margin-top:5px;display:inline-block;">
                                        <img class="supp" title="Supprimer un Data Challenge" id="supp" src="../../img/croix.png" alt="Supprimer">
                                    </a>
                                </div>
                                <div>
                                    <a href="modifDC.php?DC=<?php echo $evt['idEvenement']; ?>">
                                        <div class="infosDC">
                                            <span class="nomDC"> <?php echo $evt['libelle']; ?> </span>
                                            <span class="debut"> <?php echo $evt['dateD']; ?> </span>
                                            <span class="fin"> <?php echo $evt['dateF']; ?> </span>
                                        </div>

                                    </a>
                                </div>
                            </div>
                            <div class="sujets">
                                <?php
                                $sujet = getSujetByEvenement($conn, $evt['idEvenement']);

                                foreach ($sujet as $sp) : ?>
                                    <div class="row">
                                        <div class="ligneSuj">
                                            <div>
                                                <a href="#" onclick="supprimerSujet(<?php echo $sp['idSujet']; ?>)" style="margin-top:5px;display:inline-block;padding-right:20px;">
                                                    <img class="supp" title="Supprimer un sujet" id="supp" src="../../img/croix.png" alt="Supprimer">
                                                </a>
                                            </div>
                                            <div>
                                                <a href="modifSujet.php?Sujet=<?php echo $sp['idSujet']; ?>">
                                                    <div class="infosSujet">
                                                        <span class="nomSujet"> <?php echo $sp['libelle']; ?> </span>
                                                        <span class="descriSujet"> <?php echo $sp['descri']; ?> </span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>

                                        <?php
                                        $projet = getProjetsOnSujet($conn, $sp['idSujet']);

                                        foreach ($projet as $current): ?>
                                            <div class="ligneProjet">
                                                <div>
                                                    <a href="#" onclick="supprimerProjet(<?php echo $current['idProjet']; ?>)" style="margin-top:5px;display:inline-block;padding-right:20px;">
                                                        <img class="supp" title="Supprimer un sujet" id="supp" src="../../img/croix.png" alt="Supprimer" style="width:20px;">
                                                    </a>
                                                </div>
                                                <div>
                                                    <a href="modifProj.php?Projet=<?php echo $current['idProjet']; ?>">
                                                        <div class="infosProjet">
                                                            <span class="Idequipe"> Nom equipe : <?php echo $equipe[0]['nom']; ?> </span>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endforeach ?>
                                    </div>
                                <?php endforeach ?>
                            </div>

                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </section>



        
    </div>
</div>

<?php require '../Integrations/footer.php'; ?>

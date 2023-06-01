
<?php session_start()?>
<?php require '../Integrations/headerVanilla.php'; ?>

<?php include('./php/bddData.php');?>
<?php connect()?>

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
                            
                            foreach ($projet as $current): ?>
                                <div>
                                <tr class="ligneProjet">
                                    <?php
                                        $idEquipe = getEquipeByProjet($conn,$current['idProjet']);
                                        $equipe=getEquipe($conn,$idEquipe[0]['idEquipe']);
                                        echo ('<td>'.'<a href="modifProj.php?Projet=' . $current['idProjet'] . '">
                                        <div class="infosProjet">
                                            <span class="Idequipe"> Nom equipe : ' . $equipe[0]['nom'] . ' </span>
                                        </div>
                                        </a>'. 
                                        '</td>
                                        <td>
                                        <p>
                                            <a href="formInsc.php?Projet=' . $current['idProjet'] . '">
                                        </p>
                                        </td>');
                                    ?>
                                </tr>
                                </div>
                                <?php endforeach?>
                                
                        </tr>
                        </div>
                        <?php endforeach ?>
                </tr>
                </div>
            <?php endforeach ?>
            </table>

        </table>
</section>






<?php session_start()?>
<?php connect()?>
<?php require '../Integrations/headerVanilla.php'; ?>

<?php
    if($_SESSION["type"] != "administrateur"){
        echo($_SESSION["type"]);
    }
    else {
        echo("Marche pas");
    }
?>
<?php include('./php/bddData.php');?>

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
    <!-- Pour chaque catégorie du tableau -->
    <?php
    $Users = getAllUtilisateurs($conn);
     foreach ($Users as $User) : ?>
    <!-- Si le titre est celui du GET -->
    <?php if ($User['idUser'] == $_GET['user']) : ?>
        <!-- J'ajoute ma référence à la liste -->
        <script> referencesList.push('<?php echo $User['idUser']; ?>'); </script>
        
        <tr class="ligne">
            <?php
            foreach ($Users as $User['idUser']) {
                echo '<td class="user" id="idUser'.$Users['nom'].'">'.$Users['prenom']. '<br>' . $Users['fonction'] .'</td>';
            }
            ?>
            <td>
                <p>
                    <button class="supp" id="supp<?php echo $User['idUser'];?>">X</button>
                </p>
            </td>
        </tr>
    <?php endif ?>
<?php endforeach ?>
</table>

<div>
    <table id='tabDC'>
        <!-- On crée le headers du tableau -->
        <tr>
            <th> Data Challenges</th>
        </tr>       
    </table>
</div>
<table>
    <!-- Pour chaque catégorie du tableau -->
    <?php
    $DC = getEvenements($conn);
     foreach ($DC as $DC) : ?>
    <!-- Si le titre est celui du GET -->
    <?php if ($DC['idEvenement'] == $_GET['DC']) : ?>
        <!-- J'ajoute ma référence à la liste -->
        <script> referencesList.push('<?php echo $DC['idEvenement']; ?>'); </script>
        
        <tr class="ligne">
            <?php
            $DC =  getEvenements($conn);
            foreach ($DC as $DC['idEVenement']) {
                echo '<td class="DC" id="idEvenement'.$DC['libelle'].'">'. '<br>' . $User['fonction'] .'</td>';
            }
            ?>
            <td>
                <p>
                    <button class="supp" id="supp<?php echo $DC['idDC'];?>">X</button>
                </p>
            </td>
        </tr>
    <?php endif ?>
<?php endforeach ?>
</table>

<div>
    <table id='tabProjets'>
        <!-- On crée le headers du tableau -->
        <tr>
            <th> Projets</th>
        </tr>       
    </table>
</div>
<table>
    <!-- Pour chaque catégorie du tableau -->
    <?php
    $DC = getEvenements($conn);
     foreach ($DC as $DC) : ?>
    <!-- Si le titre est celui du GET -->
    <?php if ($DC['idEvenement'] == $_GET['DC']) : ?>
        <!-- J'ajoute ma référence à la liste -->
        <script> referencesList.push('<?php echo $DC['idEvenement']; ?>'); </script>
        
        <tr class="ligne">
            <?php
            $DC =  getEvenements($conn);
            foreach ($DC as $DC['idEVenement']) {
                echo '<td class="DC" id="idEvenement'.$DC['libelle'].'">'. '<br>' . $User['fonction'] .'</td>';
            }
            ?>
            <td>
                <p>
                    <button class="supp" id="supp<?php echo $DC['idDC'];?>">X</button>
                </p>
            </td>
        </tr>
    <?php endif ?>
<?php endforeach ?>
</table>

</section>



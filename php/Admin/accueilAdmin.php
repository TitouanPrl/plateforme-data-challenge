
<?php include('./php/bdd.php');?>

<!-- Je récupère la bdd -->
<?php
connexion();
$User = getAllUtilisateurs($conn);
?>

<section class="ligne" id="ligne">
    <div>
    <table>
        <!-- On crée les headers du tableau -->
        <tr>
            <th> Utilisateurs</th>
            <th>Data Challenges</th>
            <th>Projets</th>
        </tr>       
    </table>
    </div>

    <!-- Pour chaque catégorie du tableau -->
    <?php foreach ($User as $User) : ?>
    <!-- Si le titre est celui du GET -->
    <?php if ($User['idUser'] == $_GET['user']) : ?>
        <!-- J'ajoute ma référence à la liste -->
        <script> referencesList.push('<?php echo $User['idUser']; ?>'); </script>

        <tr class="ligne">
            <?php
            $User =  getAllUtilisateurs($conn);
            foreach ($User as $User['idUser']) {
                echo '<td class="user" id="idUser'.$User['nom'].'">'.$User['prenom']. '<br>' . $User['fonction'] .'</td>';
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
</section>



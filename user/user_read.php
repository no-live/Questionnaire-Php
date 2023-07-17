<?php
session_start();
session_unset();
$_SESSION['status'] = 'Vide, connectez-vous';
echo "- session" . " : " . ($_SESSION['status']);
include('../inc/database.php');
?>

<!DOCTYPE html>
<?php
include('../inc/head.php');
include('../inc/link.php');
?>

<body>
    <?php
    include('../inc/header.php');
    ?>
    <div class="container min-vh-100 backtribu">
        <div class="row col-10 m-auto">
            <div class="container">
                <div class="row mt-3 text-light">
                    <h2>Afficher les résultats</h2>
                </div>
                <div class="p-2 backgris shadow-lg mb-3 rounded text-center">
                    <!-- <span>Veuillez choisir un questionnaire :</span> -->
                    <label for="questionnaire" class="text-light m-2 ">Veuillez choisir un questionnaire :</label>
                    <select name="questionnaire" id="questionnaire" class="form-control p-2 m-auto" required>
                        <!--  le "name" prends la valeur du choix "questionnaire" = "id_questionnaire"  -->
                        <option value="" disabled selected>Cliquez et sélectionnez un questionnaire</option>
                        <?php
                        try {
                            $bdd = new PDO('mysql:host=localhost;dbname=tribu;charset=utf8', 'root', '');
                        } catch (Exception $e) {
                            die('Erreur : ' . $e->getMessage());
                        }
                        $reponse = $bdd->query("SELECT * FROM questionnaire WHERE quest_check = 1");
                        while ($donnees = $reponse->fetch()) :
                        ?>
                            <option value="<?php echo $donnees['nom_questionnaire'] ?>"> <?php echo $donnees['nom_questionnaire'] ?></option>
                            <!-- on affiche sur la liste le nom du questionnaire et l'id en "value"  -->
                        <?php
                        endwhile;
                        $reponse->closeCursor();
                        ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <?php
    include('../inc/footer.php');
    ?>
</body>

</html>
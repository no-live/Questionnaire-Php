<?php
session_start();
session_unset();
$_SESSION['status'] = 'Vide, connectez-vous';
echo "- session" . " : " .($_SESSION['status']);
?>
<!DOCTYPE html>
<?php
include('inc/head.php');
include('inc/link.php');
?>

<body>
    <?php
    include('inc/header.php');
    ?>
    <main class="container backtribu min-vh-100">
        <div class="row text-light text-center">
            <h1 class=" p-4 mb-0 ">Bienvenue !</h1>
            <p>Ce site vous propose de répondre à différent questionnaire de façon anonyme, vos données personnelles ne sont pas conservées, seules vos réponses comptent ! </p>
        </div>
        <hr class="text-light">
        <div class="row col-6 m-auto">
            <form method="POST" action="../Tribu/user/user_rep.php" class="needs-validation">
                <div class="container">
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
                <div class="container">
                    <div class="col-12 mt-0 p-2 text-center">
                        <button type="submit" class="btn btn-success p-3" name="submit" value="">Démarrer</button>
                        <a class="btn btn-secondary" href="index.php">Annuler</a>

                    </div>
                </div>

            </form>
        </div>
    </main>

    <?php
    include('./inc/footer.php');
    ?>


</body>

</html>
<?php
session_start();
session_unset();
$_SESSION['status'] = 'Vide, connectez-vous';

echo "- session" . " : " . ($_SESSION['status']);
?>
<br>
<?php
if (isset($_POST['submit'])) :  // test sur la présence d'une valeur envoyée depuis choix du questionnaire
    $_SESSION['nom_questionnaire'] = $_POST['questionnaire'];
    $questionnaire = $_SESSION['nom_questionnaire'];
    else :
        $_SESSION['nom_questionnaire'] = 'Attente de questionnaire';
        $questionnaire = '';

endif;
echo "- questionnaire" . " : " . ($_SESSION['nom_questionnaire']);
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
    <main class="container backtribu min-vh-114">
        <div class="row text-light text-center">
            <h1 class=" p-4 mb-0 ">Consulter les résultats</h1>
            <p>Sélectionnez le questionnaire pour afficher les résultats des utilisateurs </p>
        </div>
        <hr class="text-light">
        <div class="row col-6 m-auto">
            <form method="POST" action="user_read.php" class="needs-validation">
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
                        <a class="btn btn-secondary" href="user_read.php">Annuler</a>
                    </div>
                </div>
        </div>
        </form>
        <div class="container">
            <div class="row text-light">
                <h2>Tableau des réponses</h2>
            </div>
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-striped table-dark table-bordered text-center">
                        <thead>
                            <th>Id_User</th>
                            <th>Date</th>
                            <th>Questionnaire</th>
                            <th>Réponses</th>
                            <th>Url</th>
                            <th>Contrôle</th>
                        </thead>
                        <tbody>
                            <?php include '../inc/database.php'; //on inclut notre fichier de connection
                            $pdo = Database::connect(); //on se connecte à la base 
                            $sql = "SELECT * FROM user WHERE nom_questionnaire  = '" . ($questionnaire) . "'"; //on formule notre requete
                            $sql .= "ORDER BY id_user ASC";
                            foreach ($pdo->query($sql) as $row) { //on cree les lignes du tableau avec chaque valeur retournée
                                echo '<tr>';
                                echo '<td>' . $row['id_user'] . '</td>';
                                echo '<td>' . $row['date_user'] . '</td>';
                                echo '<td>' . $row['nom_questionnaire'] . '</td>';
                                echo '<td>' . $row['tb_choix'] . '</td>';
                                echo '<td>' . $row['url'] . '</td>';
                                echo '<td>';
                                echo '<a class="btn btn-outline-light btn-sm" href="user_edit.php?id=' . $row['id_user'] . '">Lire</a>'; // un autre td pour le bouton d'edition
                                echo ' ';
                                echo '<a class="btn btn-outline-light btn-sm" href="user_update.php?id=' . $row['id_user'] . '">Mise à jour</a>'; // un autre td pour le bouton d'update
                                echo ' ';
                                echo '<a class="btn btn-outline-light btn-sm" href="user_delete.php?id=' . $row['id_user'] . ' ">Supprimer</a>'; // un autre td pour le bouton de suppression
                                echo ' ';
                                echo '</td>';
                                echo '</tr>';
                            }
                            Database::disconnect(); //on se deconnecte de la base
                            ?>
                        </tbody>
                    </table>
                </div>
    </main>

    <?php
    include('../inc/footer.php');
    ?>
</body>

</html>
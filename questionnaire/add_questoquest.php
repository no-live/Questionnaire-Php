<?php
require '../inc/database.php';
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {

    $addquestionnaire = ($_POST['sel_questionnaire']);
    $addquestion = ($_POST['sel_question']);
    $validreponse = true;

    // si les données sont présentes et bonnes, on se connecte à la base
    if ($validreponse) {
        try {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO link_quest (id_lk_questionnaire, id_lk_question) values(?,?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($addquestionnaire, $addquestion));
            Database::disconnect();
            header("Location: ./add_questoquest.php");
        } finally {
            header("Location: ./add_questoquest.php");
        }
    }
}
?>
<!DOCTYPE html>
<html>

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
                    <h2>Etape 5 :</h2>
                </div>
                <p class="text-light">Sélectionnez le questionnaire auquel attribuer une question. Vous ne pouvez pas modifier un questionnaire déjà publié.</p>
                <hr class="text-light">
                <div class="row mt-3 text-light">
                    <h3>Choisir le questionnaire :</h3>
                </div>
                <form method="POST" action="../questionnaire/add_questoquest.php" class="needs-validation">
                    <label for="question" class="text-light p-2">Choix du questionnaire :</label>
                    <select name="sel_questionnaire" id="question" class="form-control p-2 m-auto" required>
                        <option value="" disabled selected>Cliquez et sélectionnez un questionnaire</option>
                        <<?php
                            $pdo = Database::connect();
                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $sql = "SELECT * FROM questionnaire WHERE quest_check = 0 ORDER BY id_questionnaire DESC";
                            $q = $pdo->query($sql);
                            while ($dataquestion = $q->fetch()) :
                            ?> <option value="<?php echo $dataquestion['id_questionnaire'] ?>"> <?php echo $dataquestion['nom_questionnaire'] ?></option>
                            <!-- on affiche sur la liste le contenu de la question et l'id en "value"  -->
                        <?php
                            endwhile;
                            Database::disconnect();
                        ?>
                    </select>
                    <div class="row mt-2">
                        <h3 class="text-light mt-5">Choisir une question :</h3>
                    </div>
                    <label for="réponse" class="text-light p-2">Choix de la question :</label>
                    <select name="sel_question" id="réponse" class="form-control p-2 m-auto" required>
                        <option value="" disabled selected>Cliquez et sélectionnez une question</option>
                        <<?php
                            $pdo = Database::connect();
                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $sql = "SELECT * FROM question ORDER BY id_question DESC";
                            $q = $pdo->query($sql);
                            while ($datareponse = $q->fetch()) :
                            ?> <option value="<?php echo $datareponse['id_question'] ?>"> <?php echo $datareponse['contenu_question'] ?></option>
                            <!-- on affiche sur la liste le contenu de la réponse et l'id en "value"  -->
                        <?php
                            endwhile;
                            Database::disconnect();
                        ?>
                    </select>


            </div>
            <div class="container p-4">
                <div class="form-actions p-2 text-center">
                    <a class="btn btn-primary mt-2" href="../questionnaire/add_questionnaire.php">Revenir à l'étape précédente</a>
                    <input type="submit" class="btn btn-success p-2 mt-2" name="submit" value="Valider la question">
                    <a class="btn btn-secondary mt-2" href="../index.php">Revenir au menu principal</a>
                    <a class="btn btn-danger mt-2" href="../questionnaire/index.php">Terminer et revenir à la page de démarrage</a>
                </div>
            </div>
            </form>
            <hr class="text-light">
            <p class="text-light">⚠Validez une question et contrôlez dans le tableau ci-dessous si votre questionnaire contient bien la question choisie.
                Recommencez l'opération pour chaque question à affecter au questionnaire.
            </p>
            <hr class="text-light">
            <div class="row mt-3 mb-3 text-light">
                <h3>Questions et réponses correspondantes :</h3>
            </div>
            <div class="table-responsive text-center scroll mb-3">
                <table class="table table-bordered table-striped table-dark table-sm">
                    <caption>Liste des réponses par questions</caption>
                    <thead>
                        <th>Nom du questionnaire</th>
                        <th>Contenu des questions</th>

                    </thead>
                    <tbody>
                        <?php
                        //include '../inc/database.php'; //on inclut notre fichier de connection
                        $pdo = Database::connect(); //on se connecte à la base 
                        $sql = 'SELECT * FROM questionnaire JOIN link_quest ON id_questionnaire = link_quest.id_lk_questionnaire JOIN question ON id_question = link_quest.id_lk_question ORDER BY id_lk_questionnaire DESC'; //on formule notre requete
                        foreach ($pdo->query($sql) as $row) { //on cree les lignes du tableau avec chaque valeur retournée
                            echo '<tr>';
                            echo '<td>' . $row['nom_questionnaire'] . '</td>';
                            echo '<td>' . $row['contenu_question'] . '</td>';
                            //echo '<td>';
                            //echo '<a class="btn btn-secondary" href="./edit.php?id=' . $row['id_rep'] . '">Lire</a>'; // un autre td pour le bouton d'edition
                            //echo '</td>';
                            //echo '<td>';
                            //echo '<a class="btn btn-success" href="./update.php?id=' . $row['id_rep'] . '">Modifier</a>'; // un autre td pour le bouton d'update
                            //echo '</td>';
                            //echo '<td>';
                            //echo '<a class="btn btn-danger" href="./delete.php?id=' . $row['id_rep'] . ' ">Suppr.</a>'; // un autre td pour le bouton de suppression
                            //echo '</td>';
                            echo '</tr>';
                        }
                        Database::disconnect(); //on se deconnecte de la base
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    <?php
    include('../inc/footer.php');
    ?>
</body>

</html>
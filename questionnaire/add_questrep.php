<?php
require '../inc/database.php';
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {

    $addquestrep = ($_POST['question']);
    $addreponse = ($_POST['reponse']);
    $validreponse = true;

    // si les données sont présentes et bonnes, on se connecte à la base
    if ($validreponse) {
        try {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO quest_rep (id_questrep, id_repquest) values(?,?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($addquestrep, $addreponse));
            Database::disconnect();
            header("Location: ./add_questrep.php");
        } finally {
            header("Location: ./add_questrep.php");
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
                    <h2>Etape 3 :</h2>
                </div>
                <p class="text-light">Sélectionnez la question à laquelle attribuer une réponse.</p>
                <hr class="text-light">
                <div class="row mt-3 text-light">
                    <h3>Choisir la question :</h3>
                </div>
                <form method="POST" action="../questionnaire/add_questrep.php" class="needs-validation">
                    <label for="question" class="text-light p-2">Choix de la question :</label>
                    <select name="question" id="question" class="form-control p-2 m-auto" required>
                        <option value="" disabled selected>Cliquez et sélectionnez une question</option>
                        <<?php
                            $pdo = Database::connect();
                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $sql = "SELECT * FROM question ORDER BY id_question DESC";
                            $q = $pdo->query($sql);
                            while ($dataquestion = $q->fetch()) :
                            ?> <option value="<?php echo $dataquestion['id_question'] ?>"> <?php echo $dataquestion['contenu_question'] ?></option>
                            <!-- on affiche sur la liste le contenu de la question et l'id en "value"  -->
                        <?php
                            endwhile;
                            Database::disconnect();
                        ?>
                    </select>
                    <div class="row mt-2">
                        <h3 class="text-light mt-5">Choisir une réponse :</h3>
                    </div>
                    <label for="réponse" class="text-light p-2">Choix de la réponse :</label>
                    <select name="reponse" id="réponse" class="form-control p-2 m-auto" required>
                        <option value="" disabled selected>Cliquez et sélectionnez une réponse</option>
                        <<?php
                            $pdo = Database::connect();
                            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $sql = "SELECT * FROM reponse ORDER BY id_rep DESC";
                            $q = $pdo->query($sql);
                            while ($datareponse = $q->fetch()) :
                            ?> <option value="<?php echo $datareponse['id_rep'] ?>"> <?php echo $datareponse['contenu_rep'] ?></option>
                            <!-- on affiche sur la liste le contenu de la réponse et l'id en "value"  -->
                        <?php
                            endwhile;
                            Database::disconnect();
                        ?>
                    </select>


            </div>
            <div class="container p-4">
                <div class="form-actions p-2 text-center">
                    <a class="btn btn-primary mt-2" href="../questionnaire/add_reponse.php">Revenir à l'étape précédente</a>
                    <input type="submit" class="btn btn-success p-2 mt-2" name="submit" value="Valider la réponse">
                    <a class="btn btn-secondary mt-2" href="../index.php">Revenir au menu principal</a>
                    <a class="btn btn-primary mt-2" href="../questionnaire/add_questionnaire.php">Passez à l'étape suivante</a>
                </div>
            </div>
            </form>
            <hr class="text-light">
            <p class="text-light">⚠Validez une réponse et contrôlez dans le tableau ci-dessous si votre question contient bien la réponse choisie.
                Recommencez l'opération pour chaque question/réponse. 
            </p>
            <hr class="text-light">
            <div class="row mt-3 mb-3 text-light">
                <h3>Questions et réponses correspondantes :</h3>
            </div>
            <div class="table-responsive text-center scroll mb-3">
                <table class="table table-bordered table-striped table-dark table-sm">
                    <caption>Liste des réponses par questions</caption>
                    <thead>
                        <th>Contenu de la question</th>
                        <th>Contenu des réponses</th>

                    </thead>
                    <tbody>
                        <?php
                        //include '../inc/database.php'; //on inclut notre fichier de connection
                        $pdo = Database::connect(); //on se connecte à la base 
                        $sql = 'SELECT * FROM question JOIN quest_rep ON id_question = quest_rep.id_questrep JOIN reponse ON id_rep = quest_rep.id_repquest ORDER BY id_questrep DESC'; //on formule notre requete
                        foreach ($pdo->query($sql) as $row) { //on cree les lignes du tableau avec chaque valeur retournée
                            echo '<tr>';
                            echo '<td>' . $row['contenu_question'] . '</td>';
                            echo '<td>' . $row['contenu_rep'] . '</td>';
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
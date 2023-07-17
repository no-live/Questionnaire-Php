<?php
require '../inc/database.php';
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) { //on initialise nos messages d'erreurs; 
    $addquestionErreur = '';
    $typeErreur = '';
    // on recupère nos valeurs du premier formulaire
    $addquestion = htmlentities(trim($_POST['nom_question']));
    $type = htmlentities(trim($_POST['multi_rep']));
    // on vérifie nos champs 
    $validquestion = true;
    if (empty($addquestion)) {
        $addquestionErreur = 'Entrez une question';
        $validquestion = false;
    } else if (!preg_match("/^[a-zA-Z0-9?]*$/", $addquestion)) {
        $addquestionErreur = "Attention, lettres, nombres et espaces seulement";
    }

    // si les données sont présentes et bonnes, on se connecte à la base
    if ($validquestion) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO question (contenu_question, multi_rep) values(?, ?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($addquestion, $type));
        Database::disconnect();

        header("Location: ../questionnaire/add_question.php");
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
                    <h2>Etape 1 :</h2>
                </div>
                <p class="text-light">Pour "construire" votre questionnaire, saisissez en premier lieu votre/vos question(s).</p>
                <hr class="text-light">
                <div class="row mt-3 text-light">
                    <h3>Ajouter une question :</h3>
                </div>
                <form method="POST" action="../questionnaire/add_question.php" class="needs-validation">
                    <div class="control-group <?php echo !empty($addquestionErreur) ? 'Erreur' : ''; ?>">
                        <label class="control-label text-light p-2">Saisir votre question :</label>
                        <div class="controls">
                            <input name="nom_question" class="form-control p-2 m-auto" type="text" placeholder="Question" value="<?php echo !empty($addquestion) ? $addquestion : ''; ?>" required>
                            <?php if (!empty($addquestionErreur)) : ?>
                                <span class="help-inline text-warning"><?php echo $addquestionErreur; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="control-group col-4 mt-3">
                        <label class="control-label text-light p-2" for="multi_rep">Question à choix multiple :</label>
                        <div class="controls">
                            <select name="multi_rep" id="type" class="form-control p-2 m-auto" required>
                                <option value="" disabled selected>Choisir un type de réponse</option>

                                <option value="0">Un seul choix possible</option>
                                <option value="1">Plusieurs choix possible</option>
                            </select>
                        </div>
                    </div>
                    <div class="container p-4">
                        <div class="form-actions p-2 text-center">
                            <input type="submit" class="btn btn-success p-2 mt-2" name="submit" value="Valider la question">
                            <a class="btn btn-secondary mt-2" href="../index.php">Revenir au menu principal</a>
                            <a class="btn btn-primary mt-2" href="../questionnaire/add_reponse.php">Passez à l'étape suivante</a>
                        </div>
                    </div>
                </form>
                <hr class="text-light">
                <p class="text-light">⚠Vous pouvez réutiliser une question existante dans un nouveau questionnaire, cependant les réponses à cette question seront inchangées.
                    Ressaisissez la question ou modifiez les réponses à cette question avec l'option modifier réponses.</p>
                <hr class="text-light">
                <div class="row mt-3 mb-3 text-light">
                    <h3>Questions disponibles :</h3>
                </div>
                <div class="table-responsive text-center scroll mb-3">
                    <table class="table table-bordered table-striped table-dark table-sm">
                        <caption>Liste des questions</caption>
                        <thead>
                            <th>Contenu de la question</th>
                            <th>Choix multiple</th>
                        </thead>
                        <tbody>
                            <?php
                            //include '../inc/database.php'; //on inclut notre fichier de connection
                            $pdo = Database::connect(); //on se connecte à la base 
                            $sql = 'SELECT * FROM question ORDER BY id_question DESC'; //on formule notre requete
                            foreach ($pdo->query($sql) as $row) { //on cree les lignes du tableau avec chaque valeur retournée
                                echo '<tr>';
                                echo '<td>' . $row['contenu_question'] . '</td>';
                                echo '<td>' . ($row['multi_rep']== 1 ? 'oui' : 'non') . '</td>';
                                //echo '<td>' . $row['multi_rep'] . '</td>';
                                //echo '<td>';
                                //echo '<a class="btn btn-secondary" href="./edit.php?id=' . $row['id_question'] . '">Lire</a>'; // un autre td pour le bouton d'edition
                                //echo '</td>';
                                //echo '<td>';
                                //echo '<a class="btn btn-success" href="./update.php?id=' . $row['id_question'] . '">Modifier</a>'; // un autre td pour le bouton d'update
                                //echo '</td>';
                                //echo '<td>';
                                //echo '<a class="btn btn-danger" href="./delete.php?id=' . $row['id_question'] . ' ">Suppr.</a>'; // un autre td pour le bouton de suppression
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
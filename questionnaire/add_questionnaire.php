<?php
require '../inc/database.php';
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) {

    // on recupère nos valeurs du premier formulaire
    $addquestionnaireErreur = '';
    $addquestionnaire = htmlentities(trim($_POST['nom_questionnaire']));
    $datequestionnaire = date('Y-m-d H:i:s');
    $validreponse = true;
    if (empty($addquestionnaire)) {
        $addquestionnaireErreur = 'Entrez une question';
        $validquestion = false;
    } else if (!preg_match("/^[a-zA-Z0-9]*$/", $addquestionnaire)) {
        $addquestionnaireErreur = "Attention, lettres, nombres et espaces seulement";
    }
    // si les données sont présentes et bonnes, on se connecte à la base
    if ($validreponse) {

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO questionnaire (nom_questionnaire, date_questionnaire) values(?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($addquestionnaire, $datequestionnaire));
        Database::disconnect();
        header("Location: ../questionnaire/add_questionnaire.php");
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
                    <h2>Etape 4 :</h2>
                </div>
                <p class="text-light">Saisissez maintenant un nom pour votre questionnaire.</p>
                <hr class="text-light">
                <div class="row mt-3">
                    <h3 class="text-light">Nom du questionnaire :</h3>
                </div>
                <form method="POST" action="../questionnaire/add_questionnaire.php" class="needs-validation">
                    <div class="control-group <?php echo !empty($addquestionnaireErreur) ? 'Erreur' : ''; ?>">
                        <label class="control-label text-light p-2">Saisir le nom de votre questionnaire :</label>
                        <div class="controls">
                            <input name="nom_questionnaire" class="form-control p-2 m-auto" type="text" placeholder="Questionnaire" value="<?php echo !empty($addquestionnaire) ? $addquestionnaire : ''; ?>" required>
                            <?php if (!empty($addquestionnaireErreur)) : ?>
                                <span class="help-inline text-warning"><?php echo $addquestionErreur; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
            </div>
            <div class="container p-4">
                <div class="form-actions p-2 text-center">
                    <a class="btn btn-primary mt-2" href="../questionnaire/add_questrep.php">Revenir à l'étape précédente</a>
                    <input type="submit" class="btn btn-success p-2 mt-2" name="submit" value="Valider le nom du questionnaire">
                    <a class="btn btn-secondary mt-2" href="../index.php">Revenir au menu principal</a>
                    <a class="btn btn-primary mt-2" href="../questionnaire/add_questoquest.php">Passez à l'étape suivante</a>
                </div>
            </div>
            </form>
            <hr class="text-light">
            <p class="text-light">⚠Le tableau ci-dessous contient tous les questionnaires enregistrés . Vérifiez que votre nouveau questionnaire est bien dans la liste avant de passer à l'étape suivante. </p>
            <hr class="text-light">
            <div class="row mt-3 mb-3 text-light">
                <h3>Questions et réponses disponibles :</h3>
            </div>
            <div class="table-responsive text-center scroll mb-3">
                <table class="table table-bordered table-striped table-dark table-sm">
                    <caption>Liste des questionnaires</caption>
                    <thead>
                        <th>Nom du questionnaire</th>
                        <th>Date de création</th>
                        <th>Disponible</th>
                    </thead>
                    <tbody>
                        <?php
                        $pdo = Database::connect(); //on se connecte à la base 
                        $sql = 'SELECT * FROM questionnaire'; //on formule notre requete
                        foreach ($pdo->query($sql) as $row) { //on cree les lignes du tableau avec chaque valeur retournée
                            echo '<tr>';
                            echo '<td>' . $row['nom_questionnaire'] . '</td>';
                            echo '<td>' . $row['date_questionnaire'] . '</td>';
                            echo '<td>' . ($row['quest_check'] == 1 ? 'en ligne' : 'hors ligne') . '</td>';
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
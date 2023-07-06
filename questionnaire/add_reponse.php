<?php
require '../inc/database.php';
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST)) { //on initialise nos messages d'erreurs; 
    $addreponseErreur = '';
    // on recupère nos valeurs du premier formulaire
    $addreponse = htmlentities(trim($_POST['contenu_rep']));

    // on vérifie nos champs 
    $validreponse = true;
    if (empty($addreponse)) {
        $addreponseErreur = 'Entrez une réponse';
        $validreponse = false;
    } else if (!preg_match("/^[a-zA-Z0-9?]*$/", $addreponse)) {
        $addreponseErreur = "Attention, lettres, nombres et espaces seulement";
    }

    // si les données sont présentes et bonnes, on se connecte à la base
    if ($validreponse) {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO reponse (contenu_rep) values(?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($addreponse));
        Database::disconnect();

        header("Location: ./add_reponse.php");
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
                    <h2>Etape 2 :</h2>
                </div>
                <p class="text-light">Saisissez vos réponses, elles seront rattachées à votre/vos question(s) à l'étape suivante</p>
                <hr class="text-light">
                <div class="row mt-3 text-light">
                    <h3>Ajouter des réponses :</h3>
                </div>
                <form method="POST" action="../questionnaire/add_reponse.php" class="needs-validation">
                    <div class="control-group <?php echo !empty($addreponseErreur) ? 'Erreur' : ''; ?>">
                        <label class="control-label text-light p-2">Saisir votre réponse :</label>
                        <div class="controls">
                            <input name="contenu_rep" class="form-control p-2 m-auto" type="text" placeholder="Nouvelle réponse" value="<?php echo !empty($addreponse) ? $addreponse : ''; ?>" required>
                            <?php if (!empty($addreponseErreur)) : ?>
                                <span class="help-inline text-warning"><?php echo $addreponseErreur; ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

            </div>
            <div class="container p-4">
                <div class="form-actions p-2 text-center">
                    <a class="btn btn-primary mt-2" href="../questionnaire/add_question.php">Revenir à l'étape précédente</a>
                    <input type="submit" class="btn btn-success p-2 mt-2" name="submit" value="Valider la réponse">
                    <a class="btn btn-secondary mt-2" href="../index.php">Revenir au menu principal</a>
                    <a class="btn btn-primary mt-2" href="../questionnaire/add_questrep.php">Passez à l'étape suivante</a>
                </div>
            </div>
            </form>
            <hr class="text-light">
            <p class="text-light">⚠Vous pouvez réutiliser une réponse existante et l'associer avec une nouvelle question.</p>
            <hr class="text-light">
            <div class="row mt-3 mb-3 text-light">
                <h3>Réponses disponibles :</h3>
            </div>
            <div class="table-responsive text-center scroll mb-3">
                <table class="table table-bordered table-striped table-dark table-sm">
                    <caption>Liste des réponses</caption>
                    <thead>
                        <th>Contenu de la réponse</th>
                    </thead>
                    <tbody>
                        <?php
                        //include '../inc/database.php'; //on inclut notre fichier de connection
                        $pdo = Database::connect(); //on se connecte à la base 
                        $sql = 'SELECT * FROM reponse ORDER BY id_rep DESC'; //on formule notre requete
                        foreach ($pdo->query($sql) as $row) { //on cree les lignes du tableau avec chaque valeur retournée
                            echo '<tr>';
                            echo '<td>' . $row['contenu_rep'] . '</td>';
                            //echo '<td>' . $row['multi_rep'] . '</td>';
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

            <!-- <form method="POST" action="" class="needs-validation"> -->
            <!-- <div class="row"> -->
            <!-- <div class="col-10"></div> -->
            <!-- <div class="col-12"> -->
            <!-- < method="POST" action=""> -->
            <!-- <div class="input-fields-wrap"> -->
            <!-- <input type="text" class="form-control p-2" name="reptab[]" placeholder="Réponse"> -->
            <!-- </div> -->
            <!-- <div class="p-2 m-auto"> -->
            <!-- <button class="btn btn-secondary add-field-button p-2">Ajouter une réponse</button> -->
            <!-- <button type="submit" class="btn btn-success p-2">Enregistrer vos réponses</button> -->
            <!-- </div> -->

            <!-- </form> -->
            <!-- </div> -->
            <!-- </div> -->

            <!-- <div class="form-actions"> -->
            <!-- <input type="submit" class="btn btn-success p-3" name="submit" value="Valider"> -->
            <!-- <a class="btn btn-secondary" href="index.php">Annuler</a> -->
            <!-- </div> --> -->
        </div>
    </div>
    </div>
    <?php
    include('../inc/footer.php');
    ?>
    <!-- <script src="../js/addrep.js"></script> -->
</body>

</html>
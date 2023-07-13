<?php
session_start();
include('../inc/database.php');
?>
<?php
if (isset($_POST['submit'])) :  // test sur la présence d'une valeur envoyée depuis le formulaire de choix du questionnaire
    $_SESSION['questionnairevalid'] = $_POST['questionnaire'];
//echo "Choix du questionnaire n° " . $choix_quest;  // Affiche la variable contenant la valeur 

else :
//print_r($_POST('questionnaire'));
//echo "No data";
//header("Location: ../index.php"); // on redirige vers index.php si la valeur est absente
endif;

echo "   " . " session" . " : " .($_SESSION['questionnairevalid']);
?>
<br>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['choixuser']))) {
    //print_r($_POST['choixuser']);
    $questionnaire = ($_SESSION['questionnairevalid']);
    $tz = 'Europe/Paris';
    $timestamp = time();
    $dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
    $dt->setTimestamp($timestamp); //adjust the object to correct timestamp
    //echo $dt->format('d.m.Y, H:i:s');
    $date = $dt->format('d.m.Y, H:i:s');
    $choixusertab = ($_POST['choixuser']);
    $choixusertabencode = json_encode($choixusertab);
    $validchoix = true;
} elseif (empty($_POST['choixuser'])) {
    echo " Pas de réponses";
    $validchoix = false;
}
if ($validchoix == true) {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO user (nom_questionnaire, tb_choix, date_user) values(?, ?, ?)";
    $q = $pdo->prepare($sql);
    $q->execute([$questionnaire, $choixusertabencode, $date]);
    Database::disconnect();
    echo "Réponses sauvegardées!";
    //header("Location: ../index.php");
}

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
        <div class="row text-center p-2">
            <h3 class="text-light mt-3">Questionnaire <?php echo ($_SESSION['questionnairevalid']) ?> :</h3>
        </div>
        <form method="POST" action="../user/user_rep.php">
            <div class="container">
                <div class="row col-12 m-auto p-3">
                    <div class="row text-light p-3 m-auto backgris rounded">
                        <?php
                        $questionnaire = ($_SESSION['questionnairevalid']);
                        $pdo_bc1 = Database::connect(); //on se connecte à la base
                        $pdo_bc1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $sql_bc1 = "SELECT * FROM questionnaire JOIN link_quest ON id_questionnaire = link_quest.id_lk_questionnaire JOIN question ON 
                        id_question = link_quest.id_lk_question WHERE nom_questionnaire  = '" . ($questionnaire) . "'";
                        $q_bc1 = $pdo_bc1->query($sql_bc1);
                        while ($data_quest = $q_bc1->fetch()) :
                        ?>
                            <div class="col-12 backgris rounded">
                                <div class="row text-light p-2">
                                    <?php
                                    echo "<h3>" . "- " . $data_quest['contenu_question'] . "</h3>";
                                    ?>
                                    <hr class="text-dark">
                                    <?php
                                    $choix_quest1 = $data_quest['id_question'];
                                    ?>
                                    <div class="container">
                                        <div class="row align-items-center p-2">
                                            <div class="col-12 p-3">
                                                <?php
                                                $pdo_bc2 = Database::connect(); //on se connecte à la base 
                                                $sql_bc2 = "SELECT * FROM question JOIN quest_rep ON id_question = quest_rep.id_questrep JOIN reponse ON id_rep = quest_rep.id_repquest WHERE
                                                 question.id_question = '" . ($choix_quest1) . "'"; //  on formule notre requete
                                                foreach ($pdo_bc2->query($sql_bc2) as $row) { //on cree les lignes des réponses avec chaque valeur retournée
                                                ?>
                                                    <div class="container">
                                                        <div class="row mt-2">
                                                            <input type="checkbox" class="btn btn-check" id="<?php echo $row['id_question'] ?> / <?php echo $row['id_rep'] ?>" name="choixuser[]" value="<?php echo $row['id_question'] ?> / <?php echo $row['id_rep'] ?>">
                                                            <label class="btn btn-outline-primary text-light" for="<?php echo $row['id_question'] ?> / <?php echo $row['id_rep'] ?>">
                                                                <?php echo $row['contenu_rep'] ?></label>
                                                        </div>
                                                    </div>
                                                <?php

                                                }
                                                Database::disconnect(); //on se deconnecte de la base
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        endwhile;
                        $q_bc1->closecursor();
                        Database::disconnect(); //on se deconnecte de la base
                        ?>
                        <div class="container">
                            <div class="text-center">
                                <input type="submit" class="btn btn-success btn-lg mt-3 p-3" value="SEND">
                                <a class="btn btn-secondary" href="../index.php">Retour</a>
                            </div>
                        </div>
                    </div>
        </form>

    </div>
    </div>
    </div>
    </div>
    <?php
    include('../inc/footer.php');
    ?>
</body>

</html>
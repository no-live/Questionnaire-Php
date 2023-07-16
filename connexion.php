<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<?php
include('./inc/head.php');
include('./inc/link.php');
?>
<body>
    <?php
    include('./inc/header.php');
    ?>
    <main class="container min-vh-100">
        <div class="row">
            <h1>Connexion</h1>
        </div>
        <div class="row">
            <form action="control-connexion.php" method="POST">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Adresse email</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="password">
                </div>

                <button type="submit" class="btn btn-primary">CONNEXION</button>
            </form>
        </div>
    </main>
    <?php
    include('./inc/footer.php');
    ?>
</body>
</html>
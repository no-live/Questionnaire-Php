<header class="">
    <div class="container">
        <div class="row text-center">
            <p class="col-12 align-items-center">
                <a class="text-decoration-none text-dark fs-1 fw-bolder" href="index.php">
                   Questionnaires, études d'impact
                </a>
            </p>

        </div>
        <div class="row bg-secondary rounded-top">
            <div class="col-md-8">
                <nav class="navbar navbar-expand-lg navbar-dark">
                    <div class="container-fluid p-0">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link active text-light" aria-current="page" href="/Tribu/index.php">Page de démarrage</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active text-light" aria-current="page" href="/Tribu/questionnaire/add_question.php">Nouveau questionnaire</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active text-light" aria-current="page" href="/Tribu/user/user_read.php">Lecture</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
            <?php
            if (isset($_SESSION['status']) && $_SESSION['status'] == 'Admin'):
            ?>
                <!-- CONNECTÉ -->
                <div class="col-md-4 d-flex flex-wrap justify-content-end align-items-center gap-2">
                    <!-- DEBUT  -->
                    <div class="dropdown">
                        <a class="btn btn-secondary dropdown-toggle bg-dark" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= !empty($_SESSION['pseudo']) ? $_SESSION['pseudo'] : 'Admin' ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="/Tribu/user/user_read.php">Consulter les données</a></li>
                            <li><a class="dropdown-item disabled" href="#">Link</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="/Tribu/deconnexion.php">DECONNEXION</a></li>
                        </ul>
                    </div>
                    <!-- FIN -->
                </div>
            <?php
            else :
            ?>

                <!-- DECONNECTÉ -->
                <!-- DEBUT  -->
                <div class="col-12 col-md-4 d-flex flex-wrap justify-content-end align-items-center gap-2">
                    <div class="dropdown">
                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <?= !empty($_SESSION['pseudo']) ? $_SESSION['pseudo'] : 'Se connecter' ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="/Tribu/connexion.php">CONNEXION</a></li>
                            <!-- <li><a class="dropdown-item" href="./user-inscription/index.php">INSCRIPTION</a></li> -->
                        </ul>
                    </div>
                </div>
                <!-- FIN -->
            <?php
            endif;
            ?>
        </div>
    </div>
</header>
<?php 
session_start();

// Vide $_SESSION si existe 
session_unset();

// Controle des infos envoyés par l'utilisateur
// echo '$_POST';
// var_dump($_POST);

// BDD - Table user
require './inc/database.php';
$email = '';
$password = '';
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM utilisateurs WHERE email = '$email' AND password = '$password'";
$q = $pdo->query($sql);
$tabs = $q->fetch();

$email= $_POST['email'];
$password= $_POST['password'];


//   while($row = $q->fetch()){
    //       var_dump($row);
    
//   }
  

// $email = $tabs['email'];
// $password = $tabs['password'];
// $pseudo = $q['name'];
// $lang = 'fr';
// $image_profile = 'image/profile.jpg';

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    session_unset();
    $_SESSION['message'] = '✅ Données reçues';

    if ( $_POST['email'] == $email && $_POST['password'] == $password ){
        session_unset();

        $_SESSION['status'] = true;
        $_SESSION['pseudo'] = $pseudo;
        $_SESSION['lang'] = $lang;
        // Retour automatique à la page d'accueil
        header('Location: index.php');

    } else {
        session_unset();

        $_SESSION['message'] = '⚠ Email ou Mot de passe inconnu';

        // header('Location: connexion.php');
    } 


} else {
    session_unset();

    $_SESSION['message'] = '⚠ Veuillez remplir les 2 champs pour vous connecter';

    header('Location: connexion.php');

}


echo '$_SESSION';
var_dump($_SESSION);


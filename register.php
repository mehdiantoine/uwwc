<?php


if (isset($_POST['register_btn'])) {

    require_once "models/sqlconnect.php";

    $user      = strtoupper(htmlentities(trim($_POST['user'])));
    $user2     = strtoupper(htmlentities(trim($_POST['user2'])));
    $password  = md5(       htmlentities(trim($_POST['password'])));
    $password2 = md5(       htmlentities(trim($_POST['password2'])));


    $query = $pdo->prepare(
        'SELECT user_name, password FROM users
                  WHERE user_name = ?');
    $query->execute([$user]);
    $checkUsers = $query->fetchAll(PDO::FETCH_ASSOC);

    if (count($checkUsers) > 0) {
        $addError = "User's already exists";

    } elseif($user == $user2 && $password == $password2) {

        $query = $pdo->prepare("INSERT INTO users (user_name, password, signedUpDate)
                                          VALUES (?, ?, NOW())");
        $query->execute([$user, $password]);

        $register_success = "Your account had been added up succesfully";

    } else {
        $register_error = "You wrote different user name or password. Please retry!";
    }
}

$template = "registerForm";
include_once "www/layout.phtml";

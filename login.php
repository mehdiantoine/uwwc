<?php


if(isset($_POST['login_submit'])) {

    require_once "models/sqlconnect.php";

    $dataUser     = strtoupper(htmlentities(trim(json_decode($_REQUEST["user"]))));
    $dataPassword = md5(       htmlentities(trim(json_decode($_REQUEST["password"]))));

    $user_name    = strtoupper(htmlentities(trim($_POST['user'])));
    $password     = md5(       htmlentities(trim($_POST['password'])));

    if($dataUser == $user_name && $dataPassword == $password) {

        $query = $pdo->prepare("SELECT id, user_name, password FROM users
                                WHERE user_name = ? AND password = ?");
        $query->execute([$user_name, $password]);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if(!$user) {
            //error message
            $loginFailed = "Please enter existing user's name and password";

            $template = "loginForm";
            include_once "www/layout.phtml";

        } else {

            session_start();

            $_SESSION['user_name'] = $user_name;
            $_SESSION['password']  = $password;
            $_SESSION['user_id']   = $user['id'];

            header("location: index.php");
            exit;
        }

    } else {
        //error message
        $ajaxLoginError = "AJAX ERROR!";

        $template = "loginForm";
        include_once "www/layout.phtml";
    }

}
else
{

    $template = "loginForm";
    include_once "www/layout.phtml";

}


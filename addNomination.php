<?php


if(array_key_exists('addNomination', $_POST)) {

    require_once "models/sqlconnect.php";

    $title       = htmlentities(trim($_GET['title']))."\nOne";
    $description = htmlentities(trim($_GET['description']));


    /**
     * CHECKING IF NOMINATION'S ALREADY EXISTS by title
     */

    $query = $pdo->prepare('SELECT title
                            FROM nominations
                            WHERE title = ?');
    $query->execute([$title]);
    $checkNames = $query->fetchAll(PDO::FETCH_ASSOC);

    if (count($checkNames) > 0) {
        $addError = "Nomination's already exists";

    } elseif(empty($title && $description)) {
        $addError =
            "Please make sure you have properly filled the nomination's title
             and description";

    } else {

        $query = $pdo->prepare("INSERT INTO nominations(title, description, postedDate)
                                VALUES (?, ?, NOW())");
        $query->execute([$title, $description]);

        $success = "Your nomination has been added up to our list, thanks a lot!";
    }
}

$template = "add_nomination";
include_once "www/layout.phtml";

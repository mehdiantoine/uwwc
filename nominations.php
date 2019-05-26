<?php


if(isset($_GET['nomination_id'])) {


    /**
     * NOMINATIONS OF A ONE CANDIDATE
     ********************************
     * FROM:
     */

    require_once "models/sqlconnect.php";

    $nomination_id = intval($_GET['nomination_id']);

    $query = $pdo->prepare("SELECT title FROM nominations WHERE id = ?");
    $query->execute([$nomination_id]);
    $nomination = $query->fetch(PDO::FETCH_ASSOC);


    $query = $pdo->prepare('SELECT lastname, firstname, id FROM candidates
                                      WHERE nomination_id = ? ORDER BY firstname');
    $query->execute([$nomination_id]);
    $candidates = $query->fetchAll(PDO::FETCH_ASSOC);

    $template = "nomination_to_vote";
    include_once "www/layout.phtml";

}



/**
 * ALL OF THEM NOMINATIONS
 */

require_once "models/sqlconnect.php";

$query = $pdo->prepare('SELECT * FROM nominations');
$query->execute();
$nominations = $query->fetchAll(PDO::FETCH_ASSOC);



$template = "nominationsView";
include_once "www/layout.phtml";


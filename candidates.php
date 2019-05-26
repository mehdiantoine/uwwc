<?php

require_once "models/sqlconnect.php";


if (isset($_POST['search_submit'])) {

    /******************************
     ****LOOP TO select NOMINATION
     */

    $query = $pdo->prepare('SELECT id, title FROM nominations');
    $query->execute();
    $nominations = $query->fetchAll(PDO::FETCH_ASSOC);

    /*************************************
     ****DIPLAYS A LIST OF ALL CANDIDATES
     * **WITH THE ACCURATE nominations.title
     * +++++ SEARCH by firstname OR lastname
     */

    $firstname_search = htmlentities(trim($_POST['firstname_search']));
    $lastname_search  = htmlentities(trim($_POST['lastname_search']));

    $query = $pdo->prepare("SELECT candidates.*, nominations.title
                            FROM candidates
                            LEFT JOIN nominations
                            ON nominations.id = candidates.nomination_id
                            WHERE firstname = ? OR lastname = ?
                            ORDER BY lastname");
    $query->execute([$firstname_search, $lastname_search]);
    $candidates = $query->fetchAll(PDO::FETCH_ASSOC);
    
} else {

    if(isset($_POST['nominationSelect'])) {

        /***********************
         * **UPDATES NOMINATION
         */

        $id           = intval($_POST['nomination_id']);
        $candidate_id = intval($_POST['candidate_id']);

        $query = $pdo->prepare("UPDATE candidates SET nomination_id = ?
                                WHERE id = ? ");
        $query->execute([$id, $candidate_id]);

    }

    /******************************
     ****LOOP TO select NOMINATION
     */

    $query = $pdo->prepare('SELECT id, title FROM nominations');
    $query->execute();
    $nominations = $query->fetchAll(PDO::FETCH_ASSOC);

    /*************************************
     ****DIPLAYS A LIST OF ALL CANDIDATES
     * **WITH THE ACCURATE nominations.title
     */

    $query = $pdo->prepare("SELECT candidates.*, nominations.title
                            FROM candidates
                            LEFT JOIN nominations
                            ON nominations.id = candidates.nomination_id
                            ORDER BY lastname");
    $query->execute();
    $candidates = $query->fetchAll(PDO::FETCH_ASSOC);
}


$template = "candidates_list";
include_once "www/layout.phtml";

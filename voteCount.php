<?php


require_once "models/sqlconnect.php";

if(isset($_GET['vote_id'])) {

    session_start();

    $user_id = $_SESSION['user_id'];

    $query = $pdo->prepare("SELECT voted FROM users
                                     WHERE id = ?");
    $query->execute([$user_id]);
    $voteCheck = $query->fetch(PDO::FETCH_ASSOC);

    if(!$voteCheck){

        /**
         * USER VOTES ONLY ONCE
         */

        $query = $pdo->prepare('UPDATE users SET voted = 1
                                          WHERE id = ?');
        $query->execute([$user_id]);

        $vote_id = intval($_GET['vote_id']);

        /**
         * INCREMENTING VOTES
         ********************
         * FROM: nomination_to_vote.phtml
         */

        $query = $pdo->prepare("UPDATE candidates SET vote_count = vote_count +1
                                          WHERE id = ?");
        $query->execute([$vote_id]);

        $successVote = "your vote has been counted";

    } else {
        //error message
        $alreadyVoted = 'You have already voted.';

    }

    header("location: index.php");
    exit;
}

/**
 * THE LIST OF ALL CANDIDATES ORDERED BY VOTES IN TOTAL
 ****************************************************/

$query = $pdo->prepare("SELECT firstname, lastname, vote_count, nomination_id
                                  FROM candidates
                                  ORDER BY vote_count DESC");
$query->execute();
$candidatesByVotes = $query->fetchAll(PDO::FETCH_ASSOC);


$template = "contestPosition";
include_once "www/layout.phtml";


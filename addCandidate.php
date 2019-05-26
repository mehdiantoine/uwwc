<?php

class Candidates
{
    public function __construct () {


    }
}


if(isset($_POST['addCandidate'])) {

    require_once "models/sqlconnect.php";

    $firstname   = htmlentities(trim($_POST['firstname']));
    $lastname    = htmlentities(trim($_POST['lastname']));
    $age         = intval           ($_POST['ageCandidate']);
    $nationality = htmlentities(trim($_POST['nationality']));
    $job         = htmlentities(trim($_POST['job']));
    $description = htmlentities(trim($_POST['description']));
    $img         = htmlentities(trim($_FILES['candidate_img']['name']));


    /**
     * CHECKING IF CANDIDATE'S ALREADY IN-LIST by firstname & lastname
     */

    $query = $pdo->prepare('SELECT firstname, lastname
                            FROM candidates
                            WHERE lastname = ? AND firstname = ?');
    $query->execute([$lastname, $firstname]);
    $checkNames = $query->fetchAll(PDO::FETCH_ASSOC);

    if (count($checkNames) > 0) {
        //error message
        $addError = "Candidate's name already in-listed";

    } elseif (empty($firstname && $age && $nationality)) {
        //check if the three necessary items have been filled up properlly. --> NEEDS AJAX PROGRAM!!
        $addError = "Please make sure you have properly filled the candidate's lastname, age and nationality";

    } else {

        $query = $pdo->prepare("INSERT INTO candidates(firstname, lastname, age, nationality, job, description)
                                VALUES (?, ?, ?, ?, ?, ?)");
        $query->execute([$firstname, $lastname, $age, $nationality, $job, $description]);

        $success = "Your candidate has been added up to our list, thanks a lot!";

    }

    /**
     * CANDIDATE's PICTURE UPLOAD
     * (can insert candidate  without a picture)
     */

    // File upload path
    $targetDir      = "uploads/";
    $fileName       = basename($img);
    $targetFilePath = $targetDir . $fileName;
    $fileType       = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');

    $result = "";
    $sizeImgError = "";

    if ($_FILES['candidate_img']['size'] > 499316) {
        //error message
        $sizeImgError = "Image file's way too big";//won't show...

    } elseif(in_array($fileType, $allowTypes)) {

        $result = move_uploaded_file($_FILES['candidate_img']['tmp_name'],
            "uploads/".$_FILES['candidate_img']['name'].".".$fileType);
    }

    /************IMAGE UPDATE in DATABASE**********/

    if($result) {
        $query = $pdo->prepare("UPDATE candidates SET candidate_img_name = ?
                                WHERE firstname = ?");
        $query->execute([$img, $firstname]);

        $uploadSuccess = "Image uploaded successfully.";
    } else {
        //error message
        $addImgError = "Something went wrong while uploading picture, ERROR n°".$_FILES['candidate_img']['error'];
    }


}


$template = "add_candidate_form";
include_once "www/layout.phtml";



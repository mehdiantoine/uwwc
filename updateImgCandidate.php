<?php

require_once "candidates.php";

if(isset($_GET['candidate_id'])) {

    $candidate_id = intval($_GET['candidate_id']);
    $img          = htmlentities(trim($_FILES['candidate_img']['name']));

    /**
     * CANDIDATE's PICTURE UPLOAD
     * (can insert them without it)
     */

    // File upload path
    $targetDir      = "uploads/";
    $fileName       = basename($img);
    $targetFilePath = $targetDir . $fileName;
    $fileType       = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');

    $result       = "";
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
                                WHERE id = ?");
        $query->execute([$img, $candidate_id]);

        $uploadSuccess = "Image uploaded successfully.";
    } else {
        //error message
        $addImgError = "Something went wrong while uploading picture, ERROR n°".$_FILES['candidate_img']['error'];
    }

}

$template = "candidates_list";
include_once "www/layout.phtml";
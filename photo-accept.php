<?php
include "top.php";
$username = htmlentities($_SERVER["REMOTE_USER"], ENT_QUOTES, "UTF-8");
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["photo"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
    echo "The file ". basename( $_FILES["photo"]["name"]). " has been uploaded.";

    $query = 'INSERT INTO `DSCHICK_Pettr`.`tblPhotos` (`pmkPhotoId`, `fldURL`) VALUES (NULL, ?)';
    $data = array('uploads/' . $_FILES["photo"]["name"]);
    $insert = $thisDatabaseWriter->insert($query, $data);

    $query = 'INSERT INTO `DSCHICK_Pettr`.`tblUserPhotos` (`fnkUserId`, `fnkPhotoId`) VALUES (?, NULL)';
    $data = array($username);
    $insert = $thisDatabaseWriter->insert($query, $data);


}
?>

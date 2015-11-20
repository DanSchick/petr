<?php
include "top.php"

    $userID = $_POST['userid'];
    $profileID = $_POST['profileid'];
    $liked = $_POST['like'];

    $query = 'INSERT INTO DSCHICK_Pettr.tblRelations (fnkNonOwnerId, fnkOwnerId, fldLiked, fldMatched)
    VALUES (?, ?, ?)';
    $data = array($userID, $profileID, $liked);
    $insert = $thisDatabaseWriter->insert($query, $data);
    //echo 'okay sick';
?>

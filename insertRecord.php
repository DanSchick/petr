<?php
include "top.php";
if($_POST){
    echo 'test';
    $userID = $_POST['userid'];
    $profileID = $_POST['profileid'];
    $liked = $_POST['like'];

    $query = 'UPDATE DSCHICK_Pettr.tblSeen SET fldSeen=? WHERE pmkUserId = ? AND fnkProfileId = ?';
    $data = array($liked, $userID, $profileID);
    $update = $thisDatabaseWriter->update($query, $data, 1, 1);

    $query = 'INSERT INTO DSCHICK_Pettr.tblRelations (fnkNonOwnerId, fnkOwnerId, fldLiked, fldMatched) VALUES (?, ?, ?, ?)';
    $data = array($userID, $profileID, $liked, 0);
    $insert = $thisDatabaseWriter->insert($query, $data);

    //echo 'okay sick';

} else {
    print '<p>no post</p>';
    $query = 'INSERT INTO DSCHICK_Pettr.tblRelations (fnkNonOwnerId, fnkOwnerId, fldLiked, fldMatched) VALUES (?, ?, ?, ?)';
    $data = array('dschick', 'atbarnes', 1, 0);
    $insert = $thisDatabaseWriter->testquery($query, $data);

    $query = 'UPDATE DSCHICK_Pettr.tblSeen SET fldSeen=? WHERE pmkUserId = ? AND fnkProfileId = ?';
    $data = array($liked, $userID, $profileID);
    $update = $thisDatabaseWriter->testquery($query, $data, 1, 0);

}
?>

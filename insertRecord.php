<?php
include "top.php";
if($_POST){
    $userID = $_POST['userid'];
    $profileID = $_POST['profileid'];
    $liked = $_POST['like'];
    $q = 'SELECT fldLiked FROM tblRelations WHERE fnkUserId = ? AND fnkProfileId = ?';
    $data = array($profileID, $userID);
    $match = $thisDatabaseReader->select($query, $data, 1, 1);
    if($liked == 1 AND $match[0]['fldLiked'] == 'T'){
        echo 'Match';
        $query = 'INSERT INTO DSCHICK_Pettr.tblRelations (fnkUserId, fnkProfileId, fldLiked, fldMatched) VALUES (?, ?, ?, ?)';
        $data = array($userID, $profileID, $liked, 'T');
        $insert = $thisDatabaseWriter->insert($query, $data);

        $query = 'INSERT INTO DSCHICK_Pettr.tblRelations (fnkUserId, fnkProfileId, fldLiked, fldMatched) VALUES (?, ?, ?, ?)';
        $data = array($profileID, $userID, $liked, 'T');
        $insert = $thisDatabaseWriter->insert($query, $data);
    } else{
        echo 'no match';
        $query = 'INSERT INTO DSCHICK_Pettr.tblRelations (fnkUserId, fnkProfileId, fldLiked, fldMatched) VALUES (?, ?, ?, ?)';
        $data = array($userID, $profileID, $liked, 'F');
        $insert = $thisDatabaseWriter->insert($query, $data);
    }
    $query = 'UPDATE DSCHICK_Pettr.tblSeen SET fldSeen=? WHERE pmkUserId = ? AND fnkProfileId = ?';
    $data = array(1, $userID, $profileID);
    $update = $thisDatabaseWriter->update($query, $data, 1, 1);



    //echo 'okay sick';

} else {
    print '<p>no post</p>';
    // $query = 'INSERT INTO DSCHICK_Pettr.tblRelations (fnkNonOwnerId, fnkOwnerId, fldLiked, fldMatched) VALUES (?, ?, ?, ?)';
    // $data = array('dschick', 'atbarnes', 1, 0);
    // $insert = $thisDatabaseWriter->testquery($query, $data);

    // $query = 'UPDATE DSCHICK_Pettr.tblSeen SET fldSeen=? WHERE pmkUserId = ? AND fnkProfileId = ?';
    // $data = array($liked, $userID, $profileID);
    // $update = $thisDatabaseWriter->testquery($query, $data, 1, 0);

    $q = 'SELECT fldLiked FROM tblRelations WHERE fnkUserId = ? AND fnkProfileId = ?';
    $data = array('atbarnes', 'dschick');
    $match = $thisDatabaseReader->select($q, $data, 1, 1);
    if($match[0]['fldLiked'] == 'T'){
        print '<p>we got match</p>';
    } else {
        print '<p>nah</p>';
    }
    print_r($match);

}


?>

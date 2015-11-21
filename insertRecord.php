<?php
include "top.php";
if($_POST){
    $userID = $_POST['userid'];
    $profileID = $_POST['profileid'];
    $liked = $_POST['like'];
    echo $userID;
    echo $profileID;
    echo $liked;
    $q = 'SELECT fldLiked FROM tblRelations WHERE fnkUserId = ? AND fnkProfileId = ?';
    $data = array($profileID, $userID);
    $match = $thisDatabaseReader->select($q, $data, 1, 1);
    if($match[0]['fldLiked'] == ""){
        if($liked == 'T'){
            echo 'flag';
            echo 'no match but likedI';
            $query = 'INSERT INTO DSCHICK_Pettr.tblRelations (fnkUserId, fnkProfileId, fldLiked, fldMatched) VALUES (?, ?, ?, ?)';
            $data = array($userID, $profileID, $liked, 'F');
            $insert = $thisDatabaseWriter->insert($query, $data);
        } else if($liked == 'F'){
            echo 'no match and dislikedIE';
            $query = 'INSERT INTO DSCHICK_Pettr.tblRelations (fnkUserId, fnkProfileId, fldLiked, fldMatched) VALUES (?, ?, ?, ?)';
            $data = array($userID, $profileID, $liked, 'F');
            $insert = $thisDatabaseWriter->insert($query, $data);
        }
    } else if ($match[0]['fldLiked'] == 'T'){
        if($liked == 'T'){
            echo 'MatchII';
            $query = 'INSERT INTO DSCHICK_Pettr.tblRelations (fnkUserId, fnkProfileId, fldLiked, fldMatched) VALUES (?, ?, ?, ?)';
            $data = array($userID, $profileID, $liked, 'T');
            $insert = $thisDatabaseWriter->insert($query, $data);

            $query = 'UPDATE DSCHICK_Pettr.tblRelations SET fldMatched=? WHERE fnkUserId = ? AND fnkProfileId = ? ';
            $data = array('T', $profileID, $userID);
            $insert = $thisDatabaseWriter->insert($query, $data, 1, 1);
        } else if ($liked == 'F'){
            echo 'Would have been match but dislikedIIE';
            $query = 'INSERT INTO DSCHICK_Pettr.tblRelations (fnkUserId, fnkProfileId, fldLiked, fldMatched) VALUES (?, ?, ?, ?)';
            $data = array($userID, $profileID, $liked, 'F');
            $insert = $thisDatabaseWriter->insert($query, $data);
        }
    }
    // echo $match[0]['fldLiked'];

    // if($liked == 'T' AND $match[0]['fldLiked'] == 'T'){
    //     echo 'Match';
    //     $query = 'INSERT INTO DSCHICK_Pettr.tblRelations (fnkUserId, fnkProfileId, fldLiked, fldMatched) VALUES (?, ?, ?, ?)';
    //     $data = array($userID, $profileID, $liked, 'T');
    //     $insert = $thisDatabaseWriter->insert($query, $data);

    //     $query = 'UPDATE DSCHICK_Pettr.tblRelations SET fldMatched=? WHERE fnkUserId = ? AND fnkProfileId = ? ';
    //     $data = array('T', $profileID, $userID);
    //     $insert = $thisDatabaseWriter->insert($query, $data);
    // } else {
        // echo 'no match but liked';
        // $query = 'INSERT INTO DSCHICK_Pettr.tblRelations (fnkUserId, fnkProfileId, fldLiked, fldMatched) VALUES (?, ?, ?, ?)';
        // $data = array($userID, $profileID, $liked, 'F');
        // $insert = $thisDatabaseWriter->insert($query, $data);

    //  }//else{
    //     echo 'no match and disliked';
    //     $query = 'INSERT INTO DSCHICK_Pettr.tblRelations (fnkUserId, fnkProfileId, fldLiked, fldMatched) VALUES (?, ?, ?, ?)';
    //     $data = array($userID, $profileID, $liked, 'F');
    //     $insert = $thisDatabaseWriter->insert($query, $data);
    // }
    $query = 'UPDATE DSCHICK_Pettr.tblSeen SET fldSeen=? WHERE pmkUserId = ? AND fnkProfileId = ?';
    $data = array('1', $userID, $profileID);
    $update = $thisDatabaseWriter->update($query, $data, 1, 1);

    //echo 'okay sick';

} else {
    print '<p>natcasesort(array)o post</p>';
    // $query = 'INSERT INTO DSCHICK_Pettr.tblRelations (fnkNonOwnerId, fnkOwnerId, fldLiked, fldMatched) VALUES (?, ?, ?, ?)';
    // $data = array('dschick', 'atbarnes', 1, 0);
    // $insert = $thisDatabaseWriter->testquery($query, $data);

    // $query = 'UPDATE DSCHICK_Pettr.tblSeen SET fldSeen=? WHERE pmkUserId = ? AND fnkProfileId = ?';
    // $data = array($liked, $userID, $profileID);
    // $update = $thisDatabaseWriter->testquery($query, $data, 1, 0);

    $q = 'SELECT fldLiked FROM tblRelations WHERE fnkUserId = ? AND fnkProfileId = ?';
    $data = array('spakulsk', 'dschick');
    $match = $thisDatabaseReader->select($q, $data, 1, 1);
    if($match[0]['fldLiked'] == 'T'){
        print '<p>we got match</p>';
    } else {
        print '<p>nah</p>';
    }
    print_r($match);

}


?>

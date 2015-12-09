<?php include "top.php";
if($username == 'dschick'){
    $q1 = "DELETE FROM tblSeen";
    $delete = $thisDatabaseWriter->delete($q1, "", 0, 0);
    $q2 = "DELETE FROM tblRelations WHERE fnkUserId='dschick'";
    $delete = $thisDatabaseWriter->delete($q2, "", 1, 0, 2);
    $q2 = "DELETE FROM tblRelations WHERE fnkUserId='spakulsk'";
    $delete = $thisDatabaseWriter->delete($q2, "", 1, 0, 2);

}

print "<article id='admin'><h1>If you don't know what this is, congratualations you just deleted all of our database records. Congrats.</h1></article>";
?>

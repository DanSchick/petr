<?php
include 'top.php';
$username = htmlentities($_SERVER["REMOTE_USER"], ENT_QUOTES, "UTF-8");
$query = 'SELECT * FROM tblOwners WHERE pmkId=?';
$data = array($username);
$user = $thisDatabaseReader->select($query, $data, 1, 0, 0, 0);
$query = 'SELECT fldURL FROM tblPhotos INNER JOIN tblUserPhotos ON tblPhotos.pmkPhotoId=tblUserPhotos.fnkPhotoId WHERE tblUserPhotos.fnkUserId=?';
$data = array($username);
$photo = $thisDatabaseReader->select($query, $data, 1, 0, 0, 0);

?>
<article>
    <section class="cardTitle">
        <h1 class="petTitle"><?php echo $user[0]['fldPetName'];?></h1>
        <h2 class="petTitleInfo"><?php print($user[0]['fldPetType'] . ', Age ' . $user[0]['fldPetAge'] . ', ' . $user[0]['fldCity'] . ', ' . $user[0]['fldState']);?></h2>
    </section>
    <figure class="petImageHolder">
        <img src="<?php echo $photo[0][0]?>" class="petImage" alt="Murphy" title="Murphy">
    </figure>
    <aside class="petInfo">
        <h1>Info</h1>
        <ul>
            <li><?php echo $user[0]['fldPetName'];?></li>
            <li><?php echo $user[0]['fldPetAge'];?></li>
            <li><?php echo $user[0]['fldPetType'];?></li>
            <li>Owned By <?php echo $user[0]['fldOwnerName'];?></li>
            <li>Lives in <?php echo $user[0]['fldCity'] . ', ' . $user[0]['fldState'];?></li>
            <li><?php echo $user[0]['fldDesc'];?></li>
        </ul>
    </aside>
    <figure class='swipe'>
        <a href=''><img src='images/cross.png' class='cross' alt='Not Interested' title='cross'></a>
        <a href=''><img src='images/check.png' class='check' alt='Interested' title='check'></a>
        <div class='align'></div>
    </figure>

</article>
<?php
include 'footer.php';
?>
</body>
</html>


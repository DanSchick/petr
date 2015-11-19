<?php
include 'top.php';
$query = 'SELECT * FROM tblOwners WHERE pmkId=?';
$data = array($username);
$user = $thisDatabaseReader->select($query, $data, 1, 0, 0, 0);
$query = 'SELECT fldURL FROM tblPhotos INNER JOIN tblUserPhotos ON tblPhotos.pmkPhotoId=tblUserPhotos.fnkPhotoId WHERE tblUserPhotos.fnkUserId=?';
$data = array($username);
$photo = $thisDatabaseReader->select($query, $data, 1, 0, 0, 0);
print_r($photo);
if ($_POST){
    $newName = $_POST['fldPetName'];

    $query = 'UPDATE tblOwners
SET fldDesc = ?, `fldOwnerName`=?,`fldEmail`=?,`fldPhone`=?,`fldCity`=?,`fldPetName`=?,`fldPetType`=?,`fldPetAge`=?,`fldState`=?
WHERE pmkId = ?';
    $data=array($_POST['fldDesc']);


}

?>


<article>
    <section class="cardTitle">
        <h1 class="petTitle"><?php echo $user[0]['fldPetName'];?></h1>
        <h2 class="petTitleInfo"><?php print($user[0]['fldPetType'] . ', Age ' . $user[0]['fldPetAge'] . ', ' . $user[0]['fldCity'] . ', ' . $user[0]['fldState']);?></h2>
    </section>
    <figure class="petImageHolder">
        <img src="<?php echo $photo[0][0]?>" class="petImage" id='petImg' alt="Murphy" title="Murphy">
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

<script>
$(document).ready(function(e){
    console.log('okay we cool');
    var loadingImage = loadImage(
        'uploads/1115151705_HDR.jpg',
        function (img) {
            document.getElementById("petImg").src = img.toDataURL();
        },
        {orientation: 1}
    );
};
</script>
<?php
include 'footer.php';
?>
</body>
</html>


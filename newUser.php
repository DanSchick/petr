<?php
include "top.php";
$q = 'INSERT INTO `DSCHICK_Pettr`.`tblOwners` (`fldDesc`, `fldOwnerName`, `fldEmail`, `fldPhone`, `fldCity`, `fldPetName`, `fldPetType`, `fldPetAge`, `fldState`, `pmkId`)
VALUES (NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, ?)';
$data = array($username);
$insert = $thisDatabaseWriter->insert($q, $data, 0, 0);

$query = 'SELECT fldURL FROM tblPhotos';
$photo = $thisDatabaseReader->select($query, "", 0, 0, 0, 0);

$picsz = call_user_func_array('array_merge', $photo);
$pics = array_slice($picsz, 15, 23);
shuffle($pics);
?>
<div id='holder'></div>
<article id='card' class='box animate fadeInLeft one'>
    <section class="cardTitle">
        <h1 class="petTitle">Welcome to Petr!</h1>
    </section>
    <div id='wrapper'>
            <a href='profileUpdate.php' data-ajax='false'><h1>Click here to start editing your profile!</h1></a>
    </div>
    <div class = "petImageHolder" id="container">
            <div class="buddy" style="display: inline-block;">
                <?php
                $picI = 0;
                foreach ($pics as $pic){
                    print '<div class="avatar" style="background-image: url(' . $pic . ')"></div>';
                }
                ?>
                </div>
    </div>

</article>
<script>
    // this creates the image slider
    $('.buddy').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  autoplay: true,
  autoplaySpeed: 2000,
  arrows: false,

});
</script>
<?php
include "footer.php";
?>
</body>
</html>






















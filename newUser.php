<?php
include "top.php";
$q = 'INSERT INTO `DSCHICK_Pettr`.`tblOwners` (`fldDesc`, `fldOwnerName`, `fldEmail`, `fldPhone`, `fldCity`, `fldPetName`, `fldPetType`, `fldPetAge`, `fldState`, `pmkId`)
VALUES (NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, ?)';
$data = array($username);
$insert = $thisDatabaseWriter->insert($q, $data, 0, 0);

$q2 = "INSERT INTO `DSCHICK_Pettr`.`tblRelations` (`fnkUserId`, `fnkProfileId`, `fldLiked`, `fldMatched`) VALUES (?, 'dschick', 'T', 'F')";
$data = array($username);
$ins = $thisDatabaseWriter->insert($q2, $data, 0, 0, 6);

$query = 'SELECT fldURL FROM tblPhotos';
$photo = $thisDatabaseReader->select($query, "", 0, 0, 0, 0);

$picsz = call_user_func_array('array_merge', $photo);
$pics = array_slice($picsz, 15, 23);
shuffle($pics);
?>
<div id='holder'></div>
<article id='card' class='box animate fadeInLeft one'>
    <section class="cardTitle">
        <h1 class="petTitle">Welcome to Petr!  </h1>
    </section>
    <div id='wrapper'>
            <h1>This site is used to mactch dog owners with other dog owners to bring their dogs together.<br>
        You can upload photos of your dog and change information, and then you 'like' or 'pass' on other user's dogs.<br>
        If the other user 'liked' your dog, you both 'match'! You can then view more information in the matches page.
        <br>Dear grader, to show you the matching functionality We've made the second profile you see 'like' you, make sure to hit the green check on them to match.<br>
        <br>If that doesn't work, send me an email at dschick@uvm.edu and I can have another profile like yours so you can see that feature<a href='profileUpdate.php' data-ajax='false'>Click here to start editing your profile!</h1></a>
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






















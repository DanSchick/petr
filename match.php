<script type='text/javascript' src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.5.7/slick.min.js"></script>
<?php include "top.php";

$profileID = $_GET['username'];
// we get a query of all information of a user
$query = 'SELECT * FROM tblOwners WHERE pmkId = ?';
$data = array($profileID);
$profiles = $thisDatabaseReader->select($query, $data, 1, 0);

// now we get a query of all photos of that user
$query = 'SELECT fldURL FROM tblPhotos INNER JOIN tblUserPhotos ON tblPhotos.pmkPhotoId=tblUserPhotos.fnkPhotoId WHERE tblUserPhotos.fnkUserId=?';
$data = array($profiles[0]['pmkId']);
$photo = $thisDatabaseReader->select($query, $data, 1, 0, 0, 0);

?>
<div id='holder'></div>
<article id='card' class='box animate fadeIn one'>
    <section class="cardTitle">
        <h1 class="petTitle"><?php echo $profiles[0]['fldPetName'];?></h1>
        <h2 class="petTitleInfo"><?php echo $profiles[0]['fldPetType']?>, Age <?php echo $profiles[0]['fldPetAge']?>, <?php echo $profiles[0]['fldCity']?>, <?php echo $profiles[0]['fldState']?></h2>
    </section>
    <div class = "petImageHolder" id="container">

            <div class="buddy" style="display: inline-block;">
                <?php
                $picI = 0;
                foreach ($photo as $pic){
                    print '<div class="avatar" style="background-image: url(' . $pic[0] . ')"></div>';
                }
                ?>
                </div>
    </div>
    <div id='wrapper'>
        <blockquote class="bigtext">
            <ul>
                <li><span class='important'>Owner:</span> <?php echo $profiles[0]['fldOwnerName'];?></li>
                <li><span class='important'>Location:</span> <?php echo $profiles[0]['fldCity'];?>, <?php echo $profiles[0]['fldState'];?> </li>
                <li><span class='important'>Pet Description:</span> <?php echo $profiles[0]['fldDesc'];?></li>
                <li><span class='important'>Email:</span> <?php echo $profiles[0]['fldEmail'];?></li>
                <?php if($profiles[0]['fldPhone'] != ""){
                    print '<li><span class="important">Phone Number: </span>' . $profiles[0]['fldPhone'] . '</li>';
                }?>
                <!-- <li><span class='important'>Looking For:</span> Someone to walk and play with Murphy. Currently in school and don't have enough time to give him the love he needs.</li> -->
            </ul>
        </blockquote>
            <p class="expand">Click to read more</p>
            <p class="contract hide">Click to collapse</p>
    </div>

</article>
<script>

$(document).ready(function() {

    $('.buddy').slick();

    $(function(){
  var animspeed = 950; // animation speed in milliseconds

  var $blockquote = $('.bigtext');
  var height = $blockquote.height();
  var mini = $('.bigtext p').eq(0).height() + $('.bigtext p').eq(1).height() + $('.bigtext p').eq(2).height() + $('.bigtext p').eq(2).height();

  $blockquote.attr('data-fullheight',height+'px');
  $blockquote.attr('data-miniheight',mini+'px');
  $blockquote.css('height',mini+'px');
  $('.expand').on('click', function(e){
    $text = $(this).prev();

    $text.animate({
      'height': $text.attr('data-fullheight')
    }, animspeed);
    $(this).next('.contract').removeClass('hide');
    $(this).addClass('hide');
  });

  $('.contract').on('click', function(e){
    $text = $(this).prev().prev();

    $text.animate({
      'height': $text.attr('data-miniheight')
    }, animspeed);
    $(this).prev('.expand').removeClass('hide');
    $(this).addClass('hide');
  });
});
});

</script>

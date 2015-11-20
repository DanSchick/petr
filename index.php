
<!-- first, we import the libs for the image slider -->
<script type='text/javascript' src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.5.7/slick.min.js"></script>

<?php
include 'top.php';

// okay. We need to insert a record of every relation that exists. if it already exists, ignore.
$query = 'INSERT IGNORE INTO tblSeen(pmkUserId, fnkProfileId) (SELECT ?, tblOwners.pmkId FROM tblOwners)';
$data = array($username);
$insert = $thisDatabaseWriter->insert($query, $data);

// we get a query of every profile that the user hasn't seen before
$query = 'SELECT * FROM tblOwners INNER JOIN tblSeen ON tblSeen.fnkProfileId=tblOwners.pmkId WHERE tblSeen.pmkUserId = ? AND tblSeen.fldSeen = 0';
$data = array($username);
$profiles = $thisDatabaseReader->select($query, $data, 1, 1);


$query = 'SELECT fldURL FROM tblPhotos INNER JOIN tblUserPhotos ON tblPhotos.pmkPhotoId=tblUserPhotos.fnkPhotoId WHERE tblUserPhotos.fnkUserId=?';
$data = array($profiles[0]['pmkId']);
$photo = $thisDatabaseReader->select($query, $data, 1, 0, 0, 0);
//print_r($profiles);

$count = 0;
foreach($photo as $pic){
    $count++;
}


?>


<!--
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.4/jquery.mobile-1.4.4.min.css">
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.4/jquery.mobile-1.4.4.min.js"></script>
</head>
<body>
  <div id="container">
    <div class="buddy" style="display: block;"><div id="ava1" class="avatar"  style="display: block; background-image: url(http://www.keenthemes.com/preview/metronic/theme/assets/global/plugins/jcrop/demos/demo_files/image1.jpg)">
      <section class='quickdesc'><button id='info'>More info</button>
<p>
 DO DO DO DOOOOOOOOOOOOOOOOOOOO
        </p> <button id='next'>Next</button></section></div></div>
    <div class="buddy"><div class="avatar" style="display: block; background-image: url(http://static.stylemagazin.hu/medias/29280/Nem-ehezik-a-Women-of-the-Year-legjobb-modell-dijara-eselyes-szepseg_32fc7c86954a8847610499a0fc7261e2.jpg)">
      <section class='quickdesc'><button>More info</button>
<p>
  More info here
        </p></section></div></div></div></div>
    <div class="buddy"><div class="avatar" style="display: block; background-image: url(http://w1nd.cc/promo/347.jpg)"></div></div>
    <div class="buddy"><div class="avatar" style="display: block; background-image: url(http://static.168ora.hu/db/09/AF/orban-d0001C9AFa1ba9618c180.jpg)"></div></div>
  </div>
</body>
</html>
-->
<div id='holder'></div>
<article id='card' class='box animate fadeInLeft one'>
    <section class="cardTitle">
        <h1 class="petTitle"><?php echo $profiles[0]['fldPetName'];?></h1>
        <h2 class="petTitleInfo"><?php echo $profiles[0]['fldPetType']?>, Age <?php echo $profiles[0]['fldPetAge']?>, <?php echo $profiles[0]['fldCity']?>, <?php echo $profiles[0]['fldState']?></h2>
    </section>
    <div class = "petImageHolder" id="container">

            <div class="buddy" style="display: inline-block;">
                <!-- <div class="avatar" id='mainAva' style="background-image: url(<?php echo $photo[0][0];?>)"></div> -->
                <?php
                $picI = 0;
                foreach ($photo as $pic){
                    print '<div class="avatar" style="background-image: url(' . $pic[0] . ')"></div>';
                }

                ?>

                <!-- <div class="avatar" style="background-image: url(<?php echo $photo[0][0];?>)"></div>
                <div class="avatar" style="background-image: url(<?php echo $photo[1][0];?>)"></div> -->

                </div>
                <!-- <button id='next'>Next</button>
                <button id='previous'>Previous</button> -->
    </div>
    <div id='wrapper'>
        <blockquote class="bigtext">
            <!-- <h1>Info</h1> -->
            <ul>
                <li><span class='important'>Owner:</span> <?php echo $profiles[0]['fldOwnerName'];?></li>
                <li><span class='important'>Location:</span> <?php echo $profiles[0]['fldCity'];?>, <?php echo $profiles[0]['fldState'];?> </li>
                <li><span class='important'>Pet Description:</span> <?php echo $profiles[0]['fldDesc'];?></li>
                <!-- <li><span class='important'>Looking For:</span> Someone to walk and play with Murphy. Currently in school and don't have enough time to give him the love he needs.</li> -->
            </ul>
        </blockquote>
            <p class="expand">Click to read more</p>
            <p class="contract hide">Click to collapse</p>
    </div>
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




<!-- JAVASCRIPT SECTION -->
<script>


// First, we declare the like and dislike functions
function like(){
        $('.buddy').addClass('rotate-left').delay(700).fadeOut(1);
        //$('.buddy').find('.status').remove();

        // Send data to insert through AJAX
        var userID = '<?php echo $username;?>';
        var profileID = '<?php echo $profiles[0]['pmkId'];?>';
        var liked = 1;
        var postData = 'userID=' + userID + '&profileID=' + profileID + '&liked=' + liked;
        console.log(postData);

        $.post('insertRecord.php', { userid: userID, profileid : profileID, like : liked},
              function(returnedData){
              console.log(returnedData);
        });
        $('#card').removeClass();
        $('#card').addClass('box animate fadeOutRight one');
        $('#holder').append('<div class="status like">Like!</div>');
        setTimeout(function(){
          window.location.reload(true)},1500);

        // $.ajax({
        //     type: "POST", url: 'InsertRecord.php?userID=' + userID + '&profileID=' + profileID + '&liked=' + liked, success: function(result){
        //       console.log(result);
        //       setTimeout(locaiton.reload(), 5000);
        //     }
        //     });

}

    function dislike(){
        $('.buddy').addClass('.fadeOut').delay(700).fadeOut(1);
        //$('.buddy').find('.status').remove();
        //$('.buddy').append('<div class="status dislike">Dislike!</div>');

        // if ($('.buddy').is(':last-child')) {
        //   $('.buddy:nth-child(1)').removeClass('rotate-left rotate-right').fadeIn(300);
        //   alert('Na-na!');
        // } else {
        //   $('.buddy').next().removeClass('rotate-left rotate-right').fadeIn(400);
        // }

        var userID = '<?php echo $username;?>';
        var profileID = '<?php echo $profiles[0]['pmkId'];?>';
        var liked = 0;
        var postData = 'userID=' + userID + '&profileID=' + profileID + '&liked=' + liked;
        $.post('insertRecord.php', { userid: userID, profileid : profileID, like : liked},
                               function(returnedData){
                                       console.log(returnedData);
                                 });
            $('#card').removeClass();
            $('#card').addClass('box animate fadeOut one');
            $('#holder').append('<div class="status dislike">Dislike!</div>');
            setTimeout(function(){
                       window.location.reload(true)},1500);
    }

var picNum = 0;

// now, we make all the onclick events
$(document).ready(function() {


    $('.buddy').slick();



  $(".buddy").on("swiperight", function() {
    like();
  });

  $(".buddy").on("swipeleft", function() {
    dislike();
  });

  $(".cross").on("click", function() {
    dislike();
  });


  $(".check").on("click", function() {
    like();
  });

  $("[id='next']").click(function() {
    var pics = JSON.parse('<?php echo json_encode($photo);?>');
    var picTotal = <?php echo $count;?>;
    console.log(pics);
    if(picNum != picTotal - 1){
        picNum = picNum + 1;
        var url = 'url(' + pics[picNum][0] + ')';
        document.getElementById("mainAva").style.backgroundImage = url;
    }

    // if(1=1){
    //     console.log('true');
    //     } else{
    //         picNum = picNum -1;
    //     }
    });

    $("[id='previous']").click(function() {
            var pics = JSON.parse('<?php echo json_encode($photo);?>');
            var picTotal = <?php echo $count;?>;
            console.log(pics);
            if(picNum != 0){
                picNum = picNum - 1;
                var url = 'url(' + pics[picNum][0] + ')';
                document.getElementById("mainAva").style.backgroundImage = url;
            }
    });


  /**
   * This function will create the expand/collapse functionality
   */
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

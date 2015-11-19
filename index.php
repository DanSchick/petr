<?php

include 'top.php';
// we get a query of every profile that the user hasn't seen before
$query = 'SELECT * FROM tblOwners INNER JOIN tblSeen ON tblSeen.fnkProfileId=tblOwners.pmkId WHERE tblSeen.pmkUserId = ? AND tblSeen.fldSeen = 0';
$data = array($username);
$profiles = $thisDatabaseReader->select($query, $data, 1, 1);

$query = 'SELECT fldURL FROM tblPhotos INNER JOIN tblUserPhotos ON tblPhotos.pmkPhotoId=tblUserPhotos.fnkPhotoId WHERE tblUserPhotos.fnkUserId=?';
$data = array($username);
$photo = $thisDatabaseReader->select($query, $data, 1, 0, 0, 0);
print_r($photo);

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

<article>
    <section class="cardTitle">
        <h1 class="petTitle">Murphy</h1>
        <h2 class="petTitleInfo">Golden Retriever, Age 6, Colchester, VT</h2>
    </section>
    <div class = "petImageHolder" id="container">
            <div class="buddy" style="display: inline-block;"><div class="avatar" id='mainAva' style="background-image: url(images/alexDog.jpg)"></div></div>
            <button class = "buddy" id='next'>Next</button>
    </div>
    <div id='wrapper'>
        <blockquote class="bigtext">
            <h1>Info</h1>
            <ul>
                <li><span class='important'>Owner:</span> Alex Barnes</li>
                <li><span class='important'>Location:</span> Colchester, VT</li>
                <li><span class='important'>Pet Description:</span> Very playful, loves people, long walks, and playing catch.</li>
                <li><span class='important'>Looking For:</span> Someone to walk and play with Murphy. Currently in school and don't have enough time to give him the love he needs.</li>
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
        $('.buddy').find('.status').remove();

        $('.buddy').append('<div class="status like">Like!</div>');
        if ($('.buddy').is(':last-child')) {
          $('.buddy:nth-child(1)').removeClass('rotate-left rotate-right').fadeIn(300);
        } else {
          $('.buddy').next().removeClass('rotate-left rotate-right').fadeIn(400);
    }
}

    function dislike(){
            $('.buddy').addClass('rotate-right').delay(700).fadeOut(1);
        $('.buddy').find('.status').remove();
        $('.buddy').append('<div class="status dislike">Dislike!</div>');

        if ($('.buddy').is(':last-child')) {
          $('.buddy:nth-child(1)').removeClass('rotate-left rotate-right').fadeIn(300);
          alert('Na-na!');
        } else {
          $('.buddy').next().removeClass('rotate-left rotate-right').fadeIn(400);
        }
    }

var picNum = 0;
$(document).ready(function() {



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
    console.log('test');
    var pics = JSON.parse('<?php echo json_encode($photo);?>');
    console.log(pics[picNum][0]);
    var url = 'url(' + pics[picNum][0] + ')';

    document.getElementById("mainAva").style.backgroundImage = url;

      picNum = picNum + 1;
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

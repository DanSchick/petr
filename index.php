
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


// we get all photos that belong to the first user in the profiles array we just selected
$query = 'SELECT fldURL FROM tblPhotos INNER JOIN tblUserPhotos ON tblPhotos.pmkPhotoId=tblUserPhotos.fnkPhotoId WHERE tblUserPhotos.fnkUserId=?';
$data = array($profiles[0]['pmkId']);
$photo = $thisDatabaseReader->select($query, $data, 1, 0, 0, 0);

if($username == 'dschick'){
  $query = 'DELETE * FROM tblSeen';
  $delete = $thisDatabaseWriter->delete($query, "", 0, 0);
}

?>

<!-- ****************** BEGIN HTML PAGE **************** -->
<div id='holder'></div>
<article id='card' class='box animate fadeInLeft one'>
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
        // Send data to insert through AJAX
        var userID = '<?php echo $username;?>';
        var profileID = '<?php echo $profiles[0]['pmkId'];?>';
        var liked = 'T';
        var postData = 'userID=' + userID + '&profileID=' + profileID + '&liked=' + liked;
        console.log(postData);

        $.post('insertRecord.php', { userid: userID, profileid : profileID, like : liked},
              function(returnedData){
              if(returnedData != ""){
              var data = JSON.parse(returnedData);
              // we execute this function on AJAX success
                if(data["matched"] == '1'){
                  $('#card').removeClass();
                  $('#card').addClass('box animate fadeOutUp');
                  $('#holder').append('<div class="status like">Match!</div>');
                } else {
                  $('#card').removeClass();
                  $('#card').addClass('box animate fadeOutRight');
                  $('#holder').append('<div class="status like">Like!</div>');
                  console.log("flag 1, first if");
                }
              } else {
                  console.log("flag 2, else");
                  $('#card').removeClass();
                  $('#card').addClass('box animate fadeOutRight');
                  $('#holder').append('<div class="status like">Like!</div>');
                }
        });
        // reload page after 1.5 seconds
        setTimeout(function(){
          window.location.reload(true)},1000);


}

    function dislike(){
        // prepare data for AJAX POST
        var userID = '<?php echo $username;?>';
        var profileID = '<?php echo $profiles[0]['pmkId'];?>';
        var liked = 'F';
        var postData = 'userID=' + userID + '&profileID=' + profileID + '&liked=' + liked;
        $.post('insertRecord.php', { userid: userID, profileid : profileID, like : liked},
                               function(returnedData){
                                       console.log(returnedData);
                                 });
            // animate the dislike
            $('#card').removeClass();
            $('#card').addClass('box animate fadeOutDown');
            $('#holder').append('<div class="status dislike">Dislike!</div>');
            setTimeout(function(){
                window.location.reload(true)},1000);
  }

var picNum = 0;

// now, we make all the onclick events
$(document).ready(function() {


    // this creates the image slider
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
  // $("[id='next']").click(function() {
  //   var pics = JSON.parse('<?php echo json_encode($photo);?>');
  //   var picTotal = <?php echo $count;?>;
  //   console.log(pics);
  //   if(picNum != picTotal - 1){
  //       picNum = picNum + 1;
  //       var url = 'url(' + pics[picNum][0] + ')';
  //       document.getElementById("mainAva").style.backgroundImage = url;
  //   }

  //   });

  //   $("[id='previous']").click(function() {
  //           var pics = JSON.parse('<?php echo json_encode($photo);?>');
  //           var picTotal = <?php echo $count;?>;
  //           console.log(pics);
  //           if(picNum != 0){
  //               picNum = picNum - 1;
  //               var url = 'url(' + pics[picNum][0] + ')';
  //               document.getElementById("mainAva").style.backgroundImage = url;
  //           }
  //   });


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

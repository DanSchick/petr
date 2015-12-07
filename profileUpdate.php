<?php
include 'top.php';
$queryOne = 'SELECT * FROM tblOwners WHERE pmkId=?';
$dataOne = array($username);
$user = $thisDatabaseReader->select($queryOne, $dataOne, 1, 0, 0, 0);
$queryTwo = 'SELECT fldURL FROM tblPhotos INNER JOIN tblUserPhotos ON tblPhotos.pmkPhotoId=tblUserPhotos.fnkPhotoId WHERE tblUserPhotos.fnkUserId=?';
$dataTwo = array($username);
$photo = $thisDatabaseReader->select($queryTwo, $dataTwo, 1, 0, 0, 0);




//Initialize every form element as a variable, and set the current content in the database to its default value.
$petName = $user[0]['fldPetName'];
$petAge = $user[0]['fldPetAge'];
$petType = $user[0]['fldPetType'];
$ownerName = $user[0]['fldOwnerName'];
$ownerCity = $user[0]['fldCity'];
$ownerState = $user[0]['fldState'];
$petDesc = $user[0]['fldDesc'];
//Initialize error variables for each field. Assume false.
$petNameError = false;
$petAgeError = false;
$petTypeError = false;
$ownerNameError = false;
$ownerCityError = false;
$ownerStateError = false;
$petDescError = false;
//Initalize arrays
$errorMsg = array();
$dataRecord = array();
if (isset($_POST["btnSubmit"])) {

//Sanitize data
    $petName = htmlentities($_POST["txtPetName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $petName;
    $petAge = htmlentities($_POST["intPetAge"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $petAge;
    $petType = htmlentities($_POST["txtPetType"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $petType;
    $ownerName = htmlentities($_POST["txtOwnerName"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $ownerName;
    $ownerCity = htmlentities($_POST["txtOwnerCity"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $ownerCity;
    $ownerState = htmlentities($_POST["lstOwnerState"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $ownerState;
    $petDesc = htmlentities($_POST["txtPetDesc"], ENT_QUOTES, "UTF-8");
    $dataRecord[] = $petDesc;

//Check For Errors in the submission
    if ($petName == "") {
        $errorMsg[] = "Please enter your Pets Name";
        $petNameError = true;
    } elseif (!verifyAlphaNum($petName)) {
        $errorMsg[] = "Your pets name appears to have extra characters.";
        $petNameError = true;
    }
    if ($petAge == "") {
        $errorMsg[] = "Please enter your Pets Age";
        $petAgeError = true;
    } elseif (!verifyNumeric($petAge)) {
        $errorMsg[] = "Your pets age isn't a number.";
        $petAgeError = true;
    }
    if ($petType == "") {
        $errorMsg[] = "Please enter what animal your Pet is";
        $petTypeError = true;
    } elseif (!verifyAlphaNum($petType)) {
        $errorMsg[] = "Your Pet's type seems to have extra characters.";
        $petTypeError = true;
    }
    if ($ownerName == "") {
        $errorMsg[] = "Please enter your name";
        $ownerNameError = true;
    } elseif (!verifyAlphaNum($ownerName)) {
        $errorMsg[] = "Your name appears to have extra characters.";
        $ownerNameError = true;
    }
    if ($ownerCity == "") {
        $errorMsg[] = "Please enter the city your reside in";
        $ownerCityError = true;
    } elseif (!verifyAlphaNum($ownerCity)) {
        $errorMsg[] = "Your city seems to have extra characters in.";
        $ownerCityError = true;
    }
    if ($ownerState == "") {
        $errorMsg[] = "Please select the state you reside in.";
        $ownerCityError = true;
    }
    if ($petDesc == "") {
        $errorMsg[] = "Please write a short description of your pet, and what you're looking for.";
        $petDescError = true;
    }

    if (!$errorMsg) {


        $updateQuery = 'UPDATE tblOwners SET fldDesc = ?, fldOwnerName = ?, fldCity =?, fldPetName =?, fldPetType = ?, fldPetAge = ?, fldState = ? where pmkId = ?';


        $updateData = array($_POST['txtPetDesc'], $_POST['txtOwnerName'], $_POST['txtOwnerCity'], $_POST['txtPetName'], $_POST['txtPetType'], $_POST['intPetAge'], $_POST['lstOwnerState'], $username);
        $updater = $thisDatabaseWriter->update($updateQuery, $updateData, 1, 0, 0, 0);
        header("Location: profile.php");
    }
}
?>
<form action="<?php print $phpSelf; ?>"
              method="post"
              id="frmRegister">
    <section class="cardTitle">
        <h1 class="petTitle"><?php echo $user[0]['fldPetName']; ?></h1>
        <h2 class="petTitleInfo"><?php print($user[0]['fldPetType'] . ', Age ' . $user[0]['fldPetAge'] . ', ' . $user[0]['fldCity'] . ', ' . $user[0]['fldState']); ?></h2>
    </section>
    <div id="container" class="petImageHolder">
        <div class="buddy" style="display: inline-block;">
                <?php
                if(!$errorMsg){
                  foreach ($photo as $pic){
                    print '<div class="avatar" style="background-image: url(' . $pic[0] . ')"></div>';
                    }
                } else {
                  print '<div class="avatar" style="background-image: url(' . $photo[0][0] . ')"></div>';
                }
                ?>
                </div><img id="delete" src="images/trash.png">
    </div>
    <div class='clas'><a href='upload.php' data-ajax="false"><button>Upload a photo</a></button></div>

 <?php
        // SECTION 3b Error Messages
        //
        // display any error messages before we print out the form
        if ($errorMsg) {
            print '<div id="errors">';
            print "<ol class='errors'>\n";
            foreach ($errorMsg as $err) {
                print "<li>" . $err . "</li>\n";
            }
            print "</ol>\n";
        }
        ?>

        <fieldset class="petInfo">
            <h1>Info</h1>
            <label for="txtPetName" class="required">Pet Name
                <input type="text" id="txtPetName" name="txtPetName"
                       value="<?php print $petName; ?>"
                       tabindex="100" maxlength="45" placeholder="Enter Your Pets Name"
                       <?php
                       if ($petNameError) {
                           print 'class="mistake"';
                       }
                       ?>
                       onfocus="this.select()"
                       autofocus="">
            </label>
            <label for="intPetAge" class="required">Pet Age
                <input type="text" id="intPetAge" name="intPetAge"
                       value="<?php print $petAge; ?>"
                       tabindex="100" maxlength="45" placeholder="Enter Your Pets Age"
                       <?php
                       if ($petAgeError) {
                           print 'class="mistake"';
                       }
                       ?>
                       onfocus="this.select()"
                       autofocus="">
            </label>
            <label for="txtPetType" class="required">Pet Type
                <input type="text" id="txtPetType" name="txtPetType"
                       value="<?php print $petType; ?>"
                       tabindex="100" maxlength="45" placeholder="Enter What Animal Your Pet Is"
                       <?php
                       if ($petTypeError) {
                           print 'class="mistake"';
                       }
                       ?>
                       onfocus="this.select()"
                       autofocus="">
            </label>
            <label for="txtOwnerName" class="required">Owner Name
                <input type="text" id="txtOwnerName" name="txtOwnerName"
                       value="<?php print $ownerName; ?>"
                       tabindex="100" maxlength="45" placeholder="Enter Your Full Name"
                       <?php
                       if ($ownerNameError) {
                           print 'class="mistake"';
                       }
                       ?>
                       onfocus="this.select()"
                       autofocus="">
            </label>
            <label for="txtOwnerCity" class="required">Owner City
                <input type="text" id="txtOwnerCity" name="txtOwnerCity"
                       value="<?php print $ownerCity; ?>"
                       tabindex="100" maxlength="45" placeholder="Enter The City You Live In"
                       <?php
                       if ($ownerCityError) {
                           print 'class="mistake"';
                       }
                       ?>
                       onfocus="this.select()"
                       autofocus="">
            </label>

            <label for="lstOwnerState" value="<?php print $ownerState;?>">State: </label>
            <select  id="lstOwnerState" name="lstOwnerState">
                <option <?php if ($ownerState == "Alabama") print " selected "; ?> value="Alabama">Alabama</option>
                <option <?php if ($ownerState == "Alaska") print " selected "; ?>value="Alaska">Alaska</option>
                <option <?php if ($ownerState == "Arizona") print " selected "; ?>value="Arizona">Arizona</option>
                <option <?php if ($ownerState == "Arkansas") print " selected "; ?>value="Arkansas">Arkansas</option>
                <option <?php if ($ownerState == "California") print " selected "; ?>value="California">California</option>
                <option <?php if ($ownerState == "Colorado") print " selected "; ?>value="Colorado">Colorado</option>
                <option <?php if ($ownerState == "Connecticut") print " selected "; ?>value="Connecticut">Connecticut</option>
                <option <?php if ($ownerState == "Delaware") print " selected "; ?>value="Delaware">Delaware</option>
                <option <?php if ($ownerState == "District of Columbia") print " selected "; ?>value="District of Columbia">District Of Columbia</option>
                <option <?php if ($ownerState == "Florida") print " selected "; ?>value="Florida">Florida</option>
                <option <?php if ($ownerState == "Georgia") print " selected "; ?>value="Georgia">Georgia</option>
                <option <?php if ($ownerState == "Hawaii") print " selected "; ?>value="Hawaii">Hawaii</option>
                <option <?php if ($ownerState == "Idaho") print " selected "; ?>value="Idaho">Idaho</option>
                <option <?php if ($ownerState == "Illinois") print " selected "; ?>value="Illinois">Illinois</option>
                <option <?php if ($ownerState == "Indiana") print " selected "; ?>value="Indiana">Indiana</option>
                <option <?php if ($ownerState == "Iowa") print " selected "; ?>value="Iowa">Iowa</option>
                <option <?php if ($ownerState == "Kansas") print " selected "; ?>value="Kansas">Kansas</option>
                <option <?php if ($ownerState == "Kentucky") print " selected "; ?>value="Kentucky">Kentucky</option>
                <option <?php if ($ownerState == "Louisiana") print " selected "; ?>value="Lousiana">Louisiana</option>
                <option <?php if ($ownerState == "Maine") print " selected "; ?>value="Maine">Maine</option>
                <option <?php if ($ownerState == "Maryland") print " selected "; ?>value="Maryland">Maryland</option>
                <option <?php if ($ownerState == "Massachusetts") print " selected "; ?>value="Massachussetts">Massachusetts</option>
                <option <?php if ($ownerState == "Michigian") print " selected "; ?>value="Michigan">Michigan</option>
                <option <?php if ($ownerState == "Minnesota") print " selected "; ?>value="Minessota">Minnesota</option>
                <option <?php if ($ownerState == "Mississippi") print " selected "; ?>value="Mississippi">Mississippi</option>
                <option <?php if ($ownerState == "Missouri") print " selected "; ?>value="Missouri">Missouri</option>
                <option <?php if ($ownerState == "Montana") print " selected "; ?>value="Montana">Montana</option>
                <option <?php if ($ownerState == "Nebraska") print " selected "; ?>value="Nebraska">Nebraska</option>
                <option <?php if ($ownerState == "Nevada") print " selected "; ?>value="Nevada">Nevada</option>
                <option <?php if ($ownerState == "New Hampshire") print " selected "; ?>value="New Hampshire">New Hampshire</option>
                <option <?php if ($ownerState == "New Jersey") print " selected "; ?>value="New Jersey">New Jersey</option>
                <option <?php if ($ownerState == "New Mexico") print " selected "; ?>value="New Mexico">New Mexico</option>
                <option <?php if ($ownerState == "New York") print " selected "; ?>value="New York">New York</option>
                <option <?php if ($ownerState == "North Carolina") print " selected "; ?>value="North Carolina">North Carolina</option>
                <option <?php if ($ownerState == "North Dakota") print " selected "; ?>value="North Dakota">North Dakota</option>
                <option <?php if ($ownerState == "Ohio") print " selected "; ?>value="Ohio">Ohio</option>
                <option <?php if ($ownerState == "Oklahoma") print " selected "; ?>value="Oklahoma">Oklahoma</option>
                <option <?php if ($ownerState == "Oregon") print " selected "; ?>value="Oregon">Oregon</option>
                <option <?php if ($ownerState == "Pennsylvania") print " selected "; ?>value="Pennsylvania">Pennsylvania</option>
                <option <?php if ($ownerState == "Rhode Island") print " selected "; ?>value="Rhode Island">Rhode Island</option>
                <option <?php if ($ownerState == "South Carolina") print " selected "; ?>value="South Carolina">South Carolina</option>
                <option <?php if ($ownerState == "South Dakota") print " selected "; ?>value="South Dakota">South Dakota</option>
                <option <?php if ($ownerState == "Tennessee") print " selected "; ?>value="Tennessee">Tennessee</option>
                <option <?php if ($ownerState == "Texas") print " selected "; ?>value="Texas">Texas</option>
                <option <?php if ($ownerState == "Utah") print " selected "; ?>value="Utah">Utah</option>
                <option <?php if ($ownerState == "Vermont") print " selected "; ?>value="Vermont">Vermont</option>
                <option <?php if ($ownerState == "Virginia") print " selected "; ?>value="Virginia">Virginia</option>
                <option <?php if ($ownerState == "Washington") print " selected "; ?>value="Washington">Washington</option>
                <option <?php if ($ownerState == "West Virginia") print " selected "; ?>value="West Virginia">West Virginia</option>
                <option <?php if ($ownerState == "Wisconsin") print " selected "; ?>value="Wisconsin">Wisconsin</option>
                <option <?php if ($ownerState == "Wyoming") print " selected "; ?>value="Wyoming">Wyoming</option>
            </select>
            <label for="txtPetDesc" class="required">Pet Description
                <input type="text" id="txtPetDesc" name="txtPetDesc"
                       value="<?php print $petDesc; ?>"
                       tabindex="100" maxlength="45" placeholder="Enter A Description Of Your Pet, and What You Are Looking For In Somebody Else!"
                       <?php
                       if ($petDescError) {
                           print 'class="mistake"';
                       }
                       ?>
                       onfocus="this.select()"
                       autofocus="">
            </label>
            <input type="submit" id="btnSubmit" name="btnSubmit" value="Make Changes" tabindex="900" class="button">
        </fieldset>


    </form>
    <?php if(!$errorMsg){print "<script>
  $('.buddy').slick();
  var picI = 1;
</script>";}?>

    <?php
    include 'footer.php';
    ?>

<script>
var userID = '<?php echo $username;?>';
// first, we make the pic index variable follow the picture changes
$('.slick-next').on('click', function(){
  if(picI == <?php echo count($photo);?>){
    picI = 1;
  } else {
    picI += 1;
  } console.log(picI);
});

$('.slick-prev').on('click', function(){
  if(picI == 1){
    picI = <?php echo count($photo);?>;
  } else {
    picI -= 1;
  } console.log(picI);
});


$('#delete').on('click', function() {
  $.post('deletePhoto.php', { userid: userID, picI : picI},
                               function(returnedData){
                                       console.log(returnedData);
                                 });

})
</script>
</body>
</html>






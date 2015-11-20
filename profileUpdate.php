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
print "<p>WHAT</p>";
if (isset($_POST["btnSubmit"])) {
    
    print "<p>were in</p>";
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
    
    print "<p>Error<pre>"; print_r($errorMsg); print "</pre></p>";
    if (!$errorMsg) {
        

        $updateQuery = 'UPDATE tblOwners SET fldDesc = ?, fldOwnerName = ?, fldCity =?, fldPetName =?, fldPetType = ?, fldPetAge = ? where pmkId = ?';
        
        
        $updateData = array($_POST['txtPetDesc'], $_POST['txtOwnerName'], $_POST['txtOwnerCity'], $_POST['txtPetName'], $_POST['txtPetType'], $_POST['intPetAge'], $username);
        $updater = $thisDatabaseWriter->update($updateQuery, $updateData, 1, 0, 0, 0);
    }
}
?>
<form action="<?php print $phpSelf; ?>" method="POST" id="frmRegister">
    <section class="cardTitle">
        <h1 class="petTitle"><?php echo $user[0]['fldPetName']; ?></h1>
        <h2 class="petTitleInfo"><?php print($user[0]['fldPetType'] . ', Age ' . $user[0]['fldPetAge'] . ', ' . $user[0]['fldCity'] . ', ' . $user[0]['fldState']); ?></h2>
    </section>
    <figure class="petImageHolder">
        <img src="<?php echo $photo[0][0] ?>" class="petImage" alt="Murphy" title="Murphy">
    </figure>
   
 <?php
    if (isset($_POST["btnSubmit"])){

        // SECTION 3b Error Messages
        //
        // display any error messages before we print out the form
        if ($errorMsg) {
            print '<div id="errors">';
            print "<ol>\n";
            foreach ($errorMsg as $err) {
                print "<li>" . $err . "</li>\n";
            }
            print "</ol>\n";
            print '</div>';
        }
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
            <label for="txtPetAge" class="required">Pet Age
                <input type="number" id="intPetAge" name="intPetAge"
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

            <label for="lstState">State: </label>
            <select>
                <option value="AL">Alabama</option>
                <option value="AK">Alaska</option>
                <option value="AZ">Arizona</option>
                <option value="AR">Arkansas</option>
                <option value="CA">California</option>
                <option value="CO">Colorado</option>
                <option value="CT">Connecticut</option>
                <option value="DE">Delaware</option>
                <option value="DC">District Of Columbia</option>
                <option value="FL">Florida</option>
                <option value="GA">Georgia</option>
                <option value="HI">Hawaii</option>
                <option value="ID">Idaho</option>
                <option value="IL">Illinois</option>
                <option value="IN">Indiana</option>
                <option value="IA">Iowa</option>
                <option value="KS">Kansas</option>
                <option value="KY">Kentucky</option>
                <option value="LA">Louisiana</option>
                <option value="ME">Maine</option>
                <option value="MD">Maryland</option>
                <option value="MA">Massachusetts</option>
                <option value="MI">Michigan</option>
                <option value="MN">Minnesota</option>
                <option value="MS">Mississippi</option>
                <option value="MO">Missouri</option>
                <option value="MT">Montana</option>
                <option value="NE">Nebraska</option>
                <option value="NV">Nevada</option>
                <option value="NH">New Hampshire</option>
                <option value="NJ">New Jersey</option>
                <option value="NM">New Mexico</option>
                <option value="NY">New York</option>
                <option value="NC">North Carolina</option>
                <option value="ND">North Dakota</option>
                <option value="OH">Ohio</option>
                <option value="OK">Oklahoma</option>
                <option value="OR">Oregon</option>
                <option value="PA">Pennsylvania</option>
                <option value="RI">Rhode Island</option>
                <option value="SC">South Carolina</option>
                <option value="SD">South Dakota</option>
                <option value="TN">Tennessee</option>
                <option value="TX">Texas</option>
                <option value="UT">Utah</option>
                <option value="VT">Vermont</option>
                <option value="VA">Virginia</option>
                <option value="WA">Washington</option>
                <option value="WV">West Virginia</option>
                <option value="WI">Wisconsin</option>
                <option value="WY">Wyoming</option>
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
    <?php
    include 'footer.php';
    ?>
</body>
</html>

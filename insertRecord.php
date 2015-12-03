    <?php
        // we have to import top.php, but only the parts that don't print HTML.
        // Otherwise, returning data to the AJAX call won't work.
        $debug = false;

        // %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
        //
        // inlcude all libraries. Note some are in lib and some are in bin
        // bin should be located at the same level as www-root (it is not in
        // github)
        //
        // yourusername
        //     bin
        //     www-logs
        //     www-root

        include "lib/constants.php";
        require_once('lib/custom-functions.php');

        $includeDBPath = "../bin/";
        $includeLibPath = "../lib/";


        require_once($includeLibPath . 'mailMessage.php');

        require_once('lib/security.php');

        require_once($includeDBPath . 'Database.php');

        // %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
        //
        // PATH SETUP
        //

        // sanitize the server global variable
        $_SERVER = filter_input_array(INPUT_SERVER, FILTER_SANITIZE_STRING);
        foreach ($_SERVER as $key => $value) {
            $_SERVER[$key] = sanitize($value, false);
        }

        $domain = "//"; // let the server set http or https as needed

        $server = htmlentities($_SERVER['SERVER_NAME'], ENT_QUOTES, "UTF-8");

        $domain .= $server;

        $phpSelf = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES, "UTF-8");

        $path_parts = pathinfo($phpSelf);

        if ($debug) {
            print "<p>Domain" . $domain;
            print "<p>php Self" . $phpSelf;
            print "<p>Path Parts<pre>";
            print_r($path_parts);
            print "</pre>";
        }

        $yourURL = $domain . $phpSelf;

        // %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
        // sanatize global variables
        // function sanitize($string, $spacesAllowed)
        // no spaces are allowed on most pages but your form will most likley
        // need to accept spaces. Notice my use of an array to specfiy whcih
        // pages are allowed.
        // generally our forms dont contain an array of elements. Sometimes
        // I have an array of check boxes so i would have to sanatize that, here
        // i skip it.

        $spaceAllowedPages = array("form.php");

        if (!empty($_GET)) {
            $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
            foreach ($_GET as $key => $value) {
                $_GET[$key] = sanitize($value, false);
            }
        }

        // %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
        //
        // Process security check.
        //

        if (!securityCheck($path_parts, $yourURL)) {
            print "<p>Login failed: " . date("F j, Y") . " at " . date("h:i:s") . "</p>\n";
            die("<p>Sorry you cannot access this page. Security breach detected and reported</p>");
        }

        // %^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%^%
        //
        // Set up database connection
        //

        $dbUserName = get_current_user() . '_reader';
        $whichPass = "r"; //flag for which one to use.
        $dbName = DATABASE_NAME;

        $thisDatabaseReader = new Database($dbUserName, $whichPass, $dbName);

        $dbUserName = get_current_user() . '_writer';
        $whichPass = "w";
        $thisDatabaseWriter = new Database($dbUserName, $whichPass, $dbName);

/**************** BEGIN $_POST AJAX PROCESSING *************/
if($_POST){
    // gather variables
    $userID = $_POST['userid'];
    $profileID = $_POST['profileid'];
    $liked = $_POST['like'];
    // check if the profile the user is viewing has 'liked' the user
    $q = 'SELECT fldLiked FROM tblRelations WHERE fnkUserId = ? AND fnkProfileId = ?';
    $data = array($profileID, $userID);
    $match = $thisDatabaseReader->select($q, $data, 1, 1);
    // if no record exists in table
    if($match[0]['fldLiked'] == ""){
        if($liked == 'T'){
            echo json_encode(array("matched" => "0"));
            $query = 'INSERT INTO DSCHICK_Pettr.tblRelations (fnkUserId, fnkProfileId, fldLiked, fldMatched) VALUES (?, ?, ?, ?)';
            $data = array($userID, $profileID, $liked, 'F');
            $insert = $thisDatabaseWriter->insert($query, $data);
        } else if($liked == 'F'){
            echo json_encode(array("matched" => "0"));
            $query = 'INSERT INTO DSCHICK_Pettr.tblRelations (fnkUserId, fnkProfileId, fldLiked, fldMatched) VALUES (?, ?, ?, ?)';
            $data = array($userID, $profileID, $liked, 'F');
            $insert = $thisDatabaseWriter->insert($query, $data);
        }
    // if a record exists for the user
    } else if ($match[0]['fldLiked'] == 'T'){
        if($liked == 'T'){
            // It's a match!
            $result = array("matched" => "1");
            echo json_encode($result);
            $query = 'INSERT INTO DSCHICK_Pettr.tblRelations (fnkUserId, fnkProfileId, fldLiked, fldMatched) VALUES (?, ?, ?, ?)';
            $data = array($userID, $profileID, $liked, 'T');
            $insert = $thisDatabaseWriter->insert($query, $data);

            $query = 'UPDATE DSCHICK_Pettr.tblRelations SET fldMatched=? WHERE fnkUserId = ? AND fnkProfileId = ? ';
            $data = array('T', $profileID, $userID);
            $insert = $thisDatabaseWriter->insert($query, $data, 1, 1);
        } else if ($liked == 'F'){
            echo json_encode(array("matched" => "0"));
            $query = 'INSERT INTO DSCHICK_Pettr.tblRelations (fnkUserId, fnkProfileId, fldLiked, fldMatched) VALUES (?, ?, ?, ?)';
            $data = array($userID, $profileID, $liked, 'F');
            $insert = $thisDatabaseWriter->insert($query, $data);
        }
    }

    $query = 'UPDATE DSCHICK_Pettr.tblSeen SET fldSeen=? WHERE pmkUserId = ? AND fnkProfileId = ?';
    $data = array('1', $userID, $profileID);
    $update = $thisDatabaseWriter->update($query, $data, 1, 1);


}
?>

<?php
include "lib/constants.php";
require_once('lib/custom-functions.php');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Petr - People Helping Pets</title>
        <meta charset="utf-8">
        <meta name="author" content="Samuel Pakulski and Danny Schick">
        <meta name="description" content="Petr is a place for pet owners to offer there pets love, and for people looking for some love to play with animals">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/sin/trunk/html5.js"></script>
        <![endif]-->

        <link rel="stylesheet" href="css/base.css" type="text/css" media="screen">

        <?php
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

        $dbUserName = 'dschick_reader';
        $whichPass = "r"; //flag for which one to use.
        $dbName = DATABASE_NAME;

        $thisDatabaseReader = new Database($dbUserName, $whichPass, $dbName);

        $dbUserName = 'dschick_writer';
        $whichPass = "w";
        $thisDatabaseWriter = new Database($dbUserName, $whichPass, $dbName);

        $dbUserName = 'dschick_admin';
        $whichPass = "a";
        $thisDatabaseAdmin = new Database($dbUserName, $whichPass, $dbName);
        if ($path_parts['filename'] == "profileUpdate") {
            include "lib/validation-functions.php";
        }
        ?>

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.5.8/slick.css"/>
        <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.5.8/slick-theme.css"/> -->

        <script type='text/javascript' src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.5.7/slick.min.js"></script>
        <script type='text/javascript' src="https://code.jquery.com/mobile/1.4.4/jquery.mobile-1.4.4.min.js"></script>


    </head>

    <!-- **********************     Body section      ********************** -->
    <?php
    $username = htmlentities($_SERVER["REMOTE_USER"], ENT_QUOTES, "UTF-8");
    // $nonOwnerQuery = $thisDatabaseReader->select("SELECT * FROM tblNonOwners WHERE pmkId=?",array($username), 1, 0, 0, 0);
    // $OwnerQuery = $thisDatabaseReader->select("SELECT * FROM tblOwners WHERE pmkId=?",array($username), 1, 0, 0, 0);
    //print_r($nonOwnerQuery, $OwnerQuery);
    // if(empty($OwnerQuery) AND empty($NonOwnerQuery)){
    //     HEADER('Location: newUser.php');
    // }
    print '<body id="' . $path_parts['filename'] . '">';
    print '<div data-role="page">';


    include "header.php";
    ?>



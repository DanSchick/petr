<!-- ######################     Main Navigation   ########################## -->
<nav>
    <img src='images/menu-icon.png' class='menuIcon'>
    <ol>
        <?php
        // This sets the current page to not be a link. Repeat this if block for
        //  each menu item 
        if ($path_parts['filename'] == "index") {
            print '<li class="activePage">Home</li>';
        } else {
            print '<li><a href="index.php">Home</a></li>';
        }

        if ($path_parts['filename'] == "profile") {
            print '<li class="activePage">Profile</li>';
        } else {
            print '<li><a href="profile.php">Profile</a></li>';
        }

        if ($path_parts['filename'] == "matches.php") {
            print '<li class="activePage">Matches</li>';
        } else {
            print '<li><a href="matches.php">Matches</a></li>';
        }
        ?>
    </ol>
</nav>
        <!-- #################### Ends Main Navigation    ########################## -->

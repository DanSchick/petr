<?php
include 'top.php';

// okay, let's get an array of all matches
$query = "SELECT * FROM tblOwners INNER JOIN tblRelations ON tblOwners.pmkId = tblRelations.fnkProfileId
WHERE tblRelations.fldMatched = ? AND tblRelations.fnkUserId = ?";
$data = array("T", $username);
$profiles = $thisDatabaseReader->select($query, $data, 0, 1);
?>
<article id="matches" class="box animate fadeIn one">
    <section class="cardTitle">
        <h1 class="petTitle">Matches</h1>
    </section>

    <table>
        <thead>
            <tr>
                <th></th>
                <th> Pet Name </th>
                <th> Owner Name </th>
                <th> Pet Type </th>
                <th> Location </th>
            </tr>
        </thead>
        <?php
        foreach($profiles as $prof){
            print '<tr>
            <td><img></td>
            <td> <a href=match.php?username=' . $prof['pmkId'] . '>' . $prof['fldPetName'] . '</a> </td>
            <td> ' . $prof['fldOwnerName'] . ' </td>
            <td> ' . $prof['fldPetType'] . ' </td>
            <td> ' . $prof['fldCity'] . ', ' .  $prof['fldState'] . ' </td>
        </tr>';}?>
    </table>

</article>
<?php
include 'footer.php';
?>
</body>
</html>

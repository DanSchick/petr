<?php
include "top.php";

?>

<form action="photo-accept.php"  data-ajax="false" method="post" enctype="multipart/form-data">
Select Image:
<input type="file" name="photo" id="photo">
<input type="submit" value="Upload" name="submit">
</form>
<?php
include 'footer.php';
?>
</body>

</HTML>

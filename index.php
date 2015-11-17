<?php

include 'top.php';
$query = 'SELECT * FROM tblPets';
$info = $thisDatabaseReader->select($query,"",0,0,0,0);

?>
<article>
    <section class="cardTitle">
        <h1 class="petTitle">Murphy</h1>
        <h2 class="petTitleInfo">Golden Retriever, Age 6, Colchester, VT</h2>
    </section>
    <figure class="petImageHolder">
        <img src="images/alexDog.jpg" class="petImage" alt="Murphy" title="Murphy">
    </figure>
    <aside class="petInfo">
        <h1>Info</h1>
        <ul>
            <li><span class='important'>Name:</span> Murphy</li>
            <li><span class='important'>Age:</span> 6</li>
            <li><span class='important'>Breed:</span> Golden Retriever</li>
            <li><span class='important'>Owner:</span> Alex Barnes</li>
            <li><span class='important'>Location:</span> Colchester, VT</li>
            <li><span class='important'>Pet Description:</span> Very playful, loves people, long walks, and playing catch.</li>
            <li><span class='important'>Looking For:</span> Someone to walk and play with Murphy. Currently in school and don't have enough time to give him the love he needs.</li>
        </ul>
    </aside>
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


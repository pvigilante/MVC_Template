<?php
require_once("../../controllers/includes.php");
?>
<p>
Create a Button that opens a Modal window.<br>
Create a new file > /views/users/show.php<br>
In scripts.js, On button click, use $.get to load the show.php file.<br>
In show.php, output the $current_user data.<br>
In scripts.js, Display the results of show.php in the Modal.<br>
</p>
<?php
echo '<pre>';
print_r($current_user);
echo '</pre>';
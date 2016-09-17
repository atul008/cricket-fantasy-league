<?php  require("includes/connection.php"); ?>
<?php require("includes/classes/team_owner.php"); ?> 

<?php
	// This file adds a player to the user based on his email and unique id of the player. 
	$email = $_REQUEST["email"]; 
	$id = $_REQUEST["player_id"];
	$owner_array = TeamOwner::getOwner($conn,$email);
	$owner = $owner_array[0];
	$owner->addPlayer($conn,$id);
	echo "Success !";
?>
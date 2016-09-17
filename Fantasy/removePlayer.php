<?php  require("includes/connection.php"); ?>
<?php require("includes/classes/team_owner.php"); ?> 

<?php 
	//This file removes a player from team using player id and requires email of user. 
	$email = $_REQUEST["email"];
	$id = $_REQUEST["player_id"];
	$owner_array = TeamOwner::getOwner($conn,$email);
	$owner = $owner_array[0];
	$owner->removePlayer($conn,$id);
	echo "Success !";
?>
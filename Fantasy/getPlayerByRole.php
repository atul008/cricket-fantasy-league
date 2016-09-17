<?php  require("includes/connection.php"); ?>
<?php require("includes/classes/team_owner.php"); ?> 

<?php 
	// This file can be used to get players by their roles.
	$email = $_REQUEST["email"]; 
	$role = $_REQUEST["role"];
	//echo $email;
	$owner_array = TeamOwner::getOwner($conn,$email);
	$owner = $owner_array[0];
	$sel = $owner->getTeamPlayers();
	//var_dump($sel);
	$availablePlayers = Player::getPlayerByRoles($conn,$role,$sel);
	//echo $role;
	var_dump($availablePlayers);
	echo "Success !";
?>
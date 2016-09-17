<?php  require("includes/connection.php"); ?>
<?php require("includes/classes/team_owner.php"); ?>
<?php 
		//This file saves the team format and team name.
		$team_name = $_POST["team_name"];
		$email = $_POST["email"];
		$tc = $_POST["team_composition"];
	//	var_dump($team_name);
		$query = "UPDATE Team_owners SET
				 team_name=:team_name , composition_id =:tc
				  WHERE email_id =:email";
		$stmt = $conn->prepare($query);
		$stmt->bindParam(':email',$email);
		$stmt->bindParam(':team_name',$team_name);
		$stmt->bindParam(':tc',$tc);
		$stmt->execute();
		echo "successfully saved !";
?>
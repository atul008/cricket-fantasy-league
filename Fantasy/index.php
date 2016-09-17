<?php  require("includes/connection.php"); ?>
<?php require_once("includes/classes/team_owner.php"); ?> 
<?php require_once("includes/classes/team_composition.php"); ?> 

<html>
	<head>
		<title>Fantasy League</title>
		<link rel="stylesheet" href="styles/styles.css">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		<script src="javascript/script.js"></script>
		
	</head>

	<body >

			<div id="header">
				<h1>WORLD CUP FANTASY</h1>
			</div>
	
			<div id ="user">
				<?php 
					$email = $_REQUEST["email"];
					$_POST["email"] = $email;
					$owner_array = TeamOwner::getOwner($conn,$email);
					$user = $owner_array[0];
					echo "<br><p> Welcome !".$user->getFullName()."<br>";
					echo "<br> Budget : ".$user->getBudget()." M</p> <br>";
				?>
			</div>
			<div id = "main">

				<div>
						<h2>Squad Formation</h2>

					<form method ="POST" action ="submit.php" id="form">
						<p>	Your Email : <input type="text" name="email" id = "your_email" value="<?php echo $user->getEmail(); ?>" readonly>
							Team Name : <input type="text" name="team_name" id = "team_name" value="<?php echo $user->getTeamName(); ?>" >	
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							Select team Composition :
						<select name = "team_composition" id ="comp" onchange="updateComposition(this)">
								<option value="0">select</option>
								<?php
								try{
			
									$comp_array = TeamComposition::getAllCompositions($conn);
									foreach ($comp_array as $comp) {
											if($comp->getId() == $user->getTeamCompId()){
												$str = '<option value="' .$comp->getId() . '" selected="selected">';
											}else{
												$str = "<option value='" .$comp->getId() . "'>";
											}
											$str = $str. "BAT:".$comp->getTotalBatsman().", ";
											$str = $str. "BOW:".$comp->getTotalBowlers().", ";
											$str = $str. "ALL:".$comp->getTotalAllrounders().", ";
											$str = $str. "WCK:".$comp->getTotalKeepers();
											$str = $str.'</option>';
											echo $str;
										
									}
		
								}catch(PDOException $ex){
									echo "ERROR : ".$ex->getMessage();
								}

								?>
						</select> </p>
						
						<p> <span id="answer"></span> </p>
					
					<div id="counts">
						<?php
								$id = $user->getTeamCompId();
								$comp = TeamComposition::getCompositionById($conn,$id);
								if($id == "0"){
									$content = "<h4> Please Select Squad Composition! </h4>";
								}else{
									$content = '<form> <h2>Selected Squad </h2><br>';

									$content = $content.'Total Players :  <input type="text" id="stpl" size="1" name="total" value=" '.$comp->getTotalPlayers().'" readonly>&nbsp;&nbsp;&nbsp;&nbsp;';
									$content = $content.'Total Batsmen :  <input type="text" id ="stba" size="1" name="bat" value=" '.$comp->getTotalBatsman().'" readonly>&nbsp;&nbsp;&nbsp;&nbsp;';
									$content = $content.'Total Bowlers : <input type="text" id = "stbo" size="1" name="bow" value=" '.$comp->getTotalBowlers().'" readonly>&nbsp;&nbsp;&nbsp;&nbsp;';
									$content = $content.'Total Allrounders : <input type="text" id="stal" size="1" name="all" value=" '.$comp->getTotalAllrounders().'" readonly>&nbsp;&nbsp;&nbsp;&nbsp;';
									$content = $content.'Total Keepers : <input type="text" id="stbk" size="1" name="wkt" value=" '.$comp->getTotalKeepers().'" readonly>&nbsp&nbsp<br>';		
									$content = $content.'</form>';
								}
								echo $content;	
						 ?>
					
					</div>	

					<input id = "submit" type="submit" value="submit">
					</form>

				</div>


				<div id="selected">
						<?php
								
							$content = '<form> <h2>Selected Squad </h2>';
							$content = $content.'<h3> Total Expenditure : '. $user->getExpenditure().'</h3><br>';
						
							$content = $content.'Batsmen :  <input type="text" id ="ttba" size="1" name="bat" value=" '.$user->getBaCount().'" readonly>&nbsp;&nbsp;&nbsp;&nbsp;';
							$content = $content.'Bowlers : <input type="text" id="ttbo" size="1" name="bow" value=" '.$user->getBoCount().'" readonly>&nbsp;&nbsp;&nbsp;&nbsp;';
							$content = $content.'Allrounders : <input type="text" id="ttal" size="1" name="all" value=" '.$user->getAlCount().'" readonly>&nbsp;&nbsp;&nbsp;&nbsp;';
							$content = $content.'Keepers : <input type="text" id="ttbk" size="1" name="wkt" value=" '.$user->getBkCount().'" readonly>&nbsp&nbsp<br>';		
							$content = $content.'</form>';
							echo $content;	
						 ?>
							
					<h2>Choose your team !</h2>
				
					<table id = "t02">
						<tr>

							<th>Name</th>
							<th>Country</th>
							<th>Price</th>
							<th>Role</th>
							<th>Remove</th>
						</tr>

						<?php
						try{

							$player_array = $user->getTeamPlayers();
							foreach($player_array as $player){
								$str = "<tr>";
								$str = $str ."<td>".$player->fullname()."</td>";
								$str = $str ."<td>".$player->country()."</td>";
								$str = $str ."<td>".$player->value()."</td>";
									switch ($player->role()) {
									case 'B_K':
										$role = "BAT/KEEPER";
										break;
									case 'B_A':
										$role = "BATSMAN";
										break;
									case 'B_O':
										$role = "BOWLER";
										break;
									case 'A_L':
										$role = "ALLROUNDER";
										break;
									default:
										$role = "UNKNOWN";
										break;
								}
								$str = $str ."<td>".$role."</td>";
								$str = $str."<td><a href='#footer' id=".$player->player_id()." onClick=".'"'."removePlayer('".$user->getEmail()."',this.id)".'"'.">Remove</a></td>";
								$str = $str."</tr>";
						//		var_dump($str);
								echo $str;
							}
						//	var_dump($player_array);
							}catch(PDOException $ex){
								echo "ERROR: ".$ex->getMessage(); 
							}
						?>

					</table> 
				</div>
				
				<div id="available">
					<h2>List of available players </h2>
					<table id = "t01">
						<tr>
							<th>Add</th>
							<th>Name</th>
							<th>Country</th>
							<th>Price</th>
							<th>Role</th>
						</tr>

						<?php
						try{

							$player_array = $user->getAvailablePlayers($conn);
							//var_dump($player_array);
							foreach($player_array as $player){
								$str = "<tr>";
								$str = $str."<td><a href='#' id=".$player->player_id()." onClick=".'"'."addPlayer('".$user->getEmail()."',this.id)".'"'.">Add</a></td>";
								$str = $str ."<td>".$player->fullname()."</td>";
								$str = $str ."<td>".$player->country()."</td>";
								$str = $str ."<td>".$player->value()."</td>";
								switch ($player->role()) {
									case 'B_K':
										$role = "BAT/KEEPER";
										break;
									case 'B_A':
										$role = "BATSMAN";
										break;
									case 'B_O':
										$role = "BOWLER";
										break;
									case 'A_L':
										$role = "ALLROUNDER";
										break;
									default:
										$role = "UNKNOWN";
										break;
								}
								$str = $str ."<td>".$role."</td>";
								$str = $str."</tr>";
								echo $str;
							}
						
							}catch(PDOException $ex){
								echo "ERROR: ".$ex->getMessage(); 
							}
						?>

					</table>
		
				</div>	<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
		
		</div>

			

		<div id="footer">
			<p>World Cup 2015</p>
		</div>
		<?php
			// Close database connection 
			$conn->close(); 
		?>

	</body>

</html>



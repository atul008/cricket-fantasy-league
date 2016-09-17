<?php  require("includes/connection.php"); ?>
<?php require("includes/classes/team_owner.php"); ?> 

<?php
//This file updates the selected portion of index.php page after addition or removal of palyer from team. 
try{
    $email = $_REQUEST["email"];
    $id = $_REQUEST["player_id"];
    //echo($email);
    $owner_array = TeamOwner::getOwner($conn,$email);
    $user = $owner_array[0];
    $user->removePlayer($conn,$id);
	
	//Get a new instance after updation of database
	$owner_array = TeamOwner::getOwner($conn,$email);
    $user = $owner_array[0];
    $player_array = $user->getTeamPlayers();
    
    $content = '<form> <h2>Selected Squad </h2>';
    $content = $content.'<h3> Total Expenditure : '. $user->getExpenditure().'</h3>';

    $content = $content.'Batsmen :  <input type="text" id ="ttba" size="1" name="bat" value=" '.$user->getBaCount().'" readonly>&nbsp;&nbsp;&nbsp;&nbsp;';
    $content = $content.'Bowlers : <input type="text" id="ttbo" size="1" name="bow" value=" '.$user->getBoCount().'" readonly>&nbsp;&nbsp;&nbsp;&nbsp;';
    $content = $content.'Allrounders : <input type="text" id="ttal" size="1" name="all" value=" '.$user->getAlCount().'" readonly>&nbsp;&nbsp;&nbsp;&nbsp;';
    $content = $content.'Keepers : <input type="text" id="ttbk" size="1" name="wkt" value=" '.$user->getBkCount().'" readonly>&nbsp&nbsp';      
    $content = $content.'</form>';

    $content = $content.'<h2>Choose your team !</h2>';
    $content = $content.'<table id = "t02"><tr><th>Name</th><th>Country</th><th>Price</th><th>Role</th><th>Remove</th></tr>';

	//var_dump($player_array);
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
		$content = $content.$str;
	}
	$content = $content.'</table>';
	echo $content;
	}catch(PDOException $ex){
		echo "ERROR: ".$ex->getMessage(); 
	}
?>


<?php  require("includes/connection.php"); ?>
<?php require("includes/classes/team_composition.php"); ?> 

<?php 
	if(isset($_POST["comp_id"])){
		$id = $_POST["comp_id"];
	}else{
		$id = $_REQUEST["id"]; 		
	}
	$comp = TeamComposition::getCompositionById($conn,$id);
//	var_dump($comp);
	if($id == "0"){
		$content = "<h4> Please Select Squad Composition! </h4>";
	}else{
		$content = '<form> <h2>Selected Squad </h2><br>';

			$content = $content.'Total Players :  <input type="text" size="1" name="total" value=" '.$comp->getTotalPlayers().'" readonly>&nbsp;&nbsp;&nbsp;&nbsp;';
			$content = $content.'Total Batsmen :  <input type="text" size="1" name="bat" value=" '.$comp->getTotalBatsman().'" readonly>&nbsp;&nbsp;&nbsp;&nbsp;';
			$content = $content.'Total Bowlers : <input type="text" size="1" name="bow" value=" '.$comp->getTotalBowlers().'" readonly>&nbsp;&nbsp;&nbsp;&nbsp;';
			$content = $content.'Total Allrounders : <input type="text" size="1" name="all" value=" '.$comp->getTotalAllrounders().'" readonly>&nbsp;&nbsp;&nbsp;&nbsp;';
			$content = $content.'Total Keepers : <input type="text" size="1" name="wkt" value=" '.$comp->getTotalKeepers().'" readonly>&nbsp&nbsp';		
			$content = $content.'</form><br>';
	}					
	echo $content;
?>

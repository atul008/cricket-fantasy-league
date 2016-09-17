<?php require_once("player.php"); ?> 
<?php
	//echo "hi";
/*	function comp_for_diff($obj1,$obj2){
		return ($obj1->player_id())-($obj2->player_id());
	}
*/
class TeamOwner{
	
	private  $owner_id;
	private  $email_id;
	private  $budget;
	private  $first_name;
	private  $last_name;
	private  $team_name;
	private  $team_comp_id;
	private  $player_id_string;
	private  $players;

	private  $expenditure;
	// current number of batsman keeper count
	private  $bkCount;
	// current number of batsman count
	private  $baCount;
	// current number of bowler count
	private  $boCount;
	//current number of allrounder count
	private  $alCount;

	function __construct($conn,$owner_id,$email,$budget,$fname,$lname,$tn,$tci,$player_ids){
		$this->owner_id = $owner_id;
		$this->email_id = $email;
		$this->budget = $budget;
		$this->first_name = $fname;
		$this->last_name = $lname;
		$this->team_name = $tn;
		$this->team_comp_id = $tci;
		
		$this->bkCount = 0;
		$this->baCount = 0;
		$this->boCount = 0 ;
		$this->alCount = 0;
		$this->expenditure = 0;

		$this->player_id_string = $player_ids;
		$this->players = array();
		$player_id_array = explode(' ',$player_ids);
		
		$player_id_array=array_filter($player_id_array);
		
		foreach ($player_id_array as $player_id) {
			
			$p = Player::getPlayerById($conn,$player_id);
			$this->expenditure =(float)$this->expenditure + (float)$p->value();
			$role = $p->role();
			
			switch ($role) {
				case 'B_K':
					$this->bkCount =(int)$this->bkCount + (int)1;
					break;

				case 'B_A':
					$this->baCount =(int)$this->baCount + (int)1;
					break;

				case 'B_O':
					$this->boCount =(int)$this->boCount + (int)1;
					break;

				case 'A_L':
					$this->alCount =(int)$this->alCount + (int)1;
					break;

				default:
					break;
			}

			$this->players[] = $p;
		}
	}


	public function getFullName(){
		return $this->first_name.' '.$this->last_name;
	}
	
	public function getId(){
		return $this->owner_id;
	}

	public function getEmail(){
		return $this->email_id;
	}

	public function getTeamName(){
		return $this->team_name;
	}
	public function getTeamCompId(){
		return $this->team_comp_id;
	}
	public function getBudget(){
		return $this->budget;
	}

	public function getTeamPlayers(){
		return $this->players;
	}
	
	public function getExpenditure(){
		return $this->expenditure;
	}

	public function getBkCount(){
		return $this->bkCount;
	}
	public function getBaCount(){
		return $this->baCount;
	}
	public function getBoCount(){
		return $this->boCount;
	}
	public function getAlCount(){
		return $this->alCount;
	}



    public function getAvailablePlayers($conn){
    	$allPlayers = Player::getAllPlayers($conn);
   		if(!empty($this->players)){
   			$arr = array($this->players);
   			$available_players = array_udiff($allPlayers,$this->players,'comp_for_diff');
   			$available_players = array_filter($available_players);
			return $available_players;
		}else{
			return $allPlayers;
		}
	}

	public function addPlayer($conn,$id){
		//post request
		$player_id_array = explode(' ',$this->player_id_string);
		array_push($player_id_array,$id);	 		
		$player_id_array=array_filter($player_id_array);
		$str = implode(' ',$player_id_array);
		$query = "UPDATE Team_owners SET players=:val WHERE owner_id =:owner_id";	
		$stmt = $conn->prepare($query);
		$stmt->bindParam(':val',$str);
		$stmt->bindParam(':owner_id',$this->owner_id);
		$stmt->execute();
		
	}

	public function removePlayer($conn,$id){
		//post request
		$player_id_array = explode(' ',$this->player_id_string);
		if(($key = array_search($id, $player_id_array)) !== false) {
 		   unset($player_id_array[$key]);
		}
		$player_id_array=array_filter($player_id_array);
		
		$str = implode(' ',$player_id_array);
		$query = "UPDATE Team_owners SET players=:val WHERE owner_id =:owner_id";	
		$stmt = $conn->prepare($query);
		$stmt->bindParam(':val',$str);
		$stmt->bindParam(':owner_id',$this->owner_id);
		$stmt->execute();

	}
	
	public static function getOwner($conn,$email){

		try{
				$query = "select * from Team_owners where email_id =:email";
				$stmt = $conn->prepare($query);
				$stmt->bindParam(':email',$email);
				$stmt->setFetchMode(PDO::FETCH_ASSOC);
				$stmt->execute();
				$result_set = $stmt->fetchAll();
				if(count($result_set) > 0){
					$owner_array = array();
					foreach ($result_set as $row) {
					$owner = new TeamOwner($conn,$row["owner_id"],$row["email_id"],$row["budget"],
											$row["first_name"],$row["last_name"],$row["team_name"],$row["composition_id"],$row["players"]);
					$owner_array[] = $owner;
					}
					return $owner_array;
				}else{
					return ;
				}
			}catch(PDOException $ex){
				return "ERROR : " .$ex->getMessage();
			}

	}


}

?>

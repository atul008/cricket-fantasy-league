<?php

function comp_for_diff($obj1,$obj2){
	//echo "hey";
	return ($obj1->player_id())-($obj2->player_id());
}

class Player{

	private   $player_id;
	private   $country_id;
	private   $team_id;
	private   $first_name;
    private   $last_name;
	private   $value;
	private   $height;
	private   $age;
	private   $role;

	function __construct($pid,$country,$tid,$fname,$lname,$val,$hgt,$dob,$role){
		$this->player_id = $pid;
		$this->country = $country;
		$this->team = $tid;
		$this->first_name = $fname;
		$this->last_name = $lname;
		$this->value = $val;
		$this->height = $hgt;
		$this->age = $dob;
		$this->role = $role;
	}

	public function fullname(){
		return $this->first_name. ' '. $this->last_name;
	}

	public function player_id(){
		return $this->player_id;
	}

	public function country(){
		return $this->country;
	}

	public function team_id(){
		return $this->team_id;
	}

	public function value(){
		return $this->value;
	}

	public function height(){
		return $this->height;
	}

	public function dob(){
		return $this->dob;
	}

	public function role(){
		return $this->role;
	}

    static public function getPlayerById($conn,$id){
    		try{
    			$query = "select * from Players inner join Country
						  on Players.country_id = Country.country_id
						  where player_id=:id";
						
				$stmt = $conn->prepare($query);
				$stmt->bindParam(':id',$id);
				$stmt->setFetchMode(PDO::FETCH_ASSOC);
				$stmt->execute();
				$result_set = $stmt->fetchAll();
				if(count($result_set) > 0){
				foreach ($result_set as $row) {
						$player = new Player($row["player_id"],$row["country_name"],$row["team_id"],$row["first_name"],$row["last_name"],$row["value"],$row["height"],$row["dob"],$row["role"]);
					return $player;
				}
				}else{
					return ;
				}
			}catch(PDOException $ex){
				return "ERROR : " .$ex->getMessage();
			}

	}


	static public function getAllPlayers($conn){
			try{
				$query = "select player_id from Players";
				$stmt = $conn->prepare($query);
				$stmt->setFetchMode(PDO::FETCH_ASSOC);
				$stmt->execute();
				$result_set = $stmt->fetchAll();
				$player_array = array();
				foreach ($result_set as $row) {
			//		$player = new Player($row["player_id"],$row["country_name"],$row["team_id"],$row["first_name"],$row["last_name"],$row["value"],$row["height"],$row["dob"]);
					$player = Player::getPlayerById($conn,$row["player_id"]);
					$player_array[] = $player;
				}
				return  $player_array;
					
			}catch(PDOException $ex){
				return "ERROR : " .$ex->getMessage();
			}

	}

		static public function getPlayerByRoles($conn,$role,$selected){
			try{

				$query = "select * from Players having role=:role";
				$stmt = $conn->prepare($query);
				$stmt->bindParam(':role',$role);
				//var_dump($query);
				$stmt->setFetchMode(PDO::FETCH_ASSOC);
				$stmt->execute();
				$result_set = $stmt->fetchAll();
				//var_dump($result_set);
				$player_array = array();
				foreach ($result_set as $row) {
					var_dump($row["player_id"]);
					$player = Player::getPlayerById($conn,$row["player_id"]);
					$player_array[] = $player;
				}
				$available_players = array_udiff($player_array,$selected,'comp_for_diff');
   		
				return  $available_players;
				
			}catch(PDOException $ex){
				return "ERROR : " .$ex->getMessage();
			}
	}


}
 

?>

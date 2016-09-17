<?php 
	
	class TeamComposition {
		private $composition_id;
		private $total_players;
		private $no_of_batsman;
		private $no_of_bowlers;
		private $no_of_allrounders;
		private $no_of_wkt_keepers;
		
		function __construct($cid,$tp,$bat,$bow,$all,$wkt){
			$this->composition_id = $cid;
			$this->total_players = $tp;
			$this->no_of_batsman = $bat;
			$this->no_of_bowlers = $bow;
			$this->no_of_allrounders = $all;
			$this->no_of_wkt_keepers = $wkt;
		}

		public function getId(){
			return $this->composition_id;
		}

		public function getTotalPlayers(){
			return $this->total_players;
		}

		public function getTotalBatsman(){
			return $this->no_of_batsman;
		}

		public function getTotalBowlers(){
			return $this->no_of_bowlers;
		}

		public function getTotalAllrounders(){
			return $this->no_of_allrounders;
		}
		
		public function getTotalKeepers(){
			return $this->no_of_wkt_keepers;
		}

		static public function getCompositionById($conn,$id){
			try{
			//	echo "hey";
				$query = "select * from Team_composition where composition_id =:id";
				$stmt = $conn->prepare($query);
				$stmt->bindParam(':id',$id);
				$stmt->setFetchMode(PDO::FETCH_ASSOC);
				$stmt->execute();
				$result_set = $stmt->fetchAll();
				foreach($result_set as $row) {
					$comp = new TeamComposition(
						$row["composition_id"],$row["total_players"],
						$row["no_of_batsman"],$row["no_of_bowlers"],
						$row["no_of_allrounders"],$row["no_of_wkt_keepers"]
						);

					//var_dump($comp);
					return $comp;
				}
					
			}catch(PDOException $ex){
				return "ERROR : " .$ex->getMessage();
			}
		}

		static public function getAllCompositions($conn){
			try{
	
				$query = "select composition_id from Team_composition";
				$stmt = $conn->prepare($query);
				$stmt->setFetchMode(PDO::FETCH_ASSOC);
				$stmt->execute();
				$result_set = $stmt->fetchAll();
				//var_dump($result_set);
				$comp_array = array();
				foreach($result_set as $row) {
					$comp = TeamComposition::getCompositionById($conn,$row["composition_id"]);
					$comp_array[] = $comp;
				}
				return  $comp_array;
					
			}catch(PDOException $ex){
				return "ERROR : " .$ex->getMessage();
			}

		}

	}
?>
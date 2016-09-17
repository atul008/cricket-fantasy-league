<?php  require("includes/connection.php"); ?>
<?php require("includes/classes/team_owner.php"); ?>
<?php require("includes/classes/team_composition.php"); ?>
<?php 
    //This file updates the available portion of index.php page after addition or removal of palyer from team.
    try{

        $email = $_REQUEST["email"];
        $id = $_REQUEST["player_id"];

        if(isset($_REQUEST["comp_id"])){
                $comp_id = $_REQUEST["comp_id"];
                $comp = TeamComposition::getCompositionById($conn,$comp_id);
                $ba = (int)$comp->getTotalBatsman();
                $bo = (int)$comp->getTotalBowlers();
                $bk = (int)$comp->getTotalKeepers();
                $al = (int)$comp->getTotalAllrounders();
                

                $owner_array = TeamOwner::getOwner($conn,$email);
                $user = $owner_array[0];
                $user->addPlayer($conn,$id);
                //get updated copy 
                $owner_array = TeamOwner::getOwner($conn,$email);
                $user = $owner_array[0];
             
                $cba = (int)$user->getBaCount();
                $cbo = (int)$user->getBoCount();
                $cbk = (int)$user->getBkCount();
                $cal = (int)$user->getAlCount();
          /*      var_dump($ba); var_dump($cba);
                echo "<br>";
                var_dump($bo); var_dump($cbo);
                echo "<br>";
                var_dump($bk); var_dump($cbk);
                echo "<br>";
                var_dump($al); var_dump($cal);
        */
                if($ba < $cba || $bo < $cbo || $bk < $cbk || $al < $cal){
                    $user->removePlayer($conn,$id);
                    echo "1";
                    return;
                }
                $owner_array = TeamOwner::getOwner($conn,$email);
                $user = $owner_array[0];
             
                $budget = (int)$user->getBudget();  
                $nexp =(int)$user->getExpenditure();
                if($nexp > $budget){
                    $user->removePlayer($conn,$id);
                    echo "1";
                    return;
                }

            }else{
                $owner_array = TeamOwner::getOwner($conn,$email);
                $user = $owner_array[0];
                $user->addPlayer($conn,$id);
             
                
              //  var_dump($user);

              // get new instance after updation of database.
                $owner_array = TeamOwner::getOwner($conn,$email);
                $user = $owner_array[0];
             
            }
  
        $player_array = $user->getAvailablePlayers($conn);
  
        $content = $content.'<h2>List of available players </h2><br><table id = "t01">';         
        $content = $content."<tr><th>Add</th><th>Name</th><th>Country</th><th>Price</th><th>Role</th></tr>";


        //var_dump($player_array);
        foreach($player_array as $player){
            $str = "<tr>";
            $str = $str."<td><a href='#footer' id=".$player->player_id()." onClick=".'"'."addPlayer('".$user->getEmail()."',this.id)".'"'.">Add</a></td>";
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
            $content =$content.$str;
        }
        $content = $content."</table>";
     echo $content;  
    }catch(PDOException $ex){
        echo "ERROR: ".$ex->getMessage(); 
    }

?>
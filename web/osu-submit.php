<?php
	
	include "../config.php";
	
	$connection = new mysqli("localhost", $mysql_username, $mysql_password, $mysql_database);
	
	//Write Error to File if connection wasn't successfull
	if($connection->connect_error){
		$file = fopen("error.txt", "w");
		fwrite($file, $connection->connect_error);
		fclose($file);
	}

	//Initialize Calculation for Total Score
	$sql_gettotal = sprintf('SELECT * FROM scores WHERE username="%s" AND ranked="1" AND pass="True"', explode(":", $_GET["score"])[1]);
	$query = $connection->query(($sql_gettotal));
	$scores = array();
	$totalscore = 0;
	//Get each Score User has submitted from Databasse
	if($query->num_rows > 0){
		while($row = $query->fetch_assoc()){
			$scores[] = sprintf("%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s",
						$row["scoreid"], $row["beatmaphash"], $row["username"],
						$row["score"], $row["maxcombo"], $row["hit300"],
						$row["hit100"], $row["hit50"], $row["hit50"], $row["hit0"],
						$row["hitGeki"], $row["hitKatu"],
						$row["perfect"], $row["mods"]
						);
			
		}
	}
	//Loop Over gathered data from Database to Collect Total Score before this Play is Submitted
	foreach($scores as $item){
		$scorerow = explode(",", $item);
		$totalscore += (int)$scorerow[3];
	}
	//Add Score of this Play
	$totalscore += (int)explode(":",$_GET["score"])[9];

	//Prepare Statement for getting Score ID
	$sql_getscoreid = sprintf("SELECT * FROM scores");
	$getscoreid = $connection->query(($sql_getscoreid));

	//Get Binary Score
	$score = explode(":",$_GET["score"]);

	//Prepare SQL For gathering information of if user has Played the submitted Beatmap
	$sql_getmultiples = sprintf('SELECT * FROM scores WHERE username="%s" AND beatmaphash="%s" ORDER BY score DESC', $score[1], $score[0]);
	$query_getmultiples = $connection->query(($sql_getmultiples));

	//Array to hold all that data
	$multipleresults = array();

	//Get all Scores on One Beatmap set by One User
	if($query_getmultiples->num_rows > 0){
		while($row = $query_getmultiples->fetch_assoc()){
			//Inserting all into the Array
			$multipleresults[] = sprintf("%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s",
						$row["scoreid"], $row["beatmaphash"], $row["username"],
						$row["score"], $row["maxcombo"], $row["hit300"],
						$row["hit100"], $row["hit50"], $row["hit50"], $row["hit0"],
						$row["hitGeki"], $row["hitKatu"],
						$row["perfect"], $row["mods"], $row["pass"]
						);
			
		}
	}
	/////Debug: Check for Score ID Duplicates
	echo "<br/> $getscoreid->num_rows<br>KURWA";

	//Check if User has been Banned
	$banned = false;

	$bannedsql = "SELECT * FROM players WHERE username='".$connection->real_escape_string($score[0])."'";
	$bannedresults = $connection->query($bannedsql);

	if($bannedresults->num_rows > 0){
		while($row = $bannedresults->fetch_assoc()){
			if($row["banned"] === "true") $banned = true;
		}
	}

	$ranked = "0";

	$rankedsql = "SELECT * FROM mapstatus WHERE md5='".$score[0]."'";
	$rankedresult = $connection->query($rankedsql);

	if($rankedresult->num_rows > 0){
		while($row = $rankedresult->fetch_assoc()){
			$ranked = $row["status"];
		}
	}

	//If Score is Higher than old Run and User issnt Banned and Map Is ranked

	echo "<br>ZZZZZ ".(int)$score[9]."<br>";

	if((int)$score[9] > explode(",",$multipleresults[0])[3] && !$banned){
		//If Submitted SQL
		$forinsert = $connection->query(
			(
				sprintf(
					'SELECT * FROM scores WHERE username="%s" AND beatmaphash="%s"', 
						$score[1], $score[0]
					)
				)
			);
		echo "<br>FUCKING SSHIT<br>";
		//Check If Player Has Submitted a play on this Map
		if($forinsert->num_rows === 0){
			//If not, Submit a New Play
			//Insertion SQL
			$sql_insert = sprintf('INSERT INTO scores (scoreid, beatmaphash, username, score, maxcombo, hit300, hit100, hit50, hit0, hitGeki, hitKatu, perfect, mods, pass, ranked) VALUES (%s, "%s", "%s", %s, %s, %s, %s, %s, %s, %s, %s, "%s", %s, "%s", "%s")',
				$getscoreid->num_rows+1, $score[0], $score[1], $score[9], $score[10], $score[3], $score[4], $score[5], $score[8], $score[6], $score[7], $score[11], $score[13], $score[14], $ranked
			);
			echo "<br>".$sql_insert."<br>";
			//Check if Insertion was Successfull
			if($connection->query(($sql_insert)) === TRUE){
				echo "<br/>good update";
			} else {
				echo "<br/>Error: " . $sql_insert . "<br>" . $connection->error;
			}
		}else {
			//If that is the case, update the Old Score

			//Prepare SQL For Updating the Old Score
			$sql_update = sprintf('UPDATE scores SET score=%s WHERE username="%s" AND beatmaphash="%s"',
				$score[9], $score[1], $score[0]
			);
			if($connection->query(($sql_update)) === TRUE){
				echo "<br/>updated play";
			}
		}
		if($ranked == "1"){
			$file = fopen("what the fuck.txt", "w");
			fwrite($file, json_encode($_GET));
			fclose($file);
			Recalc();
		}
		//Save Replay (if sent)

		move_uploaded_file($_FILES['score']['tmp_name'], __DIR__ . "/replays/" . $getscoreid->num_rows . ".osr");

	} else {
		$file = fopen("working.txt", "w");
		fwrite($file, "YES");
		fclose($file);
	}
	$connection->close();

	function Recalc(){
		include "../config.php";
		$connection = new mysqli("localhost", $mysql_username, $mysql_password, $mysql_database);
	
	
		$all_users = "SELECT * FROM players";
		$all_users_query = $connection->query($all_users);
	
		if($all_users_query->num_rows > 0){
			while($user = $all_users_query->fetch_assoc()){
			   
				$totalscore = 0;
	
				$scores_sql = sprintf("SELECT * FROM scores WHERE username='%s' AND pass='True' AND ranked='1'", $user["playername"]);
				$scores = $connection->query($scores_sql);
	
				if($scores->num_rows > 0){
					while($row = $scores->fetch_assoc()){
						$totalscore += $row["score"];
					}
				}
	
				$sql_updatescore = sprintf('UPDATE players SET score=%s WHERE playername="%s"', $totalscore, $user["playername"]);
	
				if($connection->query(($sql_updatescore)) === TRUE){
					echo "<br/>updated score for ".$user["playername"];
				} else {
					echo "Error: " . $sql_insert . "<br>" . $connection->error;
				}
	
			}
		}
	
	}
	
?>
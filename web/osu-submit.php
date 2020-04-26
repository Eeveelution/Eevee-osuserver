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
	$sql_gettotal = sprintf('SELECT * FROM scores WHERE username="%s"', explode(":", $_GET["score"])[1]);
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
	echo "<br/> $getscoreid->num_rows";

	if((int)$score[9] > explode(",",$multipleresults[0])[3]){
		//If Submitted SQL
		$forinsert = $connection->query(
			(
				sprintf(
					'SELECT * FROM scores WHERE username="%s" AND beatmaphash="%s"', 
						$score[1], $score[0]
					)
				)
			);
		
		//Check If Player Has Submitted a play on this Map
		if($forinsert->num_rows === 0){
			//If not, Submit a New Play
			//Insertion SQL
			$sql_insert = sprintf('INSERT INTO scores (scoreid, beatmaphash, username, score, maxcombo, hit300, hit100, hit50, hit0, hitGeki, hitKatu, perfect, mods, pass) VALUES (%s, "%s", "%s", %s, %s, %s, %s, %s, %s, %s, %s, "%s", %s, "%s")',
				$getscoreid->num_rows, $score[0], $score[1], $score[9], $score[10], $score[3], $score[4], $score[5], $score[8], $score[6], $score[7], $score[11], $score[13], $score[14]
			);
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

		//Prepare SQL For Updating Ranked Score of a Player
		$sql_updatescore = sprintf('UPDATE players SET score=%s WHERE playername="%s"', $totalscore, $score[1]);

		if($connection->query(($sql_updatescore)) === TRUE){
			echo "<br/>updated score";
		} else {
			echo "Error: " . $sql_insert . "<br>" . $connection->error;
		}
		//Save Replay (if sent)

		move_uploaded_file($_FILES['score']['tmp_name'], __DIR__ . "/replays/" . $getscoreid->num_rows . ".osr");

	} else {
		$file = fopen("working.txt", "w");
		fwrite($file, "YES");
		fclose($file);
	}
	$connection->close();
	
?>
<?php
	
	include "../config.php";
	
	$connection = new mysqli("localhost", $mysql_username, $mysql_password, $mysql_database);
	
	if($connection->connect_error){
		$file = fopen("error.txt", "w");
		fwrite($file, $connection->connect_error);
		fclose($file);
	}


	$sql_gettotal = sprintf("SELECT * FROM scores WHERE username='%s'", explode(":", $_GET["score"])[1]);

	$query = $connection->query($sql_gettotal);

	$scores = array();

	$totalscore = 0;

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

	foreach($scores as $item){

		echo json_encode($item);

		$scorerow = explode(",", $item);
		$totalscore += (int)$scorerow[3];
	}

	$totalscore += (int)explode(":",$_GET["score"])[9];

	$sql_getscoreid = sprintf("SELECT * FROM scores");
	$getscoreid = $connection->query($sql_getscoreid);

	$score = explode(":",$_GET["score"]);

	$sql_insert = sprintf("INSERT INTO scores (scoreid, beatmaphash, username, score, maxcombo, hit300, hit100, hit50, hit0, hitGeki, hitKatu, perfect, mods) VALUES (%s, '%s', '%s', %s, %s, %s, %s, %s, %s, %s, %s, '%s', %s)",
		$getscoreid->num_rows, $score[0], $score[1], $score[9], $score[10], $score[3], $score[4], $score[5], $score[8], $score[6], $score[7], $score[11], $score[13]
	);

	if($connection->query($sql_insert) === TRUE){
		echo "good";
	} else {
		echo "Error: " . $sql_insert . "<br>" . $connection->error;
	}

	$sql_updatescore = sprintf("UPDATE users SET score=%s WHERE username='%s'", $totalscore, $score[1]);

	if($connection->query($sql_updatescore) === TRUE){
		echo "updated score";
	} else {
		echo "Error: " . $sql_insert . "<br>" . $connection->error;
	}
?>
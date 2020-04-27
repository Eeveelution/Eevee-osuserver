<?php
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
?>
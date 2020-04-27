<?php

    include "config.php";

    if(isset($_POST["reg_username"]) !== TRUE){
        die("no");
    } else {
        $wished_username = $_POST["reg_username"];
        $wished_password = $_POST["reg_password"];

        $connection = new mysqli("localhost", $mysql_username, $mysql_password, $mysql_database);

        $sql_prepare = "SELECT * FROM players WHERE username='" . $connection->real_escape_string($wished_username);

        $check_usedname = $connection->query($sql_prepare);
        
        if($check_usedname->num_rows == 0){
            $userid = $connection->query("SELECT * FROM players")->num_rows + 10;
            $sql_insert = "INSERT INTO players (id, playername, md5pass, score, banned) VALUES (". $userid . ",'" . $connection->real_escape_string($wished_username) . "','" . hash("md5", $wished_password) . "',0, 'false')";

            if ($connection->query($sql_insert) === TRUE) {
                echo "Successfully Registered! You can now login!";
            } else {
                echo "Error: <br/> SQL:: <br/>" . $sql_insert . "<br/> Error: <br/>" . $connection->error;
            }
        }else {
            echo "username in use";
        }
    }

    $connection->close();
?>
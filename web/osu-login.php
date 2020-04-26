<?php
    include "../config.php";

    //Create MySQL Database connection
    $connection = new mysqli("localhost", $mysql_username, $mysql_password, $mysql_database);

    //Write Error to File if one should arise
    if($connection->connect_error){
        $file = fopen("error.txt", "w");
        fwrite($file, $connection->connect_error);
        fclose($file);
        echo "0";
    }

    //Search for Player and Password in Database
    $sql = sprintf('SELECT * FROM players WHERE playername="%s" AND md5pass="%s"',$_GET['username'], $_GET['password']);
    $query = $connection->query($sql);

    //If Query fails, Display Error
    if (!$query) {
        trigger_error('Invalid query: ' . $connection->error);
    }

    

    //If player Found Return 1 if not Return 0
    if($query->num_rows > 0){
        echo "1";
    } else {
        echo "0";
    }

    //Close MySQL Connection
    $connection->close();
    
?>
<?php
    include "../config.php";

    $connection = new mysqli("localhost", $mysql_username, $mysql_password, $mysql_database);

    if($connection->connect_error){
        $file = fopen("error.txt", "w");
        fwrite($file, $connection->connect_error);
        fclose($file);
        echo "0";
    }

    $sql = sprintf("SELECT * FROM players WHERE playername='%s' AND md5pass='%s'",$_GET['username'], $_GET['password']);
    $query = $connection->query($sql);

    if (!$query) {
        trigger_error('Invalid query: ' . $connection->error);
    }

    if($query->num_rows > 0){
        echo "1";
    } else {
        echo "0";
    }

    $connection->close();
    
?>
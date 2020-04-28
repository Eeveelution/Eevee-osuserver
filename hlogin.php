<?php
    session_start();
    include "config.php";
    ;

    $connection = new mysqli("localhost", $mysql_username, $mysql_password, $mysql_database);


    $username = $connection->real_escape_string($_POST["username"]);
    $password = hash("md5",$_POST["password"]);

    $sql = sprintf("SELECT * FROM players WHERE playername='%s' AND md5pass='%s'", $username, $password);
    $query = $connection->query($sql);

    if($query->num_rows > 0){
        $_SESSION["username"] = $username;
        $_SESSION["password"] = $password;
        echo "Logged in!!<br><a href='../index.php'>Back to Main Page<a>";
    }
?>
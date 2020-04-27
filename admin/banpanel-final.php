<?php
    session_start();
    include "../config.php";
    ;
    
    $connection = new mysqli("localhost", $mysql_username, $mysql_password, $mysql_database);
    
    $checkpassword = sprintf("SELECT * FROM players WHERE playername='%s' AND md5pass='%s'", $_SESSION["username_s"], $_SESSION["password_s"]);

    $passresponse = $connection->query($checkpassword);
    if($passresponse->num_rows !== 1){
        
        echo "wrong password <br>";
    }

    $check_privledge = sprintf("SELECT * FROM staff WHERE username='%s'", $_SESSION["username_s"]);
    $response = $connection->query($check_privledge);

    if($response->num_rows > 0){
        while($row = $response->fetch_assoc()){
            if($row["privledge"] === "all" || $row["privledge"] === "gmt"){
                all_privledges();
            } else if($row["privledge"] == "bat"){
                bat_privledges();
            } else if($row["privledge"] == "com"){
                com_privledges();
            }
        }
    }

    function all_privledges(){
        com_privledges();
    }
    function bat_privledges(){
        echo "As a member of the Beatmap Appreciation Team you cannot ban Players";
    }
    function com_privledges(){
        include "../config.php";
        $_connection = new mysqli("localhost", $mysql_username, $mysql_password, $mysql_database);


        $name = $_POST["banname"];
        $reason = $_POST["reason"];

        $sql = "UPDATE players SET banned='true', reason='$reason' WHERE playername='".$name."'";

        if($_connection->query($sql) === TRUE){
            echo "ban hammer hit successfully";
        }

    }


?>
<?php

    include "../config.php";
    ;
    
    $connection = new mysqli("localhost", $mysql_username, $mysql_password, $mysql_database);
    
    $checkpassword = sprintf("SELECT * FROM players WHERE playername='%s' AND md5pass='%s'", $_GET["username"], $_GET["pass"]);

    $passresponse = $connection->query($checkpassword);
    if($passresponse->num_rows !== 1){
        echo $checkpassword;
        echo "wrong password <br>".$_GET["pass"];
    }

    $check_privledge = sprintf("SELECT * FROM staff WHERE username='%s'", $_GET["username"]);
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
        echo<<<END
        <h1>Welcome to the Ranking Panel</h1>
END;
    }


?>
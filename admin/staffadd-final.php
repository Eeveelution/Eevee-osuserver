<?php
    session_start();
    include "../config.php";
    
    
    $connection = new mysqli("localhost", $mysql_username, $mysql_password, $mysql_database);
    
    $checkpassword = sprintf("SELECT * FROM players WHERE playername='%s' AND md5pass='%s'", $_POST["username"], hash("md5",$_POST["password"]));

    $passresponse = $connection->query($checkpassword);
    if($passresponse->num_rows !== 1){
        
        echo "wrong password <br>".$_POST["password"];
    }

    $check_privledge = sprintf("SELECT * FROM staff WHERE username='%s'", $_POST["username"]);
    $response = $connection->query($check_privledge);

    if($response->num_rows > 0){
        while($row = $response->fetch_assoc()){
            if($row["privledge"] === "all"|| $row["privledge"] === "gmt"){
                all_privledges();
            } else if($row["privledge"] == "bat"){
                bat_privledges();
            } else if($row["privledge"] == "com"){
                com_privledges();
            }
        }
    }

    $connection->close();

    function all_privledges(){
        include "../config.php";

        $_connection = new mysqli("localhost", $mysql_username, $mysql_password, $mysql_database);
        if($_connection->connect_error){
            echo "<br>fucked<br>";
        }
        echo $_POST["user"] . " is now ";
        if($_POST["staff"] === "bat") echo "in the Beatmap Appreciation Team";
        else if($_POST["staff"] === "com") echo "in the Community Management Team";
        else if($_POST["staff"] === "gmt") echo "in the Global Moderation Team";
        else if($_POST["staff"] === "nu" ) echo "back to being a Normal Player";
        
        $userid = 'SELECT * FROM players WHERE playername="'. $_connection->real_escape_string($_POST["user"]).'"';

        
        $userid_r = $_connection->query($userid);

        $userid_i = 0;

        if($userid_r->num_rows > 0){
            while($row = $userid_r->fetch_assoc()){
                $userid_i = $row["id"];
            }
        }


        if($_POST["staff"] !== "nu"){
            
            $sql_addstaff = "INSERT INTO staff (userid, username, privledge) VALUES (".$userid_i.",'".$_connection->real_escape_string($_POST["user"])."','".$_POST["staff"]."')";
            
            
            if( $_connection->query($sql_addstaff) === TRUE){
                echo "<br>success";
            } else {
                "fucked";
            }
        }else {
            $sql_remove = 'DELETE FROM staff WHERE username="'. $_connection->real_escape_string($_POST["user"]).'"';
            
            if( $_connection->query($sql_remove) === TRUE){
                echo "<br>success";
            } else {
                "fucked";
            }
        }
    }
    function bat_privledges(){
        echo "as a Member of the Beatmap Appreciation Team you cannot Add Staff Members,";

    }
    function com_privledges(){
        echo "as a Community Manager you cannot Add Staff Members,";

    }


?>
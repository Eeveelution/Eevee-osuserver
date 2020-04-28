<?php
    session_start();
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
        $_SESSION["username_s"] = $_GET["username"];
        $_SESSION["password_s"] = $_GET["pass"];
        echo<<<END

        <a href="panel.php">Back to Main Panel</a><br><br>

        <h1>Welcome to the Ban Panel</h1>

        <form action="banpanel-final.php" method="post">
            <p>Username:</p>
            <input type="text" name="banname"/>
            <p>Reason of Ban:</p>
            <textarea name="reason" rows="16" cols="48">
Hello, <username>!
Unfortnatly we have recently caught you <action>...
So you left us with no choise but to Give you a
restriction that will last for <time>.









Kind Regards. osu!2007 Support
            </textarea><br><br>
            <input type="submit" value="Ban Player"/>
        </form>
END;
    }


?>
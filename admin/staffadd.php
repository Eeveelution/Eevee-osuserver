<?php
    session_start();
    include "../config.php";
    ;
    
    $connection = new mysqli("localhost", $mysql_username, $mysql_password, $mysql_database);
    
    $checkpassword = sprintf("SELECT * FROM players WHERE playername='%s' AND md5pass='%s'", $_SESSION["username"], $_SESSION["password"]);

    $passresponse = $connection->query($checkpassword);
    if($passresponse->num_rows !== 1){
        
        echo "wrong password <br>".$_SESSION["password"];
    }

    $check_privledge = sprintf("SELECT * FROM staff WHERE username='%s'", $_SESSION["username"]);
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

    function all_privledges(){
    echo<<<END
        <a href="panel.php">Back to Main Panel</a><br><br>

        <h2>Welcome to the Staff Addition Screen</h2>
        <form action="staffadd-final.php" method="post">
        <p>Username of Player</p>
        <input type="text" name="user"/>
            
        <input type="radio" id="bat" name="staff" value="bat"/>
        <label for="bat">Beatmap Appreciation Team</label>

        <input type="radio" id="com" name="staff" value="com"/>
        <label for="bat">Community Management Team</label>

        <input type="radio" id="gmt" name="staff" value="gmt"/>
        <label for="bat">Global Moderation Team</label>

        <input type="radio" id="nu" name="staff" value="nu"/>
        <label for="bat">Demote to Normal User</label>

        <br><br>

        <p>Own Username</p>
        <input type="text" name="username"/> 

        <p>Own Password</p>
        <input type="password" name="password"/>

        <input type="submit"/>
        </form>

END;
    }
    function bat_privledges(){
        echo "as a Member of the Beatmap Appreciation Team you cannot Add Staff Members,";

    }
    function com_privledges(){
        echo "as a Community Manager you cannot Add Staff Members,";

    }


?>
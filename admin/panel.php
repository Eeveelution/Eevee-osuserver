<?php
    session_start();
    include "../config.php";
    ;
    
    $connection = new mysqli("localhost", $mysql_username, $mysql_password, $mysql_database);
    
    $checkpassword = sprintf("SELECT * FROM players WHERE playername='%s' AND md5pass='%s'", $_SESSION["username"], $_SESSION["password"]);

    $passresponse = $connection->query($checkpassword);
    if($passresponse->num_rows === 0){
        echo "wrong password";
    }

    $check_privledge = sprintf("SELECT * FROM staff WHERE username='%s'", $_SESSION["username"]);
    $response = $connection->query($check_privledge);

    if($response->num_rows > 0){
        while($row = $response->fetch_assoc()){
            if($row["privledge"] === "all"){
                all_privledges();
            } else if($row["privledge"] == "bat"){
                bat_privledges();
            } else if($row["privledge"] == "com"){
                com_privledges();
            }
        }
    }else {
        echo "no access, get away now";
    }
    function all_privledges(){
        echo<<<END
        osu!2007 Server | 
        <a href="../index.php">Home</a> |
        <a href="../leaderboards.php">Rankings</a> |
        <a href="../login.html">Login</a> |
        <a href="../register.html">Register</a> |
        <a href="../admin.html">Admin Panel</a> | <br><br>
END;
        echo "Welcome to this barebones admin panel <br/><br/> You have all Possible Privledges, you can: <br/><br/>";
        echo "Rank/Unrank Beatmaps, Ban Users, Add Staff <br/><br/><br/>";
        echo "<a href='rankingpanel.php'>Rank Beatmaps</a><br/>";
        echo "<a href='banpanel.php'>Ban Users</a><br/>";
        echo "<a href='staffadd.php'>Add Staff</a><br/>";
        echo "<br><a href='recalc.php'>Recalculate Scores for All Users</a><br/>";
    }
    function bat_privledges(){
        echo "Welcome to this barebones admin panel <br/><br/> You have BAT Privledges, you can: <br/><br/>";
        echo "Rank/Unrank Beatmaps<br/><br/><br/>";
        echo "<a href='rankingpanel.php'>Rank Beatmaps</a><br/>";

    }
    function com_privledges(){
        echo "Welcome to this barebones admin panel <br/><br/> You have COM Privledges, you can: <br/><br/>";
        echo "Ban Users<br/><br/><br/>";
        echo "<a href='banpanel.php'>Ban Users</a><br/>";

    }
?>
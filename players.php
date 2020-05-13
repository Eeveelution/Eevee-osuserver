<html>

<head>
    <style>
        h1 {
            margin: 0;
        }
        h2 {
            margin: 0;
        }
    </style>
</head>

<body>


<?php
    session_start();
    include "config.php";
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    $connection = new mysqli("localhost", $mysql_username, $mysql_password, $mysql_database);

    $sql_getuserdata = sprintf("SELECT * FROM players WHERE playername='%s'", $_GET["username"]);
    $getuserdata = $connection->query($sql_getuserdata);
    echo<<<END
    osu!2007 Server | 
    <a href="index.php">Home</a> |
    <a href="leaderboards.php">Rankings</a> |
    <a href="login.html">Login</a> |
    <a href="register.html">Register</a> |
    

END;

    include "config.php";
    $connection = new mysqli("localhost", $mysql_username, $mysql_password, $mysql_database);

    if(isset($_SESSION["username"])){
        $username = $connection->real_escape_string($_SESSION["username"]);
        $password = $_SESSION["password"];
    

        $sql = sprintf("SELECT * FROM players WHERE playername='%s' AND md5pass='%s'", $username, $password);
        $check_staff = "SELECT * FROM staff WHERE username='".$username."'";
        $query = $connection->query($sql);
        $query_staff = $connection->query($check_staff);

        if($query_staff->num_rows>0){
            echo '<a href="admin.html">Admin Panel</a> | ';
        }
    
        if($query->num_rows > 0){
        
            echo "<a href='players.php?username=" . $username . "'>". $username . "</a> | ";
            echo "<a href='logout.php'>Log out</a> |";
        }
    }
    if($getuserdata->num_rows > 0){
        
        while($row = $getuserdata->fetch_assoc()){
            echo "<br>";
            echo "<br><h1>".$row["playername"]."</h1>";
            echo "<br></h1>Score:".$row["score"];

            $sql_getrank = "SELECT * FROM players WHERE banned='false'";
            $getrank_query = $connection->query($sql_getrank);
            
            $rank = 1;

            if($getrank_query->num_rows > 0){
                while($row = $getrank_query->fetch_assoc()){
                    if($row["playername"] == $_GET["username"]){
                        echo "<br>Score Rank: ".$rank;

                    }
                    $rank++;
                }
            }

            echo "<br><br><br><h2>Top 5 Scores:</h2><br><br><br>";

            $sql_getbestscores = sprintf("SELECT * FROM scores WHERE username='%s' ORDER BY score DESC LIMIT 5", $_GET["username"]);
            $query_scores = $connection->query($sql_getbestscores);

            if($query_scores->num_rows > 0){
                while($row = $query_scores->fetch_assoc()){
                    $sql_beatmapheader = sprintf("SELECT * FROM mapstatus WHERE md5='%s'", $row["beatmaphash"]);
                    $result = $connection->query($sql_beatmapheader);

                    if($result->num_rows > 0){
                        while($header = $result->fetch_assoc()){
                            echo "<a href='beatmaps/scores.php?md5=".$row["beatmaphash"]."'>";
                            echo "<h2>".$header["data"]."</h2>";
                            echo "</a>";
                            if($row["mods"] == "1") echo "+NF/EZ";
                            else if($row["mods"] == "2") echo "+NFEZ";
                            echo "<p>Score: ".$row["score"]."</p><br>";
                        }
                    }
                }
            }
            echo sprintf("<a href='scoredump.php?username=%s'>Get Score Dump</a>", '"'.$_GET["username"].'"');
        }
    }

    
?>
</body>

</html>
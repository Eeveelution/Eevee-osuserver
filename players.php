<html>

<head>

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
            
            echo "<br><h1>".$row["playername"]."</h1>";
            echo "<br></h1>Score:".$row["score"];

            echo "<br><br><h2>Top Scores:</h2><br>";

            $sql_getbestscores = sprintf("SELECT * FROM scores WHERE username='%s' ORDER BY score DESC LIMIT 50", $_GET["username"]);
        }
    }

    
?>
</body>

</html>
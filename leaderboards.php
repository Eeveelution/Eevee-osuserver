<html>

<head>

</head>

<body>

        osu!2007 Server | 
        <a href="index.php">Home</a> |
        <a href="leaderboards.php">Rankings</a> |
        <a href="login.html">Login</a> |
        <a href="register.html">Register</a> |
        <?php
        
        
        include "config.php";
        $connection = new mysqli("localhost", $mysql_username, $mysql_password, $mysql_database);
        session_start();
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
    
?>

        <br><br>

<?php
    include "config.php";

    $connection = new mysqli("localhost", $mysql_username, $mysql_password, $mysql_database);

    $sql_getrankings = "SELECT * FROM players WHERE banned='false' ORDER BY score DESC";
    $query = $connection->query($sql_getrankings);

    $index = 1;
    echo "Rank | Username | Ranked Score <br/><br/>";
    if($query->num_rows > 0){
        while($row = $query->fetch_assoc()){
            echo $index . " | " . "<a href='players.php?username=" . $row["playername"] . "'>". $row["playername"] . "</a> | " . $row["score"] . "<br/>";
            $index++;
        }
    }
    $connection->close();
?>

</body>

</html>
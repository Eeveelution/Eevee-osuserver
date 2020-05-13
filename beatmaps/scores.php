
<head>

    <style>
        h1 {
            margin-bottom: -30px;
            margin-top: 0px;
        }
        h2 {
            margin: -20px;
        }
    </style>
</head>




        
<?php
        session_start();
        include "../config.php";
        $connection = new mysqli("localhost", $mysql_username, $mysql_password, $mysql_database);

        $sql_getuserdata = sprintf("SELECT * FROM players WHERE playername='%s'", $_SESSION["username"]);
        $getuserdata = $connection->query($sql_getuserdata);
        echo<<<END
        osu!2007 Server | 
        <a href="index.php">Home</a> |
        <a href="leaderboards.php">Rankings</a> |
        <a href="login.html">Login</a> |
        <a href="register.html">Register</a> |
        
    
    END;
    
        
        $connection = new mysqli("localhost", $mysql_username, $mysql_password, $mysql_database);
    
        

        if(isset($_SESSION["username"])){
            $username = $connection->real_escape_string($_SESSION["username"]);
            $password = $_SESSION["password"];
        
    
            $sql = sprintf("SELECT * FROM players WHERE playername='%s' AND md5pass='%s'", $username, $password);
            $check_staff = "SELECT * FROM staff WHERE username='".$username."'";
            $query = $connection->query($sql);
            $query_staff = $connection->query($check_staff);

            if($query_staff->num_rows>0){
                echo '<a href="../admin/panel.php">Admin Panel</a> | ';
            }
        
            if($query->num_rows > 0){
            
                echo "<a href='../players.php?username=" . $username . "'>". $username . "</a> | ";
                echo "<a href='../logout.php'>Log out</a> |";
            }
        }
    
?>

<?php



    
    include "../config.php";
        
    $connection = new mysqli("localhost", $mysql_username, $mysql_password, $mysql_database);

    $query_map = "SELECT * FROM mapstatus WHERE md5='".$_GET["md5"]."'";
    $mapquery = $connection->query($query_map);

    $sql_getscores = sprintf("SELECT * FROM scores WHERE beatmaphash='%s' AND pass='True' ORDER BY score DESC LIMIT 50;",
                         $_GET["md5"]
                     );
    $query_getscores = $connection->query($sql_getscores);

    if($mapquery->num_rows > 0){
        while($row = $mapquery->fetch_assoc()){
            echo "<center><h1>".$row["data"]."</center></h1><br><br><br>";
            echo "<center><h3>Ranked By</center></h3><br>";
            echo "<center><h2>".$row["rankedby"]."</center></h2><br><br><br>";

            echo<<<END
            <center>
                <table style="width:60%">
                    <tr>
                        <th>Rank</th>
                        <th>Username</th>
                        <th>Score</th>
                        <th>Accuracy</th>
                        <th>Max Combo</th>
                    </tr>
END;
            
            if($query_getscores->num_rows > 0){
                $rank = 1;
                while($row = $query_getscores->fetch_assoc()){
                    $accuracy_calc = GetAccuracy(
                        $row["hit300"], $row["hit100"], $row["hit50"], $row["hit0"],
                        $row["hitGeki"], $row["hitKatu"]
                    );
                    
                    if($rank == 1) echo "<i>";
                    echo "<tr>";
                        echo "<th>".$rank."</th>";
                        echo "<th>".$row['username']."</th>";
                        echo "<th>".$row['score']."</th>";
                        echo "<th>".$accuracy_calc."%</th>";
                        echo "<th>".$row['maxcombo']."</th>";
                        
                    echo "</tr>";
                    if($rank == 1) echo "</i>";

                    $rank++;
                }
            }

            echo<<<END


                </table>
            </center>

END;
        }
    }else {
        echo "Invalid Beatmap..";
    }

    function GetAccuracy($hit300, $hit100, $hit50, $hit0, $hitGeki, $hitKatu){
        $totalhits = $hit300 + $hit100 + $hit50 + $hit0 + $hitGeki + $hitKatu;

        $scorehits = ($hit300 * 300) + ($hit100 * 100) + ($hit50 * 50) + ($hit0 * 0) + ($hitGeki * 300) + ($hitKatu * 100);
        $fullhits = $totalhits * 300;

        $acc = $scorehits / $fullhits;

        return round($acc * 100,2);
        
    }
    
?>
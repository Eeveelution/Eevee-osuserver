<html>

<head>

</head>

<body>
<h1>

<?php
    session_start();
    include "config.php";
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    $connection = new mysqli("localhost", $mysql_username, $mysql_password, $mysql_database);

    $sql_getuserdata = sprintf("SELECT * FROM players WHERE playername='%s'", $_GET["username"]);
    $getuserdata = $connection->query($sql_getuserdata);
    
    if($getuserdata->num_rows > 0){
        
        while($row = $getuserdata->fetch_assoc()){
            
            echo $row["playername"];
            echo "<br></h1>Score:".$row["score"];

            echo "<br><br><h2>Top Scores:</h2><br>";

            $sql_getbestscores = sprintf("SELECT * FROM scores WHERE username='%s' ORDER BY score DESC LIMIT 50", $_GET["username"]);
        }
    }

    
?>
</body>

</html>
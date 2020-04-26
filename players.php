<html>

<head>

</head>

<body>
<center> <h1>
<?php
    include "config.php";
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    $connection = new mysqli("localhost", $mysql_username, $mysql_password, $mysql_database);

    $sql_getuserdata = sprintf("SELECT * FROM players WHERE playername='%s'", $_GET["username"]);
    $getuserdata = $connection->query($sql_getuserdata);
    
    if($getuserdata->num_rows > 0){
        
        while($row = $getuserdata->fetch_assoc()){
            
            echo $row["playername"];
            echo "<h5>Score</h5>";
            echo "</h1><h2>". $row["score"];
        }
    }

    
?>
 </center>
</body>

</html>
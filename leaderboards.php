<html>

<head>

</head>

<body>

<?php
    include "config.php";

    $connection = new mysqli("localhost", $mysql_username, $mysql_password, $mysql_database);

    $sql_getrankings = "SELECT * FROM players ORDER BY score DESC";
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
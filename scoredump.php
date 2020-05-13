<?php
    include "config.php";

    $connection = new mysqli("localhost", $mysql_username, $mysql_password, $mysql_database);

    $username = $_GET["username"];

    $sql = "SELECT * FROM scores WHERE username=".$username."";
    $query = $connection->query($sql);
    
    if($query->num_rows > 0){
        while($row = $query->fetch_assoc()){
            $mapdata = "SELECT * FROM mapstatus WHERE md5='".$row["beatmaphash"]."'";
            $mapdata_q = $connection->query($mapdata);
            if($mapdata_q->num_rows > 0){
                while($map = $mapdata_q->fetch_assoc()){
                    echo "MapData: ".$map["data"];
                }
            }else {
                echo "Unknown - Map []";
            }
            echo "<br>ScoreID: ".$row["scoreid"];
            echo "<br>BeatmapHash: ".$row["beatmaphash"];
            echo "<br>Score: ".$row["score"];
            echo "<br>Max Combo: ".$row["maxcombo"];
            echo "<br>Hit300: ".$row["hit300"];
            echo "<br>Hit100: ".$row["hit100"];
            echo "<br>Hit50: ".$row["hit50"];
            echo "<br>HitGeki: ".$row["hitGeki"];
            echo "<br>HitKatu: ".$row["hitKatu"];
            echo "<br>HitMiss: ".$row["hit0"];
            echo "<br>Perfect: ".$row["perfect"];
            echo "<br>Mods: ".$row["mods"];
            echo "<br>Pass: ".$row["pass"];
            echo "<br>Ranked: ".$row["ranked"];
            echo "<br><br><br><br>";
        }
    }

?>
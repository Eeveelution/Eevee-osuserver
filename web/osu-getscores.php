<?php
    include "../config.php";

    $connection = new mysqli("localhost", $mysql_username, $mysql_password, $mysql_database);
    
    $beatmaphash = $_GET["c"];

    $sql_getscores = sprintf("SELECT * FROM scores WHERE beatmaphash='%s' AND pass='True' ORDER BY score DESC;",
                         $beatmaphash
                     );
    $query_getscores = $connection->query($sql_getscores);

    $sql_getrankingstatus = "SELECT * FROM mapstatus WHERE md5='".$beatmaphash."'";
    $getrankingstatus_query = $connection->query($sql_getrankingstatus);

    if($getrankingstatus_query->num_rows > 0){
        while($row = $getrankingstatus_query->fetch_assoc()){
            if($row["status"] == "0"){
                echo "0:Unranked Map!:0:0:0:0:0:0:0:0:False:0\n";
                die();
            }
        }
    } else {
        echo "0:Not Submitted Map!:0:0:0:0:0:0:0:0:False:0\n";
            die();
    }
    

    if($query_getscores->num_rows > 0){
        while($row = $query_getscores->fetch_assoc()){
            $perfect_bool = "0";
            $pass_bool = "0";
            if($row["pass"] == "True") $pass_bool = "1";
            if($row["perfect"] == "True") $perfect_bool = "1";

            echo $row['scoreid'] . ":" . $row['username'] . ":" . $row['score'] . ":" . $row['maxcombo'] . ":" . 
                 $row['hit50']   . ":" . $row['hit100']   . ":" . $row['hit300']. ":" . $row['hit0'] . ":" . 
                 $row['hitKatu'] . ":" . $row['hitGeki'] . ":"  . $row['perfect']. ":" . $row['mods'] . "\n";

        }
    }
    $connection->close();
?>
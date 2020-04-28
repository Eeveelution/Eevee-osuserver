<?php
    session_start();
    include "../config.php";
    ;
    
    $connection = new mysqli("localhost", $mysql_username, $mysql_password, $mysql_database);
    
    $checkpassword = sprintf("SELECT * FROM players WHERE playername='%s' AND md5pass='%s'", $_SESSION["username"], $_SESSION["password"]);

    $passresponse = $connection->query($checkpassword);
    if($passresponse->num_rows !== 1){
        echo $checkpassword;
        echo "wrong password <br>";
        die();
    }

    $check_privledge = sprintf("SELECT * FROM staff WHERE username='%s'", $_SESSION["username"]);
    $response = $connection->query($check_privledge);

    if($response->num_rows > 0){
        while($row = $response->fetch_assoc()){
            if($row["privledge"] === "all" || $row["privledge"] === "gmt"){
                all_privledges();
            } else if($row["privledge"] == "bat"){
                bat_privledges();
            } else if($row["privledge"] == "com"){
                com_privledges();
            }
        }
    }

    function all_privledges(){
        bat_privledges();
    }
    function bat_privledges(){
        echo<<<END

        <a href="panel.php">Back to Main Panel</a><br><br>

        <h1>Welcome to the Ranking Panel</h1>
        <p>Add Beatmap to the Database:</p>

        <form action="rankingpanel-add.php" method="post">
            <p>Beatmap MD5:</p>
            <input type="text" name="md5" size="50"/>
            <p>Artist - Title [Difficulty]:</p>
            <input type="text" name="data" size="50"/>
            <p>Status:</p>

            <input type="radio" id="ranked" name="status" value="ranked"/>
            <label for="ranked">Ranked (Gives Ranked Score & Has Leaderboard)</label> <br>

            <input type="radio" id="approved" name="status" value="approved"/>
            <label for="ranked">Approved (Has Leaderboard doesn't give Ranked Score)</label> <br>

            <input type="radio" id="unranked" name="status" value="unranked"/>
            <label for="ranked">Unranked (Has no Leaderboard and doesn't give ranked Score)</label> <br><br>

            <p>Own Username:</p>
            <input type="text" name="username"/>
            <p>Own Password:</p>
            <input type="password" name="pass"/>

            <input type="submit" value="Add to Database"/>
        </form>

        <br><br>

        <p>Update Beatmap From Database</p>

        <form action="rankingpanel-change.php" method="post"/>
            <p>Beatmap MD5:</p>
            <input type="text" name="md5" size="50"/>
            <p>New Artist - New Title [Difficulty]:</p>
            <input type="text" name="data" size="50"/>
            <p>New Status:</p>

            <input type="radio" id="ranked" name="status" value="ranked"/>
            <label for="ranked">Ranked (Gives Ranked Score & Has Leaderboard)</label> <br>

            <input type="radio" id="approved" name="status" value="approved"/>
            <label for="ranked">Approved (Has Leaderboard doesn't give Ranked Score)</label> <br>

            <input type="radio" id="unranked" name="status" value="unranked"/>
            <label for="ranked">Unranked (Has no Leaderboard and doesn't give ranked Score)</label> <br><br>

            <p>Own Username:</p>
            <input type="text" name="username"/>
            <p>Own Password:</p>
            <input type="password" name="pass"/>

            <input type="submit" value="Change"/>

        </form>
END;
    }
    function com_privledges(){
        echo "as a Community Manager you cannot Rank Beatmaps,";
    }


?>
<?php
    session_start();
    include "../config.php";
    ;
    
    $connection = new mysqli("localhost", $mysql_username, $mysql_password, $mysql_database);
    
    $checkpassword = sprintf("SELECT * FROM players WHERE playername='%s' AND md5pass='%s'", $_POST["username"], hash("md5",$_POST["pass"]));

    $passresponse = $connection->query($checkpassword);
    if($passresponse->num_rows !== 1){
        
        echo "wrong password <br>";
        die();
    }

    $check_privledge = sprintf("SELECT * FROM staff WHERE username='%s'", $_POST["username"]);
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
        include "../config.php";
        $_connection = new mysqli("localhost", $mysql_username, $mysql_password, $mysql_database);

        $md5 = $_POST["md5"];
        $data = $_POST["data"];
        $status = $_POST["status"];

        $__sql_status_converted = 0;

        if($status == "ranked") $__sql_status_converted = 1;
        else if($status == "approved") $__sql_status_converted = 2;
        else if($status == "unranked") $__sql_status_converted = 0;

        $sql_mapexists = "SELECT * FROM mapstatus WHERE md5='".$md5."'";
        $mapexists_query = $_connection->query($sql_mapexists);

        if($mapexists_query->num_rows === 1){
            $sql_update = "UPDATE mapstatus SET data='".$data."', status='".$__sql_status_converted."' WHERE md5='".$md5."'";

            if($_connection->query($sql_update) === TRUE){
                echo "success";
            }
        }
    }
    function com_privledges(){
        echo "as a Community Manager you cannot Rank Beatmaps,";
    }


?>
<html>

<head>

</head>

<body>

<?php
    session_start();
?>

    osu!2007 Server | 
        <a href="index.php">Home</a> |
        <a href="leaderboards.php">Rankings</a> |
        <a href="login.html">Login</a> |
        <a href="register.html">Register</a> |
        
<?php
        
        
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
                echo '<a href="admin/panel.php">Admin Panel</a> | ';
            }
        
            if($query->num_rows > 0){
            
                echo "<a href='players.php?username=" . $username . "'>". $username . "</a> | ";
                echo "<a href='logout.php'>Log out</a> |";
            }
        }
    
?>
        <br><br>

    Welcome to the Main Page of the osu! 2007 Server, pretty emptyy here, <br/>
    Here is a temporary navbar: <br/><br/>
    
</body>

</html>
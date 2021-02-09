<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'LQV_login_system');
$server="localhost";
$usr="root";
$pwd_serv="";
$name="LQV_login_system";
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect($server, $usr, $pwd_serv, $name);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
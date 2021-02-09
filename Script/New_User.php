<?php
    // Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["admin"] !== "True") {
    header("location: login.php");
    exit;
} 
else {
    $query = "insert into users
                (username, email, pwd, admi)
              values
                ('".$_GET["name"]."', '".$_GET["mail"]."', '".$_GET["pass"]."', '".$_GET["admin"]."'')";
    echo $query;
}
?>
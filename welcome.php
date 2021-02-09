<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="S&F/headers.css">
    <link rel="icon" href="Images/LQV_login.png" />
</head>
<body>
    <header>
        <div><img id="LOGO" src="Images/LQV_login.png"/><br></div>
        <nav class="navigation">
            <button>Home</button>
            <button onclick="window.location.href='files.php'">Files</button>
            <button onclick="window.location.href='admin.php'">Admin Section</button>
            <button onclick="window.location.href='logout.php'">Sign Out</button>
        </nav>
    </header>
    <div id= "Welcome" class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome !</h1>
    </div>
    <div id="the_box" class="navigation">
        <h1>What do you want to do today ?</h1><br><br>
        <h2>You are currently in the "Home" section. You can always click the Home button to come back to this page anytime</h2>
        <button>Home</button><br><br>
        <h2>You can access Dropbox and Cin7 in the "Files" section by clicking the button bottom or the one in the top right corner</h2>
        <button onclick="window.location.href='files.php'">Files</button><br><br>
        <h2>If you are an Administrator you can access the Admin Section tab. If you're not, you will only get redirected on this page</h2>
        <button onclick="window.location.href='admin.php'">Admin Section</button><br>
        <h2>If you're done, don't forget to Sign Out</h2>
        <button onclick="window.location.href='logout.php'">Sign Out</button>
    </div>
</body>
</html>
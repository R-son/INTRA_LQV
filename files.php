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
        <title>Files</title>
        <link rel="stylesheet" href="S&F/headers.css">
        <link rel="stylesheet" href="S&F/menu.css">
        <link rel="icon" href="Images/LQV_login.png" />
        <link rel="stylesheet" href="tabbis.css" />
        <script src="S&F/files_tabs.js"></script>
    </head>
    <body>
        <header>
            <div><img id="LOGO" src="Images/LQV_login.png"/><br></div>
            <nav class="navigation">
                <button onclick="window.location.href='welcome.php'">Home</button>
                <button>Files</button>
                <button onclick="window.location.href='admin.php'">Admin Section</button>
                <button onclick="window.location.href='logout.php'">Sign Out</button>
            </nav>
        </header>
        <div class="block">
            <!-- Tab navigation buttons-->
            <div class="tab">
                <button class="tablinks" id="firstab" onclick="openCity(event, 'Preview')">Preview</button>
                <button class="tablinks" id="tab2" onclick="openCity(event, 'Manip')">Manual manipulations</button>
                <button class="tablinks" id="lastab" onclick="openCity(event, 'Direct')">Direct Links</button>
            </div>

            <!-- Tab content -->
            <div id="Preview" class="tabcontent">
                <h3>Preview</h3>
                <p>Preview files and Cin7 infos</p>
                <iframe id="ifram_test" title="yes" src="https://www.dropbox.com/sh/951j4qfy7e7uoew/AAAZZyzafz2CVf5zaTTf2cq7a?dl=0" width="1000" height="700"></iframe>
            </div>
        
            <div id="Manip" class="tabcontent">
                <h3>Manual manipulations</h3>
                <p>All these options are made automatically, you can still make them manually if there is any errors</p>
            </div>
            <div id="Direct" class="tabcontent">
                <h3>Direct Links<h3>
                <div id="link">
                    <a href= https://www.dropbox.com/sh/hinv7hhmsuep4yd/AADWIU9d0dXAl2FwmQ5MlcvMa?dl target="_blank"><img src="Images/Dropbox.png"></a>
                </div>
            </div>
        </div>
    </body>
</html>
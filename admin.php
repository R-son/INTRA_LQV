<?php
// Initialize the session
session_start();

// Check if the user is logged in and if he's an admin, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["admin"] !== "True"){
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Admin</title>
        <link rel="icon" href="Images/LQV_login.png" />
        <link rel="stylesheet" href="S&F/headers.css">
        <link rel="stylesheet" href="S&F/menu.css">
        <script src="S&F/files_tabs.js"></script>
    </head>
    <body>
        <header>
            <div><img id="LOGO" src="Images/LQV_login.png"/><br></div>
            <nav class="navigation">
                <button onclick="window.location.href='welcome.php'">Home</button>
                <button onclick="window.location.href='files.php'">Files</button>
                <button>Admin Section</button>
                <button onclick="window.location.href='logout.php'">Sign Out</button>
            </nav>
        </header>
        <div class="block">

            <!-- Tab navigation buttons-->
            <div class="tab">
                <button class="tablinks" id="firstab" onclick="openTab(event, 'Preview')">Preview</button>
                <button class="tablinks" id="tab2" onclick="openTab(event, 'Manip')">Manual manipulations</button>
                <button class="tablinks" id="lastab" onclick="openTab(event, 'Direct')">Direct Links</button>
            </div>

            <!-- Tabs content -->
            <div id="Preview" class="tabcontent">
                <h3>Preview</h3>
                <p>Preview files and Cin7 infos</p>
            </div>

            <div id="Manip" class="tabcontent">
                <h3>Manual manipulations</h3>
                <button id="new_user" onclick="">Create new user</button>
                <h1 style="color:#7c1743">Manually generate daily files</h1>
                <form id="manual_generation" action="Script/create.php" method="post">
                    <div id="FR">
                        <h3>France</h3>
                        <textarea name="to_exclude_FR" id='to_exclude' rows="10" cols="10" placeholder="Enter criterias to exclude separated by a comma"></textarea>
                        <textarea name="shops_to_include_FR" id='to_exclude' rows="10" cols="10" placeholder="Enter shops to include with adresses (shop : adress) all separated by a comma"></textarea>
                    </div>
                    <div id="HK">
                        <h3>Hong Kong</h3>
                        <textarea name="to_exclude_HK" id='to_exclude' rows="10" cols="10" placeholder="Enter criterias to exclude separated by a comma"></textarea>
                        <textarea name="shops_to_include_HK" id='to_exclude' rows="10" cols="10" placeholder="Enter shops to include with adresses (shop : adress) all separated by a comma"></textarea>
                    </div>
                    <div id="SG">
                        <h3>Singapour</h3>
                        <textarea name="to_exclude_SG" id='to_exclude' rows="10" cols="10" placeholder="Enter criterias to exclude separated by a comma"></textarea>
                        <textarea name="shops_to_include_SG" id='to_exclude' rows="10" cols="10" placeholder="Enter shops to include with adresses (shop : adress) all separated by a comma"></textarea>
                    </div>
                    <input id="Script_run" type="submit" value="Generate">
                </form>
            </div>

            <div id="Direct" class="tabcontent">
                <h3>Direct Links<h3>
                <div id="link">
                    <a href= https://www.dropbox.com/sh/hinv7hhmsuep4yd/AADWIU9d0dXAl2FwmQ5MlcvMa?dl title="Dropbox" target="_blank"><img src="Images/Dropbox.png"></a>
                    <a href="" title="Cin7" target="_blank"><img src="Images/cin7_logo.png"></a>
                </div>
            </div>

        </div>
    </body>
</html>
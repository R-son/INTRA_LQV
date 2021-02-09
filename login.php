<?php
// Initialize the session
session_start();
  include 'configuration.php';
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
 
// Define variables and initialize with empty values
$username = $password = $mail = $admin = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["pwd"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["pwd"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT username, pwd, admi FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $username, $pwd_serv, $admin);
                    if(mysqli_stmt_fetch($stmt)){
                        if($password == $pwd_serv){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["username"] = $username;    
                            $_SESSION["admin"] = $admin;              

                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else{
                            print_r($password, null);
                            print_r($pwd_serv, null);
                            print_r(password_verify($password, $pwd_serv), null);
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="icon" href="Images/LQV_login.png" />
    <link rel="stylesheet" href="S&F/login.css">
    <script src="S&F/show_pass.js"></script>
</head>
<body>
    <div class="bg-image"></div>
    <div class="bg-text">
        <div class="wrapper">
            <img id="LOGO" src="Images/LQV_login.png"/><br>
            <h2>Login</h2>
            <p>Please fill in your credentials to login.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <input type="text" name="username" class="form-control" value="<?php echo $username; ?>" placeholder="USERNAME"><br>
                    <span class="help-block"><?php echo $username_err; ?></span>
                </div><br>
                <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <input type="password" name="pwd" id="pwd" class="form-control" placeholder="PASSWORD"><br>
                    <span class="help-block"><?php echo $password_err; ?></span>
                </div><br><br>
                <div class="form-group">
                <input type="checkbox" onclick="Toggle()"> Show password<br><br>
                <input type="image" id="button" src="Images/Login_button.png" alt="Submit">
                </div>
            </form>

        </div>    
    </div>
</body>
</html>
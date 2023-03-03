<?php
//Test data - Test 1:
//user_id = 1
//username = Joshua
//password = Joshua100#



if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['log-in_account_submit'])){
    //Only tigger if a POST request came from the 'log-in_account_submit' button from the account.php page

    //Start_a_session
    session_start();

    //Make sure the order errors are null so they aren't displayed when they're not true:
    //Error for order page
    $_SESSION['Error_order_no_loggin'] = "";

    //Errors for the log-in form on the account page
    //Error are outputted when they're not null
    $_SESSION['Error_username'] = "";
    $_SESSION['Error_password'] = "";
    $_SESSION['Error_username_null'] = "";
    $_SESSION['Error_password_null'] = "";

    //Include the connection.php file to run it's mysqli functions here:
    require_once('connection.php');
    $table_name = "customers";
    //Create the connectionClass object from connection.php to run the querying functions here:
    $connection_obj = new connectionClass($table_name);

    //Get the username and password from the form input:
    //Username should not have any speical characters in it:
    $_SESSION['check_username'] = htmlspecialchars($_POST['username']);
    $_SESSION['check_password'] = $_POST['password'];

    //Run the function to query the database for the password that matches the inputted username
    $userID_username_password = $connection_obj->mysqli_select_userID_username_password($_SESSION['check_username']);
    
    //Check if the username or password is null:
    if(empty($_SESSION['check_username'])){
        $_SESSION['Error_username_null'] = "All fields must be filled in";

        //Takes you to page once script has ended:
        header("location: account.php");
    }

    elseif(empty($_SESSION['check_password'])){
        $_SESSION['Error_password_null'] = "All fields must be filled in";

        //Takes you to page once script has ended:
        header("location: account.php");
    }

    //Check to see if the username is valid
    elseif(!isset($userID_username_password[0]['username'])){
        //If the username attribute isn't set inside the mysqli ASSOC array it doesn't exist in the database:
        $_SESSION['Error_username'] = $_SESSION['check_username'] . " : Is not a valid username!";
        $_SESSION['check_password'] = trim(htmlspecialchars($_SESSION['check_password']));

        //Takes you to page once script has ended:
        header("location: account.php");

    }
    //Check to see if the password is valid
    else{
        if ($userID_username_password[0]['password'] != $_SESSION['check_password']){
            //If the password inputted and the 1 with the username doesn't match exactly, throw and error
            $_SESSION['Error_password'] = "That password doesn't match the username: " . $_SESSION['check_username'];
            $_SESSION['check_username'] = trim(htmlspecialchars($_SESSION['check_password']));
            header("location: account.php");
        }
        else{
            //Start session - Get session details:
            //Set the user's ID of the session and set logged_in to true to get access to logged-in.php automatically
            $_SESSION['userID'] = $userID_username_password[0]['user_id'];
            $_SESSION['access_level'] = intval($userID_username_password[0]['user_type_id']);
            $_SESSION['logged_in'] = true;

            //Set the user_type_id for later:
            $_SESSION['user_type_id'] = $userID_username_password[0]['user_type_id'];

            //Use header() to redirect to the logged-in page:
            header("location: logged-in.php");
        }
    }
}
?>
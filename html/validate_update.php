<?php
/*This function will log the user 'out' of the system if they press the 'log-out' button on the 
'logged-in' page. It essentially destorys the session (the users access to their page and sends 
them back to the homepage)
*/

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['log-out_button'])){
    //If the 'log-out_button' is pressed the session is destroyed
    //The user is sent back to home.php
    session_start();
    session_destroy();
    header("location: home.php");
}

elseif($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['save_changes_button'])){
    //If the 'save_changes_button' is pressed the users new data is sanitised and updated
    //Start the session and include the connection object
    session_start();
    require_once('connection.php');
    $table_name = "users";
    $connection_obj = new connectionClass($table_name);

    //go through and sanitise all neccesary strings (dont do phone):
    $_POST['first_name_input'] = htmlspecialchars(trim($_POST['first_name_input']));
    $_POST['last_name_input'] = htmlspecialchars(trim($_POST['last_name_input']));
    $_POST['gender_input'] = htmlspecialchars(trim($_POST['gender_input']));
    $_POST['post_code'] = htmlspecialchars(trim($_POST['post_code']));
    $_POST['country'] = htmlspecialchars(trim($_POST['country']));
    $_POST['email_input'] = htmlspecialchars(trim($_POST['email_input']));
    $_POST['dob_input'] = htmlspecialchars(trim($_POST['dob_input']));

    //Make sure datetime is formatted correctly:
    $_POST['dob_input'] = new DateTime($_POST['dob_input']);
    $_POST['dob_input'] = $_POST['dob_input']->format('Y-m-d');

    //Correct the gender value (integers):
    if(Strtolower($_POST['gender_input']) == "male"){
        $_POST['gender_input'] = 1;
    }
    elseif(Strtolower($_POST['gender_input']) == "female"){
        $_POST['gender_input'] = 0;
    }
    else{
        $_POST['gender_input'] = 2;
    }

    //Run the update statement:
    $connection_obj->update_customers($_SESSION['userID'], $_POST['first_name_input'], 
                                        $_POST['last_name_input'], $_POST['phone_input'], 
                                        $_POST['email_input'], $_POST['address_input'], 
                                        $_POST['gender_input'], $_POST['dob_input'],
                                        $_POST['country_input'], $_POST['post_code_input']);

    //Send the user back to the homepage:
    header("location: home.php");
}
?>
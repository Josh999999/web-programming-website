<?php
/*This page will be used to validate the inputted username on the create_account.php page and sanatise all of the
other peaces of inputted data ready for it to be inserted into the database:
*/


if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['submit_account'])){
    try{
        //If the 'save_changes_button' is pressed the users new data is sanitised and updated
        //Start the session and include the connection object
        session_start();
        require_once('connection.php');
        $table_name = "users";
        $connection_obj = new connectionClass($table_name);

        //Check the username doesn't already exist:
        $_SESSION['username_taken_error'] = "";
        $_POST['create_username_input'] = htmlspecialchars(trim($_POST['create_username_input']));

        //go through and sanitise all neccesary strings:
        $_POST['create_firstName_input'] = htmlspecialchars(trim($_POST['create_firstName_input']));
        $_POST['create_lastName_input'] = htmlspecialchars(trim($_POST['create_lastName_input']));
        $_POST['create_gender_input'] = htmlspecialchars(trim($_POST['create_gender_input']));
        $_POST['create_post_code_input'] = htmlspecialchars(trim($_POST['create_post_code_input']));
        $_POST['create_country_input'] = htmlspecialchars(trim($_POST['create_country_input']));
        $_POST['create_email_input'] = htmlspecialchars(trim($_POST['create_email_input']));
        $_POST['create_dob_input'] = htmlspecialchars(trim($_POST['create_dob_input']));
        $_POST['create_phone_input'] = htmlspecialchars(trim($_POST['create_phone_input']));

        //Correct the gender value (integers):
        if(Strtolower($_POST['create_gender_input']) == "male"){
            $_POST['create_gender_input'] = 1;
        }
        elseif(Strtolower($_POST['create_gender_input']) == "female"){
            $_POST['create_gender_input'] = 0;
        }
        elseif(Strtolower($_POST['create_gender_input']) == "other"){
            $_POST['create_gender_input'] = 2;
        }
        else{
            $_POST['create_gender_input'] = 3;
        }

        //Store the post request in the session
        $_SESSION['POST_info'] = $_POST;

        //Get all the usernames from the database
        $usernames = $connection_obj->get_usernames($_POST['create_username_input']);
        if($usernames > 0){
            $_SESSION['username_taken_error'] = "This usename is alreay taken";
            header("location: create_account.php");
        }
        elseif(strlen($_POST['create_username_input']) < 8){
            $_SESSION['username_taken_error'] = "This usename is not long enough";
            header("location: create_account.php");
        }
        elseif(trim($_POST['create_username_input']) == ""){
            $_SESSION['username_taken_error'] = "You need to fill the username in!";
            header("location: create_account.php");
        }
        else{
            //Clean password;
            $_POST['create_password_input'] = htmlspecialchars(trim($_POST['create_password_input']));

            //Make sure datetime is formatted correctly:
            $_POST['create_dob_input'] = new DateTime($_POST['create_dob_input']);
            $_POST['create_dob_input'] = $_POST['create_dob_input']->format('Y-m-d');

            //Run the update statement:
            //Change to insert:
            $connection_obj->insert_user($_POST['create_firstName_input'], $_POST['create_username_input'], $_POST['create_password_input'],
                                                $_POST['create_lastName_input'], $_POST['create_phone_input'], 
                                                $_POST['create_email_input'], $_POST['create_address_input'], 
                                                $_POST['create_gender_input'], $_POST['create_dob_input'],
                                                $_POST['create_country_input'], $_POST['create_post_code_input']);

            //Send the user back to the homepage:
            header("location: home.php");
        }
        
    }
    catch(Exception $except_error){
        header("location: home.php");
    }
}
else{
    header("location: home.php");
}
?>
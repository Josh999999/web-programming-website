<!DOCTYPE html>

<input type="hidden" name="delete_kick_trigger" id="delete_kick_trigger">

<?php
//reject the user if they are not logged in:
//Start the session:
include('header.php');

if(!isset($_SESSION['userID']) || empty($_SESSION['userID']) || !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true){
    header("location: home.php");
}
else{
    ?>

    <html>
        <head>
            <title>Homepage</title>
            <meta charset="utf-8"/>
            <meta name="author" content="me"/>
            <link rel="stylesheet" href="../style/delete_account_style.css" type="text/css">
            
        </head>

        <?php
        //Php for page startup:
            
            //Include the connection.php file to run it's mysqli functions here:
            require_once('connection.php');
            $table = "customers";
            //Create the connectionClass object from connection.php to run the querying functions here:
            $connection_obj = new connectionClass($table);
            //Get the username:
            $username_get = $connection_obj->retrieve_user_details($_SESSION['userID']);
            $username = $username_get[0]['username'];

            //Declare error varaibles:
            $_SESSION['delete_password_error'] = "";
            $_SESSION['correct_password_delete'] = false;
            $_SESSION['num_delete_attempts'] = 0;
        ?>

        <?php
        //Php for handling the delete request:
            if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['delete_password_input'])){
                $user_details = $connection_obj->retrieve_user_details($_SESSION['userID']);
                if($_POST['delete_password_input'] == $user_details[0]['password']){
                    //If the password is:
                    try{
                        $connection_obj->delete_user_details($_SESSION['userID']);
                    }
                    catch(mysqli_sql_exception $e){
                        $_SESSION['delete_password_error'] = "Couldn't delete account";
                        $_SESSION['correct_password_delete'] = false;
                        $caught = true;
                    }
                    if(!isset($caught)){
                        $_SESSION['correct_password_delete'] = true;
                    }
                }
                elseif(empty($user_details[0]['username']) && empty($user_details[0]['password'])){
                    $_SESSION['correct_password_delete'] = true;
                    $_SESSION['delete_password_error'] = "This account already is deleted";
                }
                else{
                    $_SESSION['delete_password_error'] = "This password doesn't match you account";
                    $_SESSION['correct_password_delete'] = false;
                }
            }
        ?>

        <body>
            <div id="body2">
                <?php if($_SESSION['correct_password_delete'] == false){
                    //Whilst php hasn't returned that the password put in to deleted the account is true
                    //this will be displayed.
                    ?>
                    <article id="delete_input_box" class="delete_box">
                        <form id="delete_account_form" action="delete_account.php" method="post">
                            <div id="delete_design">
                                <h2 id="account_name" class="title_text"><?php echo "<b>DELETE ACCOUNT: <u>$username</u></b>";?></h2>
                                <br>
                                <h3 id="delete_title" class="title_text">
                                    Are you sure you want to delete this account?
                                </h3>

                                <h3 id="password_title" class="title_text">
                                    To delete this account, you need to input your
                                    password so we can make sure that it is you:
                                </h3>
                                <br>
                                <br>

                                <label for="delete_password_input"  class="title_text" name="delete_password_input_label">
                                    <?php echo "Please input password for account: ".$username . " :"; ?>
                                </label><br>
                                <input type="text" id="delete_password_input" name="delete_password_input" value placeholder="paSSw0rd1234#" required><br>
                                <input type="button" id="submit_delete_password_btn" name="submit_delete_password_btn" value="DELETE" onclick="form_submit()">

                                <span id="delete_password_error" class="text"
                                <?php //If there was any error when the password was inputted one of these will be displayed
                                if(isset($_SESSION['delete_password_error']) && !empty($_SESSION['delete_password_error'])){
                                    echo "style='color: red;'";
                                }
                                ?>>
                                    <?php
                                        if(isset($_SESSION['delete_password_error']) && !empty($_SESSION['delete_password_error'])){
                                            echo "<p>" . $_SESSION['delete_password_error'] . "</p>";
                                        }
                                    ?>
                                </span>
                            </div>
                        </form>
                    </article>
                    <?php
                }
                elseif($_SESSION['correct_password_delete'] == true){
                    //Displays when the account has been deleted successfully:
                    ?>
                    <article id="delete_complete_box" class="delete_box">
                        <h2 id="deleted_title" class="title_text"><u>Your account has been successfully deleted!</u></h2>
                        <br><br>
                        <h3 id="deleted_account_name" class="title_text">
                            <?php echo "<b>ACCOUNT: $username has been deleted</b>";?>
                        </h3>
                        <label for="deleted_account_date" class="title_text">Account deletion date:</label><br>
                        <input type="text" id="deleted_account_date" name="deleted_account_date" value="" disabled><br><br>
                        <span class="text" id="already_deleted_account"
                        <?php if(isset($_SESSION['delete_password_error']) && !empty($_SESSION['delete_password_error'])){
                            echo " style='color: red;'";
                        }?>>
                        <?php
                        //The only way for an error to occurr here is if the usernames account has aleady been
                        //Deleted and their has been an error with the system
                            if(isset($_SESSION['delete_password_error']) && !empty($_SESSION['delete_password_error'])){
                                echo "<p>" . $_SESSION['delete_password_error'] . "</p>";
                            }
                        ?>
                        </span>
                        <label for="kick_timer" class="title_text">You will be automatically returned to the homepage in:</label>
                        <br>
                        <p id="kick_timer" class="title_text">00:00</p>
                    </article>
                    <?php
                    //Destory the session so the page can't load again:
                    session_destroy();
                }
                ?>
            </div>
        </body>

        <script type="text/javascript" defer>
            //JS included on the page to due issues with separation and the timer.

            //Get the input to put the dat in
            const date_input = document.getElementById('deleted_account_date');
            //Function to get the current date and put it into the "deleted_account_date" input:
            function get_date(){
                const date = new Date();
                date.toDateString();
                date_input.value = "Deleted At: " + date;
            }

            //Function to submit the form once validated for NN:
            function form_submit() {
                //get the password and clean it:
                var password_input = document.getElementById('delete_password_input').value.replace(/\s/g, '');
                //Make sure the password has input:
                if (password_input.length == 0) {
                    alert("Please input a password!")
                }
                else{
                    var form = document.getElementById("delete_account_form");
                    form.submit();
                }
            }

            //Timer variables:
            let seconds = 60;
            let timerInterval;
            const time_output = document.getElementById('kick_timer');
            const toggleTimerzl = () =>{
                timerInterval = setInterval(() => {
                    if(seconds < 1){
                        clearInterval(timerInterval);
                        window.location.href = 'home.php';
                    }
                    else{
                        seconds-=1;
                        console.log(seconds);
                        time_output.innerText = `|00:${seconds}|`;
                    }
                }, 1000);
            };

            //Add event listeners for the loading of the 'delete_complete_box' acrticle element:
            //Once the element is loaded start the kick timer:
            complete_box = document.getElementById('delete_complete_box');
            complete_box.addEventListener("load", toggleTimerzl());
            //Onload add the current date and time:
            complete_box.addEventListener("load", get_date());

            
        </script>

    </html>

    <?php
        //Clear error varaibles at the end of the page:
        $_SESSION['delete_password_error'] = "";
        $_SESSION['correct_password_delete'] = false;
        include('footer.php');
    }
?>
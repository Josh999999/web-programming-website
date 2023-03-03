<!DOCTYPE html>

<?php
    include('header.php');
?>

<html>
    <head>
        <title>Homepage</title>
        <link rel="stylesheet" href="../style/account_style.css?p=<?php print sha1(time()); ?>">
        <meta charset="utf-8"/>
        <meta name="author" content="me" />
        <script src="file.js" defer></script>
    </head>

    <body>
        <div id="body2">
            <h2>Log-In to your Account:</h2>
            <form id="log-in_account_form" action="<?php echo htmlspecialchars("log-in.php"); ?>" method="post">
                <label id="account_username">Username:</label>
                <input id="username_input" type="text" name="username" value="<?php 
                if(!empty($_SESSION['Error_password']) || !empty($_SESSION['Error_password_null']) && isset($_SESSION['check_username'])){
                    //If there is a problem with the password the username will remain in the input box (sticky form)
                    echo $_SESSION['check_username'];
                } 
                else{
                    //Value will be nothing otherwise (this will mean there was a problem with the username)
                    echo "";
                } 
                //Null error section:
                ?>">
                <label id="account_password">Password:</label>
                <input id="password_input" type="text" name="password" value="<?php 
                if(!empty($_SESSION['Error_username']) || !empty($_SESSION['Error_username_null']) && isset($_SESSION['check_password'])){
                    //If there is a problem with the username the password will remain in the input box (sticky form)
                    echo $_SESSION['check_password'];
                } 
                else{
                    //Value will be nothing otherwise (this will mean there was a problem with the password)
                    echo "";
                }
                ?>">

                <span id="error_span"><?php
                //Outputs the error that occured with the log-in process:
                if(!empty($_SESSION['Error_username'])){
                    //Incorrect username:
                    echo "<p>" . $_SESSION['Error_username'] . "</p>";
                } 
                elseif(!empty($_SESSION['Error_password'])){
                    //Incorrect password:
                    echo "<p>" . $_SESSION['Error_password'] . "</p>";
                }
                elseif(!empty($_SESSION['Error_password_null'])){
                    //No password inputted:
                    echo "<p>" . $_SESSION['Error_password_null'] . "</p>";
                }
                elseif(!empty($_SESSION['Error_username_null'])){
                    //No username inputted:
                    echo "<p>" . $_SESSION['Error_username_null'] . "</p>";
                }
                ?>
                </span>
                <br>
                <span id="error_no_account_orders">
                    <?php
                        if(isset($_SESSION['Error_order_no_loggin']) && !empty($_SESSION['Error_order_no_loggin'])){
                            //Outputs an error from the orders page (if the user tries to order items in the basket without being logged in
                            //they will be re-directed here an this error will be displayed)
                            echo "<p>" . $_SESSION['Error_order_no_loggin'] . "</p>";
                        }
                        //Turn to null after it has been displayed
                        $_SESSION['Error_order_no_loggin'] = "";
                    ?>
                </span>
                <div id="account_buttons_grid">
                    <input class="account_inputs" id="log-in_account_submit" type="submit" name="log-in_account_submit" value="Log-In">
                    <input class="account_inputs" id="create_account_submit" type="button" name="create_account_btn" value="<?php echo "Create\nAccount";?>" onclick="window.location.href='\create_account.php'">
                    <?php 
                        //The log-in button triggers the log-in.php script which will verify the users inputs.
                        //The other button will re-direct the user to the create_account.php page.
                     ?>
                </div>
            </form>
        </div>
    </body>

</html>

<?php
 include('footer.php');
?>
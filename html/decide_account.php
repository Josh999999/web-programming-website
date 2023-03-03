<?php
/*This page uses the session object to decide wether the user can proceed to their account page or has to log-in
It will use the 'logged-in' boolean value from the '$_SESSION' object to determine this: */

if ($_SERVER['REQUEST_METHOD'] == "GET" && $_GET['type'] == "logged_in"){
        session_start();
        if (isset($_SESSION['logged_in'])){
            if($_SESSION['logged_in']){
                //The sessions logged_in attribute is true then the user has already entered
                //correct log-in details and may view the rest of their information:
                header("location: logged-in.php");
            }
            else{
                //Otherwise they are sent to account.php to log-in or create and account
                header("location: account.php");
            }
        }
        else{
            //Otherwise they are sent to account.php to log-in or create and account
            header("location: account.php");
        }
    }
else{
    header("location: home.php");
}
?>
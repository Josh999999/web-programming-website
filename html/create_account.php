<!DOCTYPE html>

<?php
    include('header.php');
?>

<html>
    <head>
        <title>Homepage</title>
        <link rel="stylesheet" href="../style/create_account_style.css">
        <link rel="stylesheet" href="../style/create_account_style.css">
        <meta charset="utf-8"/>
        <meta name="author" content="me"/>
        <script src="../script/create_account_validation.js?p=<?php print sha1(time()); ?>" defer></script>
        
    </head>

    <?php
    //Make sure the order login_error is null:
    $_SESSION['Error_order_no_loggin'] = "";
    ?>

    <body>
        <div id="body2">
            <form name="accountCreationForm" id="create_account_form" action="<?php echo htmlspecialchars("create_account_validation.php"); ?>" method="post">
                
                <input id="current_page" name="current_page" type="hidden" value="form1">
            
                <h3>Create Account:</h3>
                <span id="username_error" class="">
                    <?php
                        //Displays an error the PHP retursn at the top
                        if(isset($_SESSION['username_taken_error']) && !empty($_SESSION['username_taken_error'])){
                            echo "<p>" . $_SESSION['username_taken_error'] . "</p>";
                        }
                    ?>
                </span>

                <div class="create_forms displayed" id="form1" name="form1" value="form1">
                    <input class="inputID" type="text" style="visibility: hidden" value="1" id="form1inputID">

                    <h4 class="sction_title">Section - 1:</h4>
                    <label id="create_firstName_label"><u>First name:</u></label><br>
                    <input class="create_account_inputs text_input" name="create_firstName_input" 
                    <?php
                        //Each one of the inputs has its own span element to act as an error display.
                        //This is so that the user knows which elements it is having the problem with rather than having
                        //to generate specific alerts for each element outside of the specific checks for things
                        //like dates, emails, etc.
                        if(isset($_SESSION['username_taken_error']) && !empty($_SESSION['username_taken_error'])){
                            $first_name = $_SESSION['POST_info']['create_firstName_input'];
                            echo "value = '$first_name'";
                        }
                        else{
                            echo "value placeholder = 'John'";
                        }
                    ?>
                    maxlength="50" type="text" required><br><br>


                    <label id="create_lastName_label"><u>Last name:</u></label><br>
                    <input class="create_account_inputs text_input" name="create_lastName_input"
                    <?php 
                        if(isset($_SESSION['username_taken_error']) && !empty($_SESSION['username_taken_error'])){
                            $first_name = $_SESSION['POST_info']['create_lastName_input'];
                            echo "value = '$first_name'";
                        }
                        else{
                            echo "value placeholder = 'Smith'";
                        }
                    ?>
                    maxlength="50" type="text" required><br><br>


                    <label id="create_dob_label"><u>Date of Birth:</u></label><br>
                    <input class="create_account_inputs not_text_input"  name="create_dob_input"
                    <?php 
                        if(isset($_SESSION['username_taken_error']) && !empty($_SESSION['username_taken_error'])){
                            $first_name = $_SESSION['POST_info']['create_dob_input'];
                            echo "value = '$first_name'";
                        }
                        else{
                            echo "value placeholder = 'DD/MM/YYYY'";
                        }
                    ?>
                    maxlength="10" type="date" required required pattern = "[0-3][0-9]-[0-1][0-9]-[0-9]{4}"><br><br>


                    <label id="create_gender_label"><u>Gender:</u></label><br>
                    <select class="create_account_inputs2 not_text_input" name="create_gender_input" required>
                        <option value="male"
                        <?php
                            if(isset($_SESSION['username_taken_error']) && !empty($_SESSION['username_taken_error']) && $_SESSION['POST_info']['create_gender_input'] == 1){
                                echo " selected";
                            }
                        ?>
                        >Male</option>
                        <option value="female"
                        <?php 
                            if(isset($_SESSION['username_taken_error']) && !empty($_SESSION['username_taken_error']) && $_SESSION['POST_info']['create_gender_input'] == 0){
                                echo " selected";
                            }
                        ?>
                        >Female</option>
                        <option value="other"
                        <?php 
                            if(isset($_SESSION['username_taken_error']) && !empty($_SESSION['username_taken_error']) && $_SESSION['POST_info']['create_gender_input'] == 2){
                                echo " selected";
                            }
                        ?>
                        >Other</option>
                        <option value="none"
                        <?php 
                            if(isset($_SESSION['username_taken_error']) && !empty($_SESSION['username_taken_error']) && $_SESSION['POST_info']['create_gender_input'] == 3){
                                echo " selected";
                            }
                        ?>
                        >None</option>
                    </select><br><br>
                    
                    <span class="error" id="form1Error" style="visibility: hidden">All fields must be filled out!!!</span>
                </div>

                <div class="create_forms hidden" id="form2" name="form2" value="Dform2">
                    <input class="inputID" type="text" style="visibility: hidden" value="2" id="form2inputID">

                    <h4 class="sction_title">Section - 2:</h4>
                    <label id="create_email_label not_text_input"><u>Email:</u></label><br>
                    <input class="create_account_inputs not_text_input" name="create_email_input"
                    <?php 
                        if(isset($_SESSION['username_taken_error']) && !empty($_SESSION['username_taken_error'])){
                            $first_name = $_SESSION['POST_info']['create_email_input'];
                            echo "value = '$first_name'";
                        }
                        else{
                            echo "value placeholder = 'example@gmail.com'";
                        }
                    ?>
                    maxlength="50" type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required><br><br>

                    <label id="create_phone_label"><u>Phone Number:</u></label><br>
                    <input class="create_account_inputs text_input" name="create_phone_input"
                    <?php 
                        if(isset($_SESSION['username_taken_error']) && !empty($_SESSION['username_taken_error'])){
                            $first_name = $_SESSION['POST_info']['create_phone_input'];
                            echo "value = '$first_name'";
                        }
                        else{
                            echo "value placeholder = '05707 002230'";
                        }
                    ?>
                    maxlength="12" type="text" required>
                    <small>Format: 05707 00223#</small>
                    <br><br>
                    <span class="error" id="form2Error" style="visibility: hidden">All fields must be filled out!!!</span>
                </div>


                <div class="create_forms hidden" id="form3" name="form3" value="form3">
                    <input class="inputID" type="text" style="visibility: hidden" value="3" id="form3inputID">

                    <h4 class="sction_title">Section - 3:</h4>
                    <label id="create_post_code_label text_input"><u>Post code:</u></label><br>
                    <input class="create_account_inputs" name="create_post_code_input"
                    <?php 
                        if(isset($_SESSION['username_taken_error']) && !empty($_SESSION['username_taken_error'])){
                            $first_name = $_SESSION['POST_info']['create_post_code_input'];
                            echo "value = '$first_name'";
                        }
                        else{
                            echo "value placeholder = 'BH99 90F'";
                        }
                    ?> 
                    maxlength="9" type="text" required ><br><br>

                    <label id="create_address_label text_input"><u>Address:</u></label><br>
                    <input class="create_account_inputs" name="create_address_input"
                    <?php 
                        if(isset($_SESSION['username_taken_error']) && !empty($_SESSION['username_taken_error'])){
                            $first_name = $_SESSION['POST_info']['create_address_input'];
                            echo "value = '$first_name'";
                        }
                        else{
                            echo "value placeholder = '10 Sandy Lane'";
                        }
                    ?>  
                    maxlength="50" type="text" ><br><br>

                    <label id="create_country_label text_input"><u>Country:</u></label><br>
                    <input class="create_account_inputs" name="create_country_input"
                    <?php 
                        if(isset($_SESSION['username_taken_error']) && !empty($_SESSION['username_taken_error'])){
                            $first_name = $_SESSION['POST_info']['create_country_input'];
                            echo "value = '$first_name'";
                        }
                        else{
                            echo "value placeholder = 'U.S'";
                        }
                    ?>   
                    maxlength="20" type="text" required >
                    <br><br>
                    <span class="error" id="form3Error" style="visibility: hidden">All fields must be filled out!!!</span>
                </div>


                <div class="create_forms hidden" id="form4" name="form4" value="form4">
                    <input class="inputID" type="text" style="visibility: hidden" value="4" id="form4inputID">

                    <h4 class="sction_title">Section - 4:</h4>
                    <label id="create_username_label text_input"><u>Username:</u></label><br>
                    <input class="create_account_inputs" name="create_username_input" value placeholder = "username1234"
                    maxlength="20" type="text" required ><br><br>

                    <label id="create_password_label not_text_input"><u>Password:</u></label><br>
                    <input class="create_account_inputs" type="text" name="create_password_input" required
                    <?php 
                        if(isset($_SESSION['username_taken_error']) && !empty($_SESSION['username_taken_error'])){
                            $first_name = $_SESSION['POST_info']['create_password_input'];
                            echo "value = '$first_name'";
                        }
                        else{
                            echo "value placeholder = 'password'";
                        }
                    ?>
                    >
                    <br><br>
                    <span class="error" id="form4Error" style="visibility: hidden">All fields must be filled out!!!</span>
                </div>

                <div hidden id="hidden_validation">
                    <input type="text" class="create_account_inputs" name="submit_account" value="true" hidden>
                </div>

                <div id="create_account_buttons">
                    <input type="button" name="previous_button" value="Previous" id="previous_button" class="hidden">
                    <input type="button" name="next_button" value="Next" id="next_button" class="displayed">
                    <input type="button" name="submit_button" value="Submit" id="submit_button" class="hidden">
                </div>

                <?php
                    //Next_button and previous_button can be used to toggle between the next and previous divs e.g. next can take you from
                    //from3 (makes it hidden) to form4 (makes it visible) - and the reverse for the previous button.
                    //Submit sends the data to create_account_validation.php - for final validation / sanitisation.
                ?>

                <div id="error_space">
                    <span class="error" id="mainFormError" style="visibility: hidden">All fields must be filled out!!!</span>
                </div>

                <?php
                    //Displays this error when a field hasn't been filled out.
                    if(isset($_SESSION['username_taken_error']) && isset($_SESSION['username_taken_error'])){
                        $_SESSION['username_taken_error'] = "";
                        $_SESSION['POST_info'] = null;
                    }
                ?>
            </form>
        </div>
    </body>
</html>

<?php
    include('footer.php');
?>
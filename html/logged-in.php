<!DOCTYPE html>

<?php
    include('header.php');
?>

<html>
    <head>
        <title>Homepage</title>
        <link rel="stylesheet" href="">
        <meta charset="utf-8"/>
        <meta name="author" content="me" />
        <script type='text/javascript' src="../script/update_account_validation.js?p=<?php print sha1(time()); ?>" defer></script>
        <link rel="stylesheet" href="../style/logged-in_style.css?p=<?php print sha1(time()); ?>" type="text/css">
    </head>

    <?php
    //Include the connection.php file to run it's mysqli functions here:
    require_once('connection.php');
    $table = "customers";
    //Create the connectionClass object from connection.php to run the querying functions here:
    $connection_obj = new connectionClass($table);
    //Get all the information related to the sessions user ID to output in the page
    $data_obj_ASSOC = $connection_obj->retrieve_user_details($_SESSION['userID']);
    ?>

    <body>
        <div id="body2">
            <div id="body3">
                <div id="update_section">
                    <form id="account_details" action="<?php echo htmlspecialchars("validate_update.php"); ?>" method="post">

                        <div id="account_section1">

                            <h3 id="update_account_title">Your Account!:</h3>

                            <label id="first_name_label" for="first_name_input">First Name:</label><br>
                            <input id="first_name_input" name="first_name_input" default value="<?php echo $data_obj_ASSOC[0]['first_name'];?>" 
                            maxlength="50" type="text" required class="text_input">
                            <?php
                                //Set a maxlength on the inputs that matches the database script.
                                //Also make all NOT NULL attributes required for double error prevention against NN errors.
                                //Double whitesapce between input block (whilst decreases consistency, increases readability)
                            ?>
                            <span class="error" id="first_name_inputError" style="visibility: hidden">This field must be filled out</span><br>


                            <label id="last_name_label" for="last_name_input">Last Name:</label><br>
                            <input id="last_name_input" name="last_name_input" default value="<?php echo $data_obj_ASSOC[0]['last_name']; ?>" 
                            maxlength="50" type="text" required class="text_input">
                            <span class="error" id="last_name_inputError" style="visibility: hidden">This field must be filled out</span><br>


                            <label id="dob_label" for="dob_input">Date-Of-Birth:</label><br>
                            <input id="dob_input" name="dob_input" default value="<?php echo $data_obj_ASSOC[0]['dob']; ?>" 
                            maxlength="10" type="date" required pattern = "[0-3][0-9]-[0-1][0-9]-[0-9]{4}">
                            <span class="error" id="dob_inputError" style="visibility: hidden">This field must be filled out</span><br>


                            <label id="gender_label" for="gender_input"><u>Gender:</u></label><br>
                            <select id="gender_input" name="gender_input">
                                <?php
                                    //Make one of the options "selected" if its string value matches the integer one in the database:
                                ?>
                                <option value="male" <?php if(intval($data_obj_ASSOC[0]['gender']) == 1){echo "selected";}?>>Male</option>
                                <option value="female" <?php if(intval($data_obj_ASSOC[0]['gender']) == 0){echo "selected";}?> >Female</option>
                                <option value="other" <?php if(intval($data_obj_ASSOC[0]['gender']) == 2){echo "selected";}?> >Other</option>
                                <option value="none" <?php if(intval($data_obj_ASSOC[0]['gender']) == 3){echo "selected";}?>>None</option>
                            </select>
                            <span class="error" id="gender_inputError" style="visibility: hidden">This field must be filled out</span><br>


                            <label id="email_label" for="email_input">Email:</label><br>
                            <input id="email_input" name="email_input" default value="<?php echo $data_obj_ASSOC[0]['email']; ?>" 
                            maxlength="50" type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
                            <span class="error" id="email_inputError" style="visibility: hidden">This field must be filled out</span><br>


                            <label id="phone_label" for="phone_input">Phone:</label><br>
                            <input id="phone_input" name="phone_input" default value="<?php echo $data_obj_ASSOC[0]['phone']; ?>" 
                            maxlength="12" type="tel" required class="text_input">
                            <?php
                                //Patterns are set in html to make sure attributes are inputted in the correct manner (also more asstetically pleaseing)
                                //The js validation will slighly more indepth and will be able to check more things for slightly more complex attributes (date, postcode)
                            ?>
                            <span class="error" id="phone_inputError" style="visibility: hidden">This field must be filled out</span><br>

                        
                            <label id="post_code_label" for="post_code_input">Post code:</label><br>
                            <input id="post_code_input" name="post_code_input" default value="<?php echo $data_obj_ASSOC[0]['post_code'];?>" 
                            maxlength="9" type="text" required class="text_input">
                            <span class="error" id="post_code_inputError" style="visibility: hidden">This field must be filled out</span><br>


                            <label id="address_label" for="address_input">Address:</label><br>
                            <input id="address_input" name="address_input" default value="<?php echo $data_obj_ASSOC[0]['address']; ?>" 
                            maxlength="50" type="text" class="text_input">
                            <span class="error" id="address_inputError" style="visibility: hidden">This field must be filled out</span><br>


                            <label id="country_label" for="country_input">Country:</label><br>
                            <input id="country_input" name="country_input" default value="<?php echo $data_obj_ASSOC[0]['country'];?>"
                            maxlength="20" type="text" required class="text_input">
                            <span class="error" id="country_inputError" style="visibility: hidden">This field must be filled out</span><br>
                        </div>

                        <div id="logged_in_buttons">
                            <div id="update_buttons">
                                <input type="button" id="update_button_validate" name="update_button_validate" value="Apply Changes" style="visibility: visible">
                                <input type="submit" id="save_changes_button" name="save_changes_button" style="visibility: hidden" value="Save Changes">
                                <?php
                                    //The changes can only be saved (submit button made visible) once they have been applied (validated with JS)
                                    //Once validated they will be sent to validate_update.php
                                ?>
                            </div>     
                        </div>
                    </form>
                </div>

                <div id="admin_section">
                    <?php
                        if($_SESSION['access_level'] == 2){
                            ?>
                                <h3>Admin Settings</h3>
                                <input type="button" value="Products" name="admin_products" onclick="window.location.href='admin_products.php'" id="admin_products">
                                <input type="button" value="Passwords" name="admin_products" onclick="" id="admin_products">
                                <br>
                                <br>
                                <br>
                            <?php
                        }
                    ?>
                    <h3>User Settings</h3>
                    <form id="loggout" action="<?php echo htmlspecialchars("validate_update.php"); ?>" method="post">
                        <input type="submit" id="log-out_button" name="log-out_button" value="Log-out" style="visibility: visible" formnovalidate>
                    </form>

                    <form id="delete_form" method="get" action="delete_account.php?delete=true">
                        <input type="submit" id="delete_account_button" name="delete_account_button" value="Delete account" style="visibility: visible" formnovalidate>
                    </form>
                </div>
            </div>    
        </div>
    </body>
</html>

<?php
    include('footer.php');
?>
<!DOCTYPE html>

<?php
    include('header.php');
    if(!isset($_SESSION['userID']) || empty($_SESSION['userID']) || !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true || $_SESSION['access_level'] != 2){
        header("location: home.php");
    }
    else{
    ?>

    <html>
        <head>
            <title>Homepage</title>
            <link rel="stylesheet" href="../style/add_product.css">
            <meta charset="utf-8"/>
            <meta name="author" content="me"/>
            <script src="../script/create_product_validation.js" defer></script>
            <link rel="stylesheet" href="../style/template.css">
        </head>
        
        <?php
        require_once('connection.php');
        $table_name = "products";
        $connection_obj = new connectionClass($table_name);
        ?>

        <body>
            <div id="body2">
                <?php
                    //This is a pretty basic from to take input for the products details.account_inputs
                    //It is almost exactly the same and works the same way as every other forms on the site - JS validation at run-time
                    //it then send the information to the validation php file where it will check details such as "product_name" to make sure
                    //they arent duplicated in the database, if there is "$_SESSION['product_nameError']" will display an error when it is
                    //detected that it isn't empty.
                ?>
                <form id="create_product_details" action="<?php echo htmlspecialchars("validate_product.php"); ?>" method="post" enctype="multipart/form-data">
                    <div id="create_product_section">
                        <div class="error" id="create_product_name_inputError" style="color: red">
                            <?php
                                if(isset($_SESSION['product_nameError']) && !empty($_SESSION['product_nameError'])){
                                    echo "<h3> " . $_SESSION['product_nameError'] . "</h3>";
                                }
                            ?> 
                        </div>
                        <label id="create_product_name_label" for="create_product_name_input">Product Name:</label><br>
                        <input id="create_product_name_input" name="create_product_name_input" value placeholder="guitar1"
                        maxlength="30" type="text" required class="text_input" required>
                        <span class="error" id="create_product_name_inputError" style="visibility: hidden">This field must be filled out</span><br>

                        <label id="create_product_description_label" for="create_product_description_input">Description of Product:</label><br>
                        <input id="create_product_description_input" name="create_product_description_input" value placeholder="This is a guitar"
                        maxlength="250" type="text" class="text_input" required>
                        <span class="error" id="create_product_description_inputError" style="visibility: hidden">This field must be filled out</span><br>

                        <label id="create_product_price_label" for="create_product_price_input">Product price:</label><br>
                        <input id="create_product_price_input" name="create_product_price_input" value placeholder="5.00"
                        maxlength="10" type="number" min="0.00" max="10000.00" step="0.01" required> 
                        <span class="error" id="create_product_price_inputError" style="visibility: hidden">This field must be filled out</span><br>

                        <label id="create_product_image_label" for="create_product_image_input">Product Image:</label><br>
                        <input type="file" name="create_product_image_input" id="create_product_image_input" required>
                        <span class="error" id="create_product_image_inputError" style="visibility: hidden">You need to upload and Image of the product!</span><br>

                        <label id="create_product_type_label" for="create_product_type_input">Type:</label>
                        <select id="create_product_type_input" name="create_product_type_input" class="text_input" required>
                            <?php
                                //Gets all of the products types from prodcut_types and displays them as options in the select box
                                $product_types = $connection_obj->get_product_types();
                                foreach($product_types as $product_type){
                                    echo '<option value="'.$product_type['product_type_id'].'">'.$product_type['name'].'</option>';
                                }
                            ?>
                        </select>
                        <span class="error" id="create_product_type_inputError" style="visibility: hidden">This field must be filled out</span>
                    </div>

                    <div id="add_buttons">
                        <input type="button" id="add_button_validate" name="add_button_validate" value="Add Product">
                    </div>
                </form>
            </div>
        </body>
    </html>

    <?php
        //Empty the error after it's been displayed:
        $_SESSION['product_nameError'] = "";
        include('footer.php');
    ?>

<?php
    }
?>
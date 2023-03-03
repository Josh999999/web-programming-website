<!DOCTYPE html>

<?php
    include('header.php');
?>

<html>
    <head>
        <title>Homepage</title>
        <link rel="stylesheet" href=<?php echo"../style/display_product_style.css?echo".time()?>>
        <meta charset="utf-8"/>
        <meta name="author" content="me" />
        <script src="../script/create_product_validation.js?p=<?php print sha1(time());?>" defer></script>
        
    </head>

    <?php
        include("connection.php");

        if(isset($_GET['view_products'])){
            $product_id = intval($_GET['product_id']);
        }
        else{
            $product_id = 5;
        }

        if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['type']) && $_GET['type'] == "addToBasket"){
            //Used to check the add-to-basket input
            if(!isset($_SESSION['basket_items'])){
                //creates the basket if it doesnt exist
                $_SESSION['quantity_error'] = "";
                $_SESSION['basket_items'] = array();
            }
                
            if(in_array(intval($_GET['product_id']), array_keys($_SESSION['basket_items']))){
                //Check to see if the product is present in the basket or not
                $num_items = $_SESSION['basket_items'][intval($_GET['product_id'])];
                if(intval($num_items) >= intval($_GET['quantity'])){
                    //Incase the product is still displayed after there are none left
                    $_SESSION['quantity_error'] = "There are no more products left";
                    $linkBack = 'location: display_product.php?product_id=' . $_GET['product_id'] . '&view_products=1';
                   // echo "<a href='products.php?type=$_page_type&next_page=true&page_number=$i&order_by=$_order_by_value'>
                   header($linkBack);
                }
                else{
                    //If it is present it increments to counter
                    $_SESSION['quantity_error'] = "";
                    $_SESSION['basket_items'][intval($_GET['product_id'])] += 1;
                    header("location: home.php");
                }
            }
            else{
                //If not it creates the product in the session and sets the counter to 1
                $_SESSION['quantity_error'] = "";
                $_SESSION['basket_items'][intval($_GET['product_id'])] = 1;
                header("location: home.php");
            }
        }
    ?>
    

    <body>
        <div id="body2">
            <?php
                $table = "products";
                $connection_obj = new connectionClass($table);
                $product = $connection_obj->get_product($product_id);
            ?>
            <br>

            <h3 id="product_title">
                <?php 
                    $product_name = ucfirst($product[0]['name']); 
                ?>
            </h3>

            <form id="create_product_details" action="validate_product_update.php" method="post">
                <article id="view_product">
                    <div id="image_div" class="wrapper">
                        <img id="product_id" src="<?php echo '../script/data/Images/' . $product[0]['image_reference']; ?>"><br>
                        <input type="text" name="hidden_image_ref" id="hidden_image_ref" value="<?php echo $product[0]['image_reference']; ?>" hidden>
                        <?php
                            if(isset($_SESSION['userID']) && !empty($_SESSION['userID']) && isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && $_SESSION['access_level'] == 2){
                                ?>
                                <label id="product_image_label" for="product_image_input">Upload new Image:</label>
                                <input type="file" name="product_image_input" id="product_image_input">
                            <?php
                            }
                        ?>
                    </div>
                    
                    <div id="product_section">
                    <?php
                        //This is the same condition used to display the admin buttons
                        //If the user is a regular customer the products details will be shown in regular uneditable text elements.
                        if(!isset($_SESSION['userID']) || empty($_SESSION['userID']) || !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true || $_SESSION['access_level'] != 2){
                            ?>
                            <div id="content_div">
                                <label id="name_label" for="name_value" >Name:</label><br>
                                <p id="name_value"><?php echo $product_name; ?></p><br><br>

                                <label id="description_label" for="description_value" >Description:</label><br>
                                <p id="description_value"><?php echo $product[0]['description']; ?></p><br><br>

                                <label id="price_label" for="price_value" >Price:</label><br>
                                <p id="price_value"><?php echo $product[0]['price']; ?></p><br><br>

                                <label id="date_listed_label" for="date_listed_value" >Date Listed:</label><br>
                                <p id="date_listed_value"><?php echo $product[0]['date_listed']; ?></p><br><br>

                                <label id="quantity_label" for="quantity_value" >Quantity:</label><br>
                                <p id="quantity_value"><?php echo $product[0]['quantity']; ?></p><br><br>
                            </div>
                            <?php
                        }
                        else{
                            //Otherwise the user will be an admin and the products details will be displayed in editable inputs boxes.account_inputs
                            //The whole section for the product on this page has been turned into a form - However inputs are only displayed when an admin is present
                            //This makes the CSS for the page alot easier as either the way the format of the HTML stays the same, it also means input can only go into
                            //the form if the admin is present on the page.
                            //The submit button for the form is only displayed for the admin aswell, so the form can't be submitted either unless the admin is logged-in.
                            //Submit function is present inside of the JS.
                            ?>
                            <div id="create_product_section">
                                <input type="text" name="hidden_product_id" id="hidden_product_id" value="<?php echo $product[0]['product_id']; ?>" hidden>

                                <label id="name_input_label" for="name_input_value" >Name:</label><br>
                                <input type="text" id="name_input_value" name="name_input_value" value="<?php echo $product_name;?>"
                                required><br><br>
                                <span class="error" id="name_input_valueError" name="name_input_valueError" style="visibility: hidden">Field needs an input</span>

                                <label id="description_input_label" for="description_input_value">Description:</label><br>
                                <textarea id="description_input_value" name="description_input_value" required>
                                    <?php echo $product[0]['description'];?>"
                                </textarea><br><br>
                                <span class="error" id="description_input_valueError" name="description_input_valueError" style="visibility: hidden">Field needs an input</span>

                                <label id="price_input_label" for="price_input_value">Price:</label><br>
                                <input id="price_input_value" name="price_input_value" value="<?php echo $product[0]['price'];?>" 
                                maxlength="10" type="number" min="0.00" max="10000.00" step="0.01" required><br><br>
                                <span class="error" id="price_input_valueError" name="price_input_valueError" style="visibility: hidden">Field needs an input</span>

                                <label id="quantity_input_label" for="quantity_input_value">Quantity:</label><br>
                                <input type="number" type="number" min="0" max="100" step="1" id="quantity_input_value" 
                                name="quantity_input_value" value="<?php echo $product[0]['quantity'];?>" required><br><br>
                                <span class="error" id="quantity_input_valueError" name="quantity_input_valueError" style="visibility: hidden">Field needs an input</span>
                            </div>
                        <?php
                        }
                        ?>
                        <div id="product_buttons" class="title_text">
                            <input type="button" name="add_to_basket_button" id="add_to_basket_button" value="Add-To-Basket" onclick="window.location.href='<?php echo '?type=addToBasket&product_id=' . $product[0]['product_id'] . '&quantity=' . $product[0]['quantity'];?>'">
                            <input type="button" name="update_product_button" id="add_button_validate" value="Update Product"
                            <?php
                                if(!isset($_SESSION['userID']) || empty($_SESSION['userID']) || !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true || $_SESSION['access_level'] != 2){
                                    echo " stlye='visibility: hidden";
                                }
                            ?>>
                            <span name="update_error">
                            <?php
                                //These tigger for different buttons (add to basket and update product respectively)
                                if(!empty($_SESSION['update_product_nameError'])){
                                    echo $_SESSION['update_product_nameError'];
                                }
                                else if(!empty($_SESSION['quantity_error'])){
                                    echo $_SESSION['quantity_error'];
                                }
                            ?>
                            </span>
                        </div>
                    </div>
                </article>
            </form>
        </div>
    </body>
</html>

<?php
    include('footer.php');
?>
<!DOCTYPE html>

<?php
    include('header.php');
?>

<html>
    <head>
        <title>Homepage</title>
        <link rel="stylesheet" href="../style/display_product_style.css">
        <meta charset="utf-8"/>
        <meta name="author" content="me" />
        <script src="file.js" defer></script>
    </head>

    <?php
    require_once('connection.php');
    $table_name1 = "products";
    $table_name2 = "orders";
    $connection_obj = new connectionClass($table_name1);

    if(isset($_SESSION['logged_in']) && !empty($_SESSION['userID'])){
        //Get the basket items from the database
        if(isset($_SESSION['basket_items']) && !empty($_SESSION['basket_items'])){
            $basket_items = $connection_obj->get_basket_items(array_keys($_SESSION['basket_items']));
            //Update basket count:
            $_basket_countItems = count($_SESSION['basket_items']);
            $_SESSION['Error_no_orders'] = "";
        }
        else{
            $_SESSION['Error_no_orders'] = "You don't have any items in your basket yet";
            header("location: basket.php?type=redirected_order");
        }

        //Remove the quantity / items from the database (use $basket_items to help)
        //Run a for loop for each item - add there information to the orders table
        //Then at the end decide if they get deleted or the quantity reduced

        //Identify all information needed for this process:
        //Gather the information:
        //user_id
        //If there is no user_id?? - force the user into a log-in:
        //Redirect to the log-in page and ask them to log-in or create and account before they order:
        $user_id = intval($_SESSION['userID']);
        
        //date_ordered - for mysql has to be a string formatted (YYYY-MM-DD):
        //date_ordered - ommit the date to get the current one:
        //format into a string:
        $date_ordered = new DateTime();
        $date_ordered = $date_ordered->format('Y-m-d');
        
        //order_group - decide which order group they are all going to be part of:
        //Get the next order_group number:
        $order_group = $connection_obj->get_next_order_group();
        
        //Add the group information to the order_groups table:
        $connection_obj->add_order_group($order_group, $user_id, $date_ordered);
        
        //Add each products to the orders table:
        foreach($basket_items as $key => $row){
            //product_id:
            $product_id = intval($row['product_id']);

            //quantity - reduced quantity (current quantity - ordered quantity):
            $quantity = intval($_SESSION['basket_items'][$product_id]);

            //execute the query:
            $connection_obj->add_order($order_group, $quantity, $product_id);

            //Product Decision:
            //Code for quantity reduction:
            $reduced_quantity = intval($row['quantity']) - intval($_SESSION['basket_items'][$product_id]);
            if($reduced_quantity < 1){
                $connection_obj->delete_product($product_id);
            }
            else{
                $connection_obj->remove_quantity($product_id, $reduced_quantity);
            }
        }
    }
    else{
        $_SESSION['Error_order_no_loggin'] = "Please create an account of log-in before you place an order";
        header("location: account.php");
    }

    ?>
    
    <body>
        <div id="body2">
            <article id="ordered_products">
                <br>
                <br>
                <hr>
                <h2>Ordered Items:</h2>
                <?php
                $total_amount_price = 0;
                $total_amount_items = 0;
                for ($i = 0; $i < count($basket_items); $i++){
                    //Overall order calculations:
                    //loop through the basket items
                    $product_id = intval($basket_items[$i]['product_id']);
                    //get the product id as an integer
                    $total_amount_price += number_format($basket_items[$i]['price'], 2) * $_SESSION['basket_items'][$product_id];
                    //Get the price of the item, multiply it by the amount in the basket, then add it to to the total price of the order
                    $total_amount_items += intval($_SESSION['basket_items'][$product_id]);
                    //Increase the total amount of items by the quantity (this will be useful for calulating the average)
                    //Then display the individual product
                    ?>
                    <br>
                    <div class="basket_item">
                        <h3 class="basket_item_tag"><?php echo "Product Name: " . $basket_items[$i]["name"];?></h3>
                        <h4 class="basket_item_tag" value="<?php echo $basket_items[$i]['product_id'];?>"><?php echo "ID: " . $basket_items[$i]['product_id'];?></h4>
                        <h4 class="basket_item_tag" value="<?php echo $_SESSION['basket_items'][$product_id]; ?>"><?php echo "Your amount: " . $_SESSION['basket_items'][$product_id]; ?></h4>
                        <h4 class="basket_item_tag" value="<?php echo $basket_items[$i]['price']; ?>"><?php echo "Your amount: " . $basket_items[$i]['price']; ?></h4>
                    </div>
                    <br>
                    <?php
                }
                //Then display the overall information:
                ?>
                <hr>
                <div id="overall_information">
                    <h4 class="basket_item_tag" value="<?php echo $total_amount_price; ?>"><?php echo "Total amount spent: £" . $total_amount_price; ?></h4>
                    <h4 class="basket_item_tag" value="<?php echo $total_amount_items; ?>"><?php echo "Total amount of items: " . $total_amount_items; ?></h4>
                    <h4 class="basket_item_tag" value="<?php echo number_format($total_amount_price / $total_amount_items); //Calculates the average amount spent per item ?>"><?php echo "Avergae price per item: " . number_format($total_amount_price / $total_amount_items); ?></h4>
                </div>
            </article>
        </div>
    </body>

    <?php
    //Remove the items from the session (maybe transfer them to another part of the session object):
    $_SESSION['basket_items'] = array();
    ?>
</html>

<?php
    include('footer.php');
?>
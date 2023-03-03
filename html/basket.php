<!DOCTYPE html>

<?php
    include('header.php');
?>

<html>
    <head>
        <title>Homepage</title>
        <link rel="stylesheet" href="../style/basket_style.css?p=<?php print sha1(time()); ?>">
        <meta charset="utf-8"/>
        <meta name="author" content="me" />
        <script src="file.js" defer></script>
        
    </head>
    
    
    <?php
        require_once('connection.php');
        $table_name = "products";
        $connection_obj = new connectionClass($table_name);
        
        //Set the Error_no_orders value to null when the GET request hasn't come from the orders page
        if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['type'])){
            if(!$_GET['type'] == "redirected_order"){
                $_SESSION['Error_no_orders'] = null;
            }
        }
        else{
            $_SESSION['Error_no_orders'] = null;
        }

        //Check basket items (this must be done first):
        if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['type'])){
            if($_GET['type'] == "remove"){
                $product_id = intval($_GET['product_id']);
                if($_SESSION['basket_items'][$product_id] > 1){
                    $_SESSION['basket_items'][$product_id] -= 1;
                }
                else{
                    unset($_SESSION['basket_items'][$product_id]);
                }
            }
        }

        //Incase the basket page is visited first it will need to create the basket before the products are added:
        if(isset($_SESSION['basket_items']) && !empty($_SESSION['basket_items'])){
            $basket_items = $connection_obj->get_basket_items(array_keys($_SESSION['basket_items']));
            //Update basket count:
            $_basket_countItems = count($_SESSION['basket_items']);
        }
        else{
            $_SESSION['basket_items'] = array();
            //Still get the variables:
            $basket_items = [];
        }
        $_basket_countItems = count($_SESSION['basket_items']);
    ?>

    <body id="body1">
        <div id="body2">
            <div id="basket_header">
                <h3 id="basket_title">Basket</h3>
                <h4 id="basket_count"><?php echo "Items: $_basket_countItems"; ?></h4>
                <br>
                <input type="button" id="go_to_checkount" name="go_to_checkout" value="<?php echo "Proceed\nto\ncheckout"; ?>" onclick="window.location.href='ordered.php'">
                <span name="no_items_error"><?php if(isset($_SESSION['Error_no_orders']) && !empty($_SESSION['Error_no_orders'])){echo $_SESSION['Error_no_orders'];} ?></span>
            </div>

            <div id="products_display_area">
                <article id="products_display_box">
                    <ul id="basket_items_list">
                        <?php
                        for ($i = 0; $i < count($basket_items); $i++){
                            //This is a pretty simple loop to display each one of the basket items:
                            //It goes through the returned array and displays each one of the items in it.
                            $product_id = intval($basket_items[$i]['product_id']);
                            ?>
                            <li id="<?php echo "list_item$i";?>">
                                <div class="basket_item">
                                <a href="<?php echo "display_product.php?product_id=$product_id&view_products=1"; ?>"><img src="<?php echo "../script/data/Images/" . $basket_items[$i]['image_reference'];?>"></a>
                                    <h3 class="basket_item_tag"><?php echo "Product Name: " . $basket_items[$i]["name"];?></h3>
                                    <h4 class="basket_item_tag" value="<?php echo $basket_items[$i]['product_id'];?>"><?php echo "ID: " . $basket_items[$i]['product_id'];?></h4>
                                    <h4 class="basket_item_tag" value="<?php echo $_SESSION['basket_items'][$product_id]; ?>"><?php echo "Your amount: " . $_SESSION['basket_items'][$product_id]; ?></h4>
                                    <input type="button" value="Remove Item" id="remove_basket_item" name="remove_basket_item" onclick="window.location.href='<?php echo '?type=remove&product_id=' . $product_id; ?>'">
                                </div>
                            </li>
                            <?php
                        }
                        ?>
                    <ul>
                </article>
            </div>
        </div>
    </body>

        
    
</html>

<?php
include('footer.php');
?>
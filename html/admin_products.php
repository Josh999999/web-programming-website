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
            <link rel="stylesheet" href="../style/admin_products.css?p=<?php print sha1(time()); ?>">
            <meta charset="utf-8"/>
            <meta name="author" content="me" />
        </head>
        
        <?php
        require_once('connection.php');
        $table_name = "products";
        $connection_obj = new connectionClass($table_name);

        //Process the delete request:
        if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['delete_product']) && $_GET['delete_product'] == "true"){
            //GET request is a URL so this condition needs to be checked again:
            if(!isset($_SESSION['userID']) || empty($_SESSION['userID']) || !isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true || $_SESSION['access_level'] != 2){
                header("location: home.php");
            }
            else{
                //Clean the id $_GET['product_id']:
                $_GET['product_id'] = intval(htmlspecialchars($_GET['product_id']));
                $connection_obj->delete_product($_GET['product_id']);
            }
        }
        ?>

        <body>
            <h2 id="product_type_header"><?php echo "Welcome to the products Admin page:"; ?></h2>

            <div id="body2">
                <aside id="admin_products_asside_buttons">
                    <h4 class="title_text" id="aside_buttons_title">
                        Manage Products:
                    </h4>
                    <br>
                    <input type="button" value="Add Product" id="add_product" name="add_product" onclick="window.location.href='add_product.php'" class="title_text">
                </aside>

                <div id="products_display_area">
                    <?php
                        $array = $connection_obj->get_all_products();
                        foreach ($array as $row){
                            $product_id = $row['product_id'];
                            //Loop through each row in the queries array:
                                //Each product in the limit query will be diplayed one at a time
                                //All thir information will be put into a div like this one
                            /*Display the image and create a link to view the individual product at display_product.php */
                                //Product title is equal to the products name
                            ?>

                            <?php
                                //Get the date listed:
                                $dt = new DateTime($row['date_listed']);
                                $date_list = $dt->format('m/d/Y');
                            ?>

                            <a href="<?php echo "display_product.php?product_id=$product_id&view_products=1"; ?>">
                                <div class="product_container" id="<?php echo "" . $row['product_id'] . "";?>">
                                    <dl>
                                        <dt><?php echo "<p>Product: " . $row['name'] . ":</p>"; ?></dt>
                                        <dd><?php echo "Name: " . $row['name']; ?></dd>
                                        <dd><?php echo "Price: £" . $row['price']; ?></dd>
                                        <dd><?php echo "Date Listed: " . $date_list; ?></dd>
                                        <dd><?php echo "Product_type: ". $row['product_type_id'];?></dd>
                                        <dd>
                                            <a href="<?php echo "admin_products.php?product_id=$product_id&delete_product=true"; //Adds a delete button to the individual product that links to the delete script in PHP?>">
                                                <input type="button" value="DELETE" onclick="<?php echo "alert('Product: " . $row['name']. " | Has been DELETED')";?>" id="delete_product_button" name="delete_product_button">
                                            </a>
                                        </dd>
                                    </dl>
                                </div>
                            </a>
                        <?php
                        }
                    ?>
                </div>
            </div>
        </body>
    </html>

    <?php
        include('footer.php');
    ?>

<?php
    }
?>
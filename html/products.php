<!DOCTYPE html>

<?php
    include('header.php');
?>

<html>
    <head>
        <title>Homepage</title>
        <link rel="stylesheet" href="../style/products_style.css?p=<?php print sha1(time()); ?>">
        <meta charset="utf-8"/>
        <meta name="author" content="me" />
        <script src="file.js" defer></script>
    </head>
    
    <?php
    require_once('connection.php');
    $table_name = "products";
    $connection_obj = new connectionClass($table_name);

    //Get the page type from the nav bar or the current page on pagination resubmission:
    //There are different type attributes set in the header file for the links to different product types
    //(guitars, products, extra bits) - there attributes are used to determine the product types displayed
    //on the page:
    if ($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['type'])){
        //Get the type attribute from the header file:
        $_page_type = $_GET['type'];
        $_page_type_display = ucfirst($_page_type);
        if ($_GET['order_by'] != "none"){
            $_order_by_value = $_GET['order_by'];
        }
        else{
            $_order_by_value = "product_id";
        }
    }
    else{
        $_order_by_value = "product_id";
    }

    //Used static variables and table information (number of rows, total items for each page) to determine:
        //The total number of pages the need to be displayed.
    $_cur_page = 1;
    if (isset($_GET['page_number'])){
        $_cur_page = $_GET['page_number'];
    }

    $_total_items_pp = 5;
    $nums_rows = null;
    //When you get time role these functions into 1 with an if statement dummy!
    if ($_GET['type'] != "extra"){
        $num_rows = intval($connection_obj->get_num_rows($_page_type_display)[0]['COUNT(*)']);
    }
    else{
        $num_rows = intval($connection_obj->extra_row_count()[0]['COUNT(*)']);
    }
    $total_pages = ceil($num_rows / $_total_items_pp);
    ?>

    <body>
        <h3 id="product_type_header"><?php echo "$_page_type_display"; ?></h3>
        
        <div id="body2">
            
            <aside id="products_sidebar">
                <div id="search_bar">
                    <?php
                    include('search_bar.php');
                    ?>
                </div>

                <div id="sort_list">
                    <?php
                    include('products_nav.php')
                    ?>
                </div>

                <div id="products_nav">
                    <?php
                        //This creates a link to each "page" in the products page by looping through each
                        //number in total_pages and displaying that as a link (represents page number)
                        if ($_cur_page <= $total_pages){
                            for ($i = 1; $i <= $total_pages; $i++){
                                if ($i == $_cur_page){
                                    echo "<a>| $i |</a>";
                                }
                                else{
                                    //Links back to products with information on which page to display
                                    echo "<a href='products.php?type=$_page_type&next_page=true&page_number=$i&order_by=$_order_by_value'>| $i |</a>";
                                }
                            }
                        }
                    ?>
                </div>
            </aside>

            <div id="products_display_area">
                <?php
                    if($_SERVER['REQUEST_METHOD'] == "GET" && isset($_GET['next_page']) or $_cur_page == 1){
                        $_cur_page = $_GET['page_number'];
                        $_limit_lb = ($_cur_page -1) * $_total_items_pp;
                        $array = null;

                        //Decide wether to query it by order_value or normally
                        //It will only be queried by order_value if a GET request has come from the products nav_bar
                        //where order_value is set - if not if should execute as normal.
                        if($_GET['type'] != "extra"){
                            $array = $connection_obj->run_product_limit_query($_limit_lb, $_total_items_pp, $_page_type_display, $_order_by_value);
                        }
                        else{
                            $array = $connection_obj->run_product_extra_limit_query($_limit_lb, $_total_items_pp, $_order_by_value);
                        }

                        $i = $_limit_lb + 1;
                        foreach ($array as $row) {
                            //Loop through each row in the queries array:
                                //Each product in the limit query will be diplayed one at a time
                                //All thir information will be put into a div like this one
                            ?>
                            <div class="product_container" id="<?php echo "" . $row['product_id'] . "";?>">
                            <br>
                                <dl>
                                    <dt><?php echo "<p>Product: " . $row['name'] . ":</p>"; ?></dt>
                                    <?php
                                    //Product title is equal to the products name
                                    $product_id = $row['product_id'];
                                    ?>
                                    <dd><a href="<?php /*Display the image and create a link to view the individual product at display_product.php */
                                            echo "display_product.php?product_id=$product_id&view_products=1"; 
                                        ?>">
                                        <img src="<?php echo "../script/data/Images/" . $row['image_reference'];?>">
                                    </a></dd>
                                    <dd><?php echo "Price: " . $row['price']; ?></dd>
                                </dl>
                            <br>
                            </div>
                            <?php
                            $i++;
                        }
                    }
                ?>
            </div>
        </div>
    </body>
</html>

<?php
    include('footer.php');
?>